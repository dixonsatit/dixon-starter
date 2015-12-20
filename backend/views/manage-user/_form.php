<?php
use common\models\Branch;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary([$model,$profile]);; ?>
    <div class="panel panel-default" style="padding:20px">
      <div class="panel-body">
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
      </div>
    </div>

    <div class="panel panel-default" style="padding:20px">
      <div class="panel-body">
          <div class="row">
            <div class="col-sm-2 col-xs-12">
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
                <?= $form->field($profile, 'gender')->dropDownlist($profile->genderItems) ?>
              </div>
              <div class="col-sm-6">
              <?= $form->field($profile, 'website')->textInput(['maxlength' => 255]) ?>
              </div>
          </div>
      </div>
    </div>
    <div class="panel panel-default" style="padding:20px">
      <div class="panel-body">

      <?= $form->field($model, 'roles')->checkboxList($model->getAllRoles()) ?>
      <?= $form->field($model, 'status')->radioList($model->getItemStatus()) ?>
    </div>
  </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
