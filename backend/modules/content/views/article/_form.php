<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;
use common\models\ArticleCategory;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
<div class="article-form panel panel-default">
  <div class="panel-heading">Details</div>
<div class="panel-body">

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



  </div>
  </div>
  <div class="panel panel-default">
  <div class="panel-heading">Upload File</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <?php echo $form->field($model, 'thumbnail')->widget(
            Upload::className(),
            [
                'url' => ['/article/upload'],
                'maxFileSize' => 5000000, // 5 Mb
            ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php echo $form->field($model, 'attachments')->widget(
            Upload::className(),
            [
                'url' => ['/article/upload'],
                'sortable' => true,
                'maxFileSize' => 10000000, // 10 Mb
                'maxNumberOfFiles' => 10
            ]);
        ?>
      </div>
    </div>
  </div>
</div>
  <div class="panel panel-default">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
              ArticleCategory::find()->active()->all(),
              'id',
              'title'
          ), ['prompt'=>'']) ?>

      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'published_at')->widget(DateTimePicker::className(),[
             'options' => ['placeholder' => 'Select operating time ...'],
             'pluginOptions' => [
               'autoclose' => true,
               'todayHighlight' => true
             ]
          ]) ?>

      </div>
    </div>
<?= $form->field($model, 'status')->checkbox() ?>


</div>
</div>
<div class="form-group pull-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'). ' btn-lg']) ?>
</div>

  <?php ActiveForm::end(); ?>
