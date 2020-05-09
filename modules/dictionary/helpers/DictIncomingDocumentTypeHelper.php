<?php
namespace modules\dictionary\helpers;

use dictionary\helpers\DictCountryHelper;
use modules\dictionary\models\DictIncomingDocumentType;
use yii\helpers\ArrayHelper;

class DictIncomingDocumentTypeHelper
{
    const TYPE_OTHER = null;
    const TYPE_EDUCATION = 1;
    const TYPE_PASSPORT = 2;
    const TYPE_MEDICINE= 3;

    const TYPE_EDUCATION_VUZ= 4;
    const TYPE_EDUCATION_PHOTO= 5;
    const TYPE_DIPLOMA= 6;

    const ID_PHOTO= 45;
    const ID_MEDICINE= 29;

    const ID_PASSPORT_RUSSIA = 1;

    public static function listType($type)
    {
        return ArrayHelper::map(self::find($type)->all(), 'id', 'name');
    }

    public static function listPassport($country)
    {
        $array = self::find(self::TYPE_PASSPORT)->select('name')->indexBy('id')->column();
        if($country == DictCountryHelper::RUSSIA) {
            $delete_keys = [3, 16, 8, 7, 11, 14, 15];
        }else {
            $delete_keys = [1,4, 2,5,6, 10,12];
        }
        return array_diff_key($array, array_flip($delete_keys));
    }

    public static function rangePassport($country)
    {
        return array_values(array_flip(self::listPassport($country)));
    }

    public static function rangeType($type)
    {
        return self::find($type)->select('id')->column();
    }

    private static function find($type)
    {
        return DictIncomingDocumentType::find()->type($type);
    }

    public static function typeName($type, $key): ? string
    {
        return ArrayHelper::getValue(self::listType($type), $key);
    }




}