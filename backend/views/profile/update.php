<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use vova07\fileapi\Widget as FileAPI;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Profile');
?>

<div class="panel panel-default" style="border-top:none; border-radius: 0 0 3px 3px">
  <div class="panel-body">
    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile
    ]) ?>
  </div>
  <div class="panel-footer">

  </div>
</div>
