<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/registration/confirm', 'token' => $token->token]);
?>
  Hello <?= Html::encode($user->username) ?>,

Follow the link below to active your account:

<?= $confirmLink ?>
