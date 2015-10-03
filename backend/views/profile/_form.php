<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($profile, 'picture')->widget(
    Upload::classname(),
    [
        'url' => ['profile/avatar-upload'],
        'maxFileSize' => 3000000, // 3 Mb
    ]
); ?>

<div class="row">
  <div class="col-sm-2">
  <?php echo $form->field($profile, 'title')->textInput(['maxlength' => 255]) ?>
  </div>
  <div class="col-sm-5">
  <?php echo $form->field($profile, 'firstname')->textInput(['maxlength' => 255]) ?>
  </div>
  <div class="col-sm-5">
    <?php echo $form->field($profile, 'lastname')->textInput(['maxlength' => 255]) ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <?php echo $form->field($profile, 'gender')->dropDownlist($profile->genderItems) ?>
  </div>
  <div class="col-sm-6">
    <?php echo $form->field($profile, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>
  </div>
</div>





    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <div class="row">
      <div class="col-lg-6">
          <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
      </div>
      <div class="col-lg-6">
        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
      </div>
    </div>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('app', 'Update'), ['class' => 'btn btn-success btn-block btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
