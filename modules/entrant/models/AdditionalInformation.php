<?php


namespace modules\entrant\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\forms\AdditionalInformationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%additional_information}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $resource_id
 * @property integer $voz_id
 * @property  integer $hostel_id
 **/

class AdditionalInformation extends YiiActiveRecordAndModeration
{
    public static function tableName()
    {
        return  "{{%additional_information}}";
    }

    public function behaviors()
    {
        return ['moderation' => [
            'class' => ModerationBehavior::class,
            'attributes' => [
                'resource_id', 'voz_id', 'hostel_id']
        ]];
    }

    public static  function create(AdditionalInformationForm  $form) {
        $additional = new static();
        $additional->data($form);
        return $additional;
    }

    public function data(AdditionalInformationForm $form)
    {
        $this->voz_id = $form->voz_id;
        $this->user_id = $form->user_id;
        $this->resource_id = $form->resource_id;
        $this->hostel_id = $form->hostel_id;
    }

    public function attributeLabels()
    {
        return [
            'voz_id' => "Нуждаюсь в создании специальных условий для лиц с ОВЗ и инвалидов при проведении вступительных испытаний?",
            'hostel_id' => 'Нуждаюсь в общежитии?',
            'resource_id'=> 'Откуда узнали об МПГУ?',
            'user_id' =>   'Юзер ID',
            'voz' => "Нуждаюсь в создании специальных условий для лиц с ОВЗ и инвалидов при проведении вступительных испытаний?",
            'hostel' => 'Нуждаюсь в общежитии?',
            'resource'=> 'Откуда узнали об МПГУ?',

        ];
    }

    public function getResource()
    {
        return DictDefaultHelper::infoName($this->resource_id);
    }

    public function getHostel()
    {
        return DictDefaultHelper::name($this->hostel_id);
    }

    public function getVoz()
    {
       return DictDefaultHelper::name($this->voz_id);
    }

    public function dataArray(): array
    {
        return  [
            'voz' => $this->voz_id,
            'hostel' => $this->hostel_id,
        ];
    }

    public function titleModeration(): string
    {
        return "Дополнительная информация";
    }

    public function moderationAttributes($value): array
    {
        return [
            'voz_id' => DictDefaultHelper::name($value),
            'hostel_id' => DictDefaultHelper::name($value),
            'resource_id'=> DictDefaultHelper::infoName($value),
        ];
    }
}