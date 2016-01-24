<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Role */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="role-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'data')->textarea(['rows' => 2]) ?>
  <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
  <?= $form->field($model, 'ruleName')->dropdownList(ArrayHelper::map(Yii::$app->authManager->getRules(),'name','name'),['maxlength' => true,'prompt'=>' Select Rule']) ?>
  <div class="form-group text-right">
      <?= Html::submitButton( Yii::t('user', 'Create Permission') , ['class' => 'btn btn-primary btn-lg']) ?>
  </div>


  <?php ActiveForm::end(); ?>

</div>
