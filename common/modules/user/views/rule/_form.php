<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Rule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rule-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'className')->textInput(['maxlength' => true]) ?>
    <div class="form-group text-right">
        <?= Html::submitButton(Yii::t('user', 'Create Rule'), ['class' =>  'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
