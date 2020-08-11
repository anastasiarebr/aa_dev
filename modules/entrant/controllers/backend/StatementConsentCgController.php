<?php

namespace modules\entrant\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\searches\StatementConsentSearch;
use modules\entrant\services\StatementConsentCgService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class StatementConsentCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementConsentCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    public function actionNew()
    {
        $searchModel = new StatementConsentSearch($this->jobEntrant, StatementHelper::STATUS_WALT);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);

        return $this->render('new', [
            'dataProvider' => $dataProvider,
        ]);
    }




    public function actionIndex($status = null)
    {
        $searchModel = new StatementConsentSearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusView($id)
    {
        $this->findModel($id);
        try {
            $this->service->statusView($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusReset($id)
    {
        $this->findModel($id);
        try {
            $this->service->statusDraft($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $statement = $this->findModel($id);
        $this->render('view', ['statement' => $statement]);
    }
    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statementConsent= $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-consent-cg/pdf/_main', ["statementConsent" => $statementConsent ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameConsent( ".pdf"));
        $render = $pdf->render();
        return $render;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementConsentCg
    {
        if (($model = StatementConsentCg::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }



}