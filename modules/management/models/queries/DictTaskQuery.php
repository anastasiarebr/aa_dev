<?php

namespace modules\management\models\queries;

use modules\management\models\ManagementUser;
use yii\db\ActiveQuery;

/**
 * @property $name string
 * @property $color string
 * @property $id integer
 */
class DictTaskQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function allColumn(): array
    {
        return $this->select(['name'])->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public function allColumnUser($user_id): array
    {
        return $this->joinWith('managementTask')
            ->innerJoin(ManagementUser::tableName(). 'mu', 'mu.post_management_id = management_task.post_management_id')
            ->andWhere(['mu.user_id'=> $user_id])
            ->select(['name'])
            ->indexBy('id')
            ->column();
    }

}