<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Permission */

$this->title = Yii::t('user', 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
