<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\File;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use Yii;

class FileBehavior extends Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeDelete($event)
    {
        if($this->fileExits()) {
            throw  new  \DomainException("Удаление невозможно, пока в системе имеется сканированная копия документа, содержащая эти данные");
        }
    }


    private function fileExits(): bool
    {
        return File::find()->model($this->owner::className())->recordId($this->owner->id)->exists();
    }


}