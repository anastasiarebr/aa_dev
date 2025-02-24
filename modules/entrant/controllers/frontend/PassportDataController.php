<?php


namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\dictionary\models\DictIncomingDocumentType;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\services\PassportDataService;
use Mpdf\Tag\P;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class PassportDataController extends Controller
{
    private $service;

    public function __construct($id, $module, PassportDataService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new PassportDataForm($this->getUserId());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'neededCountry' => false,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */

    public function actionCreateBirthDocument()
    {
        $form = new PassportDataForm($this->getUserId(), null, ['nationality', 'number', 'date_of_issue', 'authority','date_of_birth']);
        $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT;
        $form->date_of_birth = \date("d.m.Y",strtotime($this->findPassportDateBirth())) ?? null;
        $form->nationality = DictCountryHelper::RUSSIA;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, true);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'neededCountry' => true,

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
        $form = new PassportDataForm($model->user_id, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'neededCountry' => false,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionUpdateBirthDocument($id)
    {
        $model = $this->findModel($id);
        $form = new PassportDataForm($model->user_id, $model, ['nationality', 'number', 'date_of_issue', 'authority']);
      //  $form->date_of_birth = null;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form, true);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'neededCountry' => true,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): PassportData
    {
        if (($model = PassportData::findOne(['id' => $id, 'user_id' => $this->getUserId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
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
        return $this->redirect(['default/index']);
    }

    private function getUserId()
    {
        if(!Yii::$app->user->identity->getId()){
          return $this->redirect('/account/login');
        }
        return Yii::$app->user->identity->getId();
    }
    private function findPassportDateBirth()
    {
       $passport = PassportData::find()->andWhere(['user_id'=>$this->getUserId()])->andWhere(['main_status'=>true])->one();
       return $passport->date_of_birth;
    }
}