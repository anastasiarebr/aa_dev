<?php
namespace modules\entrant\widgets\agreement;

use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use yii\base\Widget;

class AgreementWidget extends Widget
{
    public $userId;
    public $view;
    public function run()
    {
        $model = Agreement::findOne(['user_id' => $this->userId, 'year' =>"2019-2020"]);
        return $this->render($this->view, [
            'model'=> $model,
        ]);
    }
}
