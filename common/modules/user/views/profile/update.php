<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('common', 'Update Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" >
  <!-- <div class="panel-heading">
    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
  </div> -->
  <div class="panel-body">
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
  <?php echo $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>
        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('common', 'Update Profile'), ['class' => 'btn btn-success btn-md']) ?>
        </div>

        <?php ActiveForm::end(); ?>
  </div>
  <!-- <div class="panel-footer">

  </div> -->
</div>
