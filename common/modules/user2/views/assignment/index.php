<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
$authManager = Yii::$app->authManager;
?>
<div class="user-index">

     <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-condensed'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
              'attribute'=>'id',
              'options'=>['style'=>'width:50px;'],
              'contentOptions'=>['class'=>'text-center']
            ],
            //'username',
            [
              'attribute'=>'username',
              'format'=>'raw',
              'value'=>function($model){
                return Html::a('<strong>'.ucfirst($model->username).'</strong> &lt;'.$model->email.'&gt;',['/user/assignment/view','id'=>$model->id]);
              }
            ],
            [
              'label'=>'Roles',
              'format'=>'html',
              'value'=>function($model) use ($authManager){
                $roles =  ArrayHelper::map($authManager->getAssignments($model->id),'roleName','roleName');
                $labelHtml=[];
                foreach ($roles as $key => $value) {
                  $labelHtml[] = '<span class="label-as-badge label label-success">'.$value.'</span>';
                }
                return implode(' ', $labelHtml);
              }
            ],
            // [
            //   'label'=>'Roles',
            //   'format'=>'raw',
            //   'value'=>function($model) use($roles){
            //     $model->id = ArrayHelper::map(Yii::$app->authmanager->getRolesByUser($model->id),'name','name');
            //     return Html::activeCheckboxList($model, 'id', $roles);
            //   }
            // ]
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
