<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

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
            //   'options'=>['style'=>'width:50px;'],
            // ],
            ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:30px']],
            [
              'attribute'=>'name',
              'linkStyle'=>'buttongroup', // default, buttongroup
              'labelStyle'=>'iconText', // icon,text,iconText
              'class'=>'\dixonstarter\grid\TitleActionColumn',
            ],
            [
              'attribute'=>'status',
              'format'=>'html',
              'options'=>['style'=>'width:100px;'],
              'filter'=>$searchModel->getItemStatus(),
              'value'=>function($model){
                return $model->status == 1 ? '<i class="glyphicon glyphicon-ok-circle"></i> Active' : '<i class="glyphicon glyphicon-ban-circle"></i> Draft';
              }
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
            // 'parent_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            // [
            //   'header'=>Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']),
            //   'class' => 'yii\grid\ActionColumn',
            //   'options'=>['style'=>'width:120px;'],
            //   'buttonOptions'=>['class'=>'btn btn-default'],
            //   'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            // ],
        ],
    ]); ?>

</div>
