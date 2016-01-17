<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Role */

$this->title = Yii::t('user', 'Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
