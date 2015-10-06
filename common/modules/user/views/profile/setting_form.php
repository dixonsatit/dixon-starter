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
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->errorSummary($model); ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($profile, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>
        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('common', 'Update'), ['class' => 'btn btn-success btn-md']) ?>
        </div>

        <?php ActiveForm::end(); ?>
  </div>
  <div class="panel-footer">

  </div>
</div>
