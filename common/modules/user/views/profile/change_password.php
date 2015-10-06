<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('common', 'Account Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default" >
  <div class="panel-heading">
    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
  </div>
  <div class="panel-body">
    <?php $form = ActiveForm::begin([
         'id' => 'change-password-form',
         'enableAjaxValidation' => true,
      ]); ?>

        <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'confirm_new_password')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('common', 'Update Password'), ['class' => 'btn btn-success btn-md']) ?>
        </div>

        <?php ActiveForm::end(); ?>
  </div>
  <div class="panel-footer">

  </div>
</div>
