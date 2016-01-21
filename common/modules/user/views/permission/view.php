<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Permission */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options'=>['class'=>'table table-striped'],
        'attributes' => [
          'name',
          'description:ntext',
          'rule_name',
          'data:ntext',
          'created_at:dateTime',
          'updated_at:dateTime',
        ],
    ]) ?>

</div>
