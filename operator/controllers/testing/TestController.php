<?php

namespace operator\controllers\testing;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use testing\forms\search\TestSearch;
use testing\forms\TestAndQuestionsTableMarkForm;
use testing\forms\TestCreateForm;
use testing\forms\TestEditForm;
use testing\models\Test;
use testing\models\TestAndQuestions;
use testing\services\TestAndQuestionsService;
use testing\services\TestService;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class TestController extends Controller
{
    private $service;
    private $testAndQuestionsService;

    public function __construct($id, $module, TestService $service, TestAndQuestionsService $testAndQuestionsService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testAndQuestionsService = $testAndQuestionsService;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->findOlympic($model->olimpic_id);
        $modelTestAndQuestions= TestAndQuestions::find()->where(['test_id'=> $model->id])->indexBy('id')->all();
        $testAndQuestion = new TestAndQuestionsTableMarkForm($modelTestAndQuestions);
        if (Model::loadMultiple($testAndQuestion->arrayMark, Yii::$app->request->post())) {
            try {
                $this->testAndQuestionsService->addMark($testAndQuestion);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
               return $this->redirect(['view','id'=> $model->id]);
        }

        return $this->render('@backend/views/testing/test/view', [
            'test' => $model,
            'testAndQuestion' =>$testAndQuestion
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($olympic_id)
    {
        $olympic = $this->findOlympic($olympic_id);
        $form = new TestCreateForm($olympic);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('@backend/views/testing/test/create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new TestEditForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('@backend/views/testing/test/update', [
            'model' => $form,
            'Test' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Test
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findOlympic($id): OlimpicList
    {
        if (($model = OlimpicList::find()->where(['id'=>$id,'olimpic_id'=>OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionStart($id)
    {
        try {
            $this->service->start($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionEnd($id)
    {
        try {
            $this->service->end($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}