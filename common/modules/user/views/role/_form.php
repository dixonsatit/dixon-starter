<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

  <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>



  <div class="form-group text-right">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('user', 'Create Permission') : Yii::t('user', 'Update Permission'), ['class' =>($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' btn-lg']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
