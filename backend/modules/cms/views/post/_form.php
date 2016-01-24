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
/* @var $this yii\web\View */
/* @var $model backend\modules\cms\models\Article */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
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

    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-body" style="min-height:252px;">
                <?php echo $form->field($model, 'thumbnail')->widget(
                    Upload::className(),
                    [
                        'url' => ['post/upload'],
                        'maxFileSize' => 5000000, // 5 Mb
                    ]);
                ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
          <div class="panel panel-default">
              <div class="panel-body">
                    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Category::find()->noParents()->all(),'id','name'),
                    'options' => ['placeholder' => 'Select a category ...'],
                    'pluginOptions' => [
                       'allowClear' => true,
                    ],
                    ]); ?>

                    <?= $form->field($model, 'tagValues')->widget(Select2::classname(), [
                    'data' => $model->getAllTag(),
                    'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
                    'pluginOptions' => [
                      'tags' => true,
                       'allowClear' => true,

                    ],
                    ]); ?>

                    <?= $form->field($model, 'view')->widget(Select2::classname(), [
                    'data' => ['main'=>'Default'],
                    'options' => ['placeholder' => 'Select a layout ...'],
                    'pluginOptions' => [
                       'allowClear' => true,
                    ],
                    ]); ?>
              </div>
          </div>
      </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'published_at')->widget(DateTimePicker::className(),[
                        'options' => ['placeholder' => 'Select date time ...'],
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd H:i:s',

                            'todayHighlight' => true
                        ]
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'status')->checkBox() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $form->field($model, 'attachments')->widget(
                Upload::className(),
                [
                    'url' => ['post/upload'],
                    'sortable' => true,
                    'maxFileSize' => 10000000, // 10 Mb
                    'maxNumberOfFiles' => 100
                ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
