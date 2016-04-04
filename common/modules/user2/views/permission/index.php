<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\PermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-condensed'],
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'name',
          //'description:ntext',
          'ruleName',
          //'data:ntext',
          // 'createdAt',
          // 'updatedAt',
            [
              'class' => 'yii\grid\ActionColumn',
              'header' => Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('user', 'Create Permission'), ['create'], ['class' => 'btn btn-success btn-sm btn-block']),
              'options' => ['style'=>'width:120px;'],
              'buttonOptions' => ['class'=>'btn btn-default'],
              'template' => '<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>',
            ],
        ],
    ]); ?>

</div>
