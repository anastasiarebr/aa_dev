<?php


namespace modules\entrant\controllers;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\services\OtherDocumentService;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class OtherDocumentController extends Controller
{
    private $service;

    public function __construct($id, $module, OtherDocumentService $service, $config = [])
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
     *
     * @return mixed
     */

    public function actionCreate()
    {
       $form = new OtherDocumentForm();
       $this->formCreate($form, ['default/index']);
       return $this->render('create', ['model' => $form]);
    }

    public function actionExemption($category, $type = null)
    {
        $form = new OtherDocumentForm(null,
            $category,
            $this->arrayRequired($category),
            [DictIncomingDocumentTypeHelper::TYPE_OTHER]);
        $this->formCreate($form, ['anketa/step2']);
        $form->type = $type;
        return $this->render("exemption", ["model" => $form]);
    }

    private function formCreate($form, $urlRedirect)
    {
        /* @var $form OtherDocumentForm */

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return  $this->redirect($urlRedirect);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }

    private function arrayRequired($category){
        $array =  ['series', 'number', 'authority','date'];
        if($category) {
            array_push($array, 'exemption_id');
        }
        return $array;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new OtherDocumentForm($model);
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
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OtherDocument
    {
        if (($model = OtherDocument::findOne(['id'=>$id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
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
}