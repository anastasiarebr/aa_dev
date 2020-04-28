<?php


namespace modules\entrant\forms;
use modules\entrant\models\AdditionalInformation;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalInformationForm extends Model
{
    public $voz_id, $user_id, $resource_id, $hostel_id;

    private $_additionalInformation;

    public function __construct(AdditionalInformation $additionalInformation = null, $config = [])
    {
        if($additionalInformation){
            $this->setAttributes($additionalInformation->getAttributes(), false);
            $this->_additionalInformation= $additionalInformation;
        }
        $this->user_id = \Yii::$app->user->identity->getId();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['resource_id',], 'required'],
            [['voz_id', 'resource_id', 'hostel_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new AdditionalInformation())->attributeLabels();
    }

}