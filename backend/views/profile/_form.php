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
<?php echo $form->field($model, 'picture')->widget(
    Upload::classname(),
    [
        'url' => ['profile/avatar-upload'],
        'maxFileSize' => 3000000, // 3 Mb
    ]
); ?>

<div class="row">
  <div class="col-sm-2 col-xs-12">
  <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
  </div>
  <div class="col-sm-5">
  <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>
  </div>
  <div class="col-sm-5">
    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>
  </div>
</div>
<?php echo $form->field($model, 'gender')->dropDownlist($model->genderItems) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('common', 'Update'), ['class' => 'btn btn-success btn-block btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
