<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset/confirm', 'token' => $user->password_reset_token]);
?>
Здравствуйте!
Перейдите по ссылке ниже, чтобы сбросить пароль:

<?= $resetLink ?>
