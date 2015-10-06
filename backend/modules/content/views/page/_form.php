<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'th',
            'minHeight' => 200,
            'imageManagerJson' => Url::to(['/article/images-get']),
            'fileManagerJson' => Url::to(['/article/files-get']),
            'imageUpload' => Url::to(['/article/image-upload']),
            'fileUpload' => Url::to(['/article/file-upload']),
            'plugins' => [
                'video',
                'fontcolor',
                'clips',
                'fullscreen',
                'imagemanager',
                'filemanager',
            ]
        ]
    ]);?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
