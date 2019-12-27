<?php

namespace backend\controllers\sending;

use common\sending\forms\SendingCreateForm;
use common\sending\forms\SendingEditForm;
use common\sending\forms\SendingForm;
use common\sending\models\Sending;
use common\sending\services\SendingService;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class SendingController extends Controller
{
    private $service;

    public function __construct($id, $module, SendingService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

//    public function behaviors(): array
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Sending::find()->orderByStatusDeadlineAsc();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $form = new SendingCreateForm();
//        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($form);
//        }
//        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
//            try {
//                $this->service->create($form);
//            } catch (\DomainException $e) {
//                Yii::$app->errorHandler->logException($e);
//                Yii::$app->session->setFlash('error', $e->getMessage());
//            }
//            return $this->redirect(Yii::$app->request->referrer);
//        }
//        return $this->renderAjax('create', [
//            'model' => $form,
//        ]);
//    }
//
//    /**
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//        $form = new SendingEditForm($model);
//        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($form);
//        }
//        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
//            try {
//                $this->service->edit($model->id, $form);
//            } catch (\DomainException $e) {
//                Yii::$app->errorHandler->logException($e);
//                Yii::$app->session->setFlash('error', $e->getMessage());
//            }
//            return $this->redirect(Yii::$app->request->referrer);
//        }
//        return $this->renderAjax('update', [
//            'model' => $form,
//            'specialTypeOlimpic' => $model,
//        ]);
//    }
//
//    /**
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException
//     */
//    protected function findModel($id): Sending
//    {
//        if (($model = Sending::findOne($id)) !== null) {
//            return $model;
//        }
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }
//
//    /**
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        try {
//            $this->service->remove($id);
//        } catch (\DomainException $e) {
//            Yii::$app->errorHandler->logException($e);
//            Yii::$app->session->setFlash('error', $e->getMessage());
//        }
//        return $this->redirect(Yii::$app->request->referrer);
//    }

}