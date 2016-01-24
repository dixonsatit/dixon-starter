<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Rule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-view">
    <h1> <?= Html::encode($this->title)?> </h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'className',
            'createdAt:dateTime',
            'updatedAt:dateTime',
        ],
    ]) ?>

</div>
