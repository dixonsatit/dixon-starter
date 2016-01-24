<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'tableOptions'=>['class'=>'table table-condensed'],
        'columns' => [
            [
              'class' => 'yii\grid\SerialColumn',
              'options'=>['style'=>'width:40px;'],
              'contentOptions'=>['class'=>'text-center']
            ],
            'title',
            // 'view',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'status',
            // 'category_id',
            // 'created_at',
            [
              'attribute'=>'updated_at',
              'format'=>'dateTime',
              'options'=>['style'=>'width:200px;'],
            ],
            // 'created_by',
            // 'updated_by',

            [
              'header'=>Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success btn-sm btn-block']),
              'class' => 'yii\grid\ActionColumn',
              'options'=>['style'=>'width:120px;'],
              'buttonOptions'=>['class'=>'btn btn-default'],
              'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            ],
        ],
    ]); ?>

</div>
