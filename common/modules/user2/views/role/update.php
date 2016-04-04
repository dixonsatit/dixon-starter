<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Role */

$this->title = Yii::t('user', 'Update {modelClass}: ', [
    'modelClass' => 'Role',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
