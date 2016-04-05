<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-hover'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:30px']],
            [
              'attribute'=>'title',
              'linkStyle'=>'buttongroup', // default, buttongroup
              'labelStyle'=>'iconText', // icon,text,iconText
              'class'=>'\dixonstarter\grid\TitleActionColumn',
            ],
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'status',
            // 'category_id',
            // 'created_at',
            // [
            //   'attribute'=>'updated_at',
            //   'format'=>'dateTime',
            //   'options'=>['style'=>'width:200px;'],
            // ],
            // 'created_by',
            // 'updated_by',
            [
              'attribute'=>'authorName',
              'options'=>['style'=>'width:100px;'],
            ],
            [
              'attribute'=>'status',
              'format'=>'html',
              'filter'=>$searchModel->getItemStatus(),
              'value'=>function($model){
                  return '<span class="label '.($model->status=='1' ? 'label-primary' : 'label-info').'">'.$model->statusName.'</span></h3>';
              },
              'options'=>['style'=>'width:120px;'],
            ],
            [
              'attribute'=>'created_at',
              'format'=>'raw',
              'filter' => DatePicker::widget([
                  'model'=>$searchModel,
                  'type' => DatePicker::TYPE_INPUT,
                  'attribute'=>'created_at',
                  'pluginOptions' => [
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true
                  ]
              ]),
              'value'=>function($model){
                  return '<span class="label label-primary ">'.Yii::$app->formatter->asDate($model->created_at).'</span></h3>';
              },
              'options'=>['style'=>'width:120px;'],
            ],
            // [
            //   'header'=>Html::a(Yii::t('app', 'Create Page'), ['create'], ['class' => 'btn btn-success btn-block btn-sm']),
            //   'class' => 'yii\grid\ActionColumn',
            //   'options'=>['style'=>'width:120px;'],
            //   'buttonOptions'=>['class'=>'btn btn-default'],
            //   'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            // ],
        ],
    ]); ?>

</div>
