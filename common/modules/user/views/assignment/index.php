<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('rbac', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'username',
            [
              'attribute'=>'username',
              'format'=>'raw',
              'value'=>function($model){
                return '<strong>'.ucfirst($model->username).'</strong> &lt;'.$model->email.'&gt;';
              }
            ],
            [
              'label'=>'test',
              'format'=>'html',
              'value'=>function($model){
                $roles =  ArrayHelper::map($model->assignment,'user_id','item_name');
                $labelHtml=[];
                foreach ($roles as $key => $value) {
                  $labelHtml[] = '<span class="label label-primary">'.$value.'</span>';
                }
                return implode(',', $labelHtml);
              }
            ],
            //'email:email',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'password_reset_at',
            // 'confirmed_email_at:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
