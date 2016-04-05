<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use backend\modules\cms\models\Category;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">


    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?php if(Yii::$app->getModule('cms')->contentType == 'markdown'): ?>
            <?= $form->field($model, 'body')->widget(
                MarkdownEditor::classname(),
                ['height' => 300, 'encodeLabels' => false]
            ); ?>
          <?php else : ?>
            <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
                'settings' => [
                    'lang' => 'th',
                    'minHeight' => 200,
                    'imageManagerJson' => Url::to(['/cms/post/images-get']),
                    'fileManagerJson' => Url::to(['/cms/post/files-get']),
                    'imageUpload' => Url::to(['/cms/post/image-upload']),
                    'fileUpload' => Url::to(['/cms/post/file-upload']),
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
          <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">

        <div class="panel panel-default">
          <div class="panel-body">
              
              <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' btn-lg btn-block']) ?>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-body">
              <?= $form->field($model, 'status')->checkBox() ?>
            <?= $form->field($model, 'view')->widget(Select2::classname(), [
            'data' => ['main'=>'Default'],
            'options' => ['placeholder' => 'Select a layout ...'],
            'pluginOptions' => [
               'allowClear' => true,
            ],
            ]); ?>

          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <?php echo $form->field($model, 'thumbnail')->widget(
                Upload::className(),
                [
                    'url' => ['page/upload'],
                    'maxFileSize' => 5000000, // 5 Mb
                ]);
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <?php echo $form->field($model, 'attachments')->widget(
            Upload::className(),
            [
                'url' => ['page/upload'],
                'sortable' => true,
                'maxFileSize' => 10000000, // 10 Mb
                'maxNumberOfFiles' => 100
            ]);
        ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
