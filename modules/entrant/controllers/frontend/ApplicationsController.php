<?php

namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\services\ApplicationsService;
use yii\web\Controller;
use Yii;

class ApplicationsController extends Controller
{
    private $service;

    public function __construct($id, $module, ApplicationsService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetCollege($department)
    {
        $currentFaculty = $this->currentFaculty($department, DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        return $this->render('get-college', [
            'currentFaculty' => $currentFaculty,
            'anketa'=> $this->getAnketa(),
        ]);
    }

    /**
     * @param $faculty
     * @param $eduLevel
     * @param null $specialRight
     * @return array
     * @throws \yii\base\ExitException
     */
    private function currentFaculty($faculty,
                                    $eduLevel,
                                    $specialRight = DictCompetitiveGroupHelper::USUAL,
                                    $foreignStatus = false,
                                    $tpguStatus = false)
    {
        $settingEntrant = SettingEntrant::find()
            ->type(SettingEntrant::ZUK)
            ->faculty($faculty)
            ->specialRight($specialRight)
            ->foreign($foreignStatus)
            ->tpgu($tpguStatus);

        $this->isOpenEduLevel($settingEntrant->eduLevelOpen($eduLevel));

        $this->permittedLevelChecked($eduLevel);

        if($foreignStatus) {
            $this->isGovLineControl();
        }

        $forms = $settingEntrant->groupData($eduLevel, 'form_edu');

        $query = DictCompetitiveGroup::find();

        if($faculty == AnketaHelper::HEAD_UNIVERSITY) {
            $query->notInFaculty();
        }else {
            $query->faculty($faculty);
        }

        return $query->allActualFaculty($eduLevel, $forms);
    }

    /**
     * @param $isOpen
     * @throws \yii\base\ExitException
     */
    private function isOpenEduLevel($isOpen)
    {
        if(!$isOpen) {
            Yii::$app->session->setFlash('info', 'Прием документов окончен!');
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        }
    }

    /**
     * @param $level
     * @throws \yii\base\ExitException
     */
    private function permittedLevelChecked($level)
    {
        if (!in_array($level, $this->anketa->getPermittedEducationLevels())) {
            Yii::$app->session->setFlash("error", "Уровень образования недоступен!");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        }
    }

    /**
     * @throws \yii\base\ExitException
     */
    private function isGovLineControl()
    {
        if(!$this->anketa->isGovLineIncoming())
        {
            Yii::$app->session
                ->setFlash("error", "Ваши анкетные данные не соответствуют данным образовательным программам");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step1']);
            Yii::$app->end();
        }
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetBachelor($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetTargetBachelor($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, DictCompetitiveGroupHelper::TARGET_PLACE);
        return $this->render('get-target-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetSpecialRightBachelor($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, DictCompetitiveGroupHelper::SPECIAL_RIGHT);
        return $this->render('get-special-right-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetMagistracy($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetTargetMagistracy($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER, DictCompetitiveGroupHelper::TARGET_PLACE);
        return $this->render('get-target-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetGraduate($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetMpguTpgu($department)
    {
        $currentFaculty = $this->currentFaculty($department,DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
            DictCompetitiveGroupHelper::USUAL, false, true);
        return $this->render('get-mpgu-tpgu', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetTargetGraduate($department)
    {
        $currentFaculty = $this->currentFaculty($department,
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL,
            DictCompetitiveGroupHelper::TARGET_PLACE);
        return $this->render('get-target-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetGovLineBachelor($department)
    {
        $currentFaculty = $this->currentFaculty($department,
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
            DictCompetitiveGroupHelper::USUAL, true);
        return $this->render('get-gov-line-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetGovLineMagistracy($department)
    {
        $educationLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;
        $currentFaculty = $this->currentFaculty($department,
            $educationLevel, DictCompetitiveGroupHelper::USUAL, true);

        return $this->render('get-gov-line-magistracy', [
            'currentFaculty' => $currentFaculty,
            'educationLevel' => $educationLevel,
        ]);
    }

    /**
     * @param $department
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetGovLineGraduate($department)
    {
        $educationLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
        $currentFaculty = $this->currentFaculty($department,$educationLevel, DictCompetitiveGroupHelper::USUAL, true);

        return $this->render('get-gov-line-graduate', [
            'currentFaculty' => $currentFaculty,
            'educationLevel' => $educationLevel,
        ]);
    }

    /**
     * @param $id
     * @param null $cathedra_id
     * @return \yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionSaveCg($id, $cathedra_id = null)
    {
        try {
            $cg = $this->service->saveCg($id, $cathedra_id, $this->anketa);
            return  $this->isAjaxPageCg($cg);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * @param DictCompetitiveGroup $cg
     * @return \yii\web\Response
     * @throws \yii\base\ExitException
     */
    protected function isAjaxPageCg(DictCompetitiveGroup $cg) {
        if (\Yii::$app->request->isAjax) {
            return $this->renderList($cg);
        }
        return $this->redirect("/abiturient/applications/". DictCompetitiveGroupHelper::getUrl($cg));
    }

    /**
     * @param DictCompetitiveGroup $cg
     * @return mixed
     * @throws \yii\base\ExitException
     */
    protected function renderList(DictCompetitiveGroup $cg)
    {
        $keyFaculty = DictFacultyHelper::getKeyFacultySetting($cg->faculty_id);
        $currentFaculty = $this->currentFaculty($keyFaculty,
            $cg->edu_level,
            $cg->special_right_id,
            $cg->foreigner_status,
            $cg->tpgu_status);
        $url = DictCompetitiveGroupHelper::getUrl($cg);
        $method = \Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method($url, [
            'currentFaculty' => array_unique($currentFaculty),
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionRemoveCg($id)
    {
        try {
            $cg = $this->service->removeCg($id);
            return $this->isAjaxPageCg($cg);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * @return \yii\web\Response
     */
    protected function getAnketa()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return \Yii::$app->user->identity->anketa();
    }
}