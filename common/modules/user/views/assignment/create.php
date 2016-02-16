<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\user\models\User */

$this->title = Yii::t('rbac', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$roles = Yii::$app->authmanager->getRoles();
print_r($roles);
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
