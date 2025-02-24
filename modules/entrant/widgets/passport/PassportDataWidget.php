<?php
namespace modules\entrant\widgets\passport;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\PassportData;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PassportDataWidget extends Widget
{
    public $userId;
    public $view = "index";
    public function run()
    {
        $query = PassportData::find()->where(['user_id' => $this->userId, 'main_status'=> false])
            ->andWhere(['not in','type', [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'userId'=> $this->userId,
        ]);
    }

}
