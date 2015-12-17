<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\cms\models\Category;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textArea(['maxlength' => true]) ?>



    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Category::find()->all(),'id','name'),
    'options' => ['placeholder' => 'Select a category ...'],
    'pluginOptions' => [
       'allowClear' => true,
    ],
    ]); ?>
    
      <?= $form->field($model, 'status')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
