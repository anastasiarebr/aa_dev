<?php


namespace modules\entrant\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\CseViSelect;

class CseViSelectHelper
{
    public static function modelOne($userId): ?CseViSelect
    {
        return $cseSubjectResult = CseViSelect::findOne(['user_id' => $userId]);
    }

    public static function inKeyVi($key, array $data) {
        if($data) {
            if(in_array($key, $data)) {
                return 'Вступительное испытание';
            }
        }
        return null;
    }

    public static function inKeyCse($key, array $data, $n = null) {
        if($data) {
            if(array_key_exists($key, $data)) {
                return !is_null($n) ? $data[$key][$n] :'EГЭ';
            }
        }
        return null;
    }

    public static function isCorrect($userId) {
        $model =  self::modelOne($userId);
        $data = true;
        $exams = DictCompetitiveGroupHelper::groupByExams($userId);
        foreach($exams as $i => $item){
            $data = $model ? (self::inKeyVi($i, $model->dataVi()) ??  self::inKeyCse($i, $model->dataCse())) : false;
            if(!$data) {
                break;
            }
        }
        if (DictCompetitiveGroupHelper::bachelorExistsUser($userId) && !CseSubjectHelper::cseSubjectExists($userId)){
            return $data;
        }
       return true;
    }


}