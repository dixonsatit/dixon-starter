<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\SerialColumn',
              'options'=>['style'=>'width:50px;'],
            ],
            'name',
            [
              'attribute'=>'status',
              'format'=>'html',
              'options'=>['style'=>'width:100px;'],
              'filter'=>$searchModel->getItemStatus(),
              'value'=>function($model){
                return $model->status == 1 ? '<i class="glyphicon glyphicon-ok-circle"></i> Active' : '<i class="glyphicon glyphicon-ban-circle"></i> Draft';
              }
            ],
            // 'parent_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
              'header'=>'Actions',
              'class' => 'yii\grid\ActionColumn',
              'options'=>['style'=>'width:120px;'],
              'buttonOptions'=>['class'=>'btn btn-default'],
              'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            ],
        ],
    ]); ?>

</div>
