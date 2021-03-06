<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\RuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-condensed'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'className',
            //'data:ntext',
            // 'created_at',
            // 'updated_at',

            [
              'class' => 'yii\grid\ActionColumn',
              'header' => Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('user', 'Create Rule'), ['create'], ['class' => 'btn btn-success btn-sm btn-block']),
              'options' => ['style'=>'width:120px;'],
              'buttonOptions' => ['class'=>'btn btn-default'],
              'template' => '<div class="btn-group btn-group-sm text-center" role="group"> {view} {delete} </div>'
            ],
        ],
    ]); ?>

</div>
