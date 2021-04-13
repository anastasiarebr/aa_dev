<?php

namespace common\auth\models;

use common\auth\forms\SignupForm;
use common\auth\forms\UserEmailForm;

use common\auth\forms\UserEditForm as UserDefault;
use olympic\forms\auth\UserEditForm;
use olympic\forms\auth\UserCreateForm;
use common\auth\helpers\UserHelper;
use olympic\models\auth\AuthAssignment;
use olympic\models\auth\Profiles;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $user_id
 * @property string $token
 */
class UserFirebaseToken extends ActiveRecord
{
    public static function create($userId, $token): self
    {
        $user = new static();
        $user->user_id = $userId;
        $user->token = $token;
        return $user;
    }

    public static function tableName()
    {
        return '{{%user_firebase_token}}';
    }
}
