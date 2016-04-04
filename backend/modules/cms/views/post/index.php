<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-hover'],
        'columns' => [
            // [
            //   'class' => 'yii\grid\SerialColumn',
            //   'options'=>['style'=>'width:40px;'],
            //   'contentOptions'=>['class'=>'text-center']
            // ],
            ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:30px']],
            // [
            //   'attribute'=>'title',
            //   'format'=>'html',
            //   'value'=>function($model){
            //     $link = Html::a($model->title,['#']);
            //     $actionLink = Html::a('Edit',['#']).'  | '.Html::a('View',['#']).'  | '.Html::a('Delete',['#']);
            //     return $link.'<p class="title-action">'.$actionLink.'</p>';
            //   }
            // ],
            // 'view',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'status',
            // 'category_id',
            [
              'attribute'=>'title',
              'linkStyle'=>'default', // default, buttongroup
              'labelStyle'=>'text', // icon,text,iconText
              'class'=>'\dixonstarter\grid\TitleActionColumn',
            ],
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
              'attribute'=>'published_at',
              'format'=>'raw',
              'filter' => DatePicker::widget([
                  'model'=>$searchModel,
                  'type' => DatePicker::TYPE_INPUT,
                  'attribute'=>'published_at',
                  'pluginOptions' => [
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true
                  ]
              ]),
              'value'=>function($model){
                  return '<span class="label label-primary ">'.Yii::$app->formatter->asDate($model->published_at).'</span></h3>';
              },
              'options'=>['style'=>'width:120px;'],
            ],


            // 'updated_by',

            // [
            //   'header'=>Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success btn-sm btn-block']),
            //   'class' => 'yii\grid\ActionColumn',
            //   'options'=>['style'=>'width:120px;'],
            //   'buttonOptions'=>['class'=>'btn btn-default'],
            //   'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            // ]
        ],
    ]); ?>

</div>
