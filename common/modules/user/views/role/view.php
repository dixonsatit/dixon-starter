<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use common\modules\user\RbacAsset;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$rbac = RbacAsset::register($this);
?>
<div class="role-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'rule_name',
            'data:ntext',
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>
    <?=$this->render('/_assignment')?>
</div>

<?php
$properties = Json::htmlEncode([
    'userId' => $roleName,
    'assignUrl' => Url::to(['/user/role/assigned']),
    'revokeUrl' => Url::to(['/user/role/revoke']),
    'listAssigndUrl' => Url::to(['/user/role/list-assigned']),
    'listAvailableUrl' => Url::to(['/user/role/list-available'])
]);

$js = <<<JS
    yii.rbac.initAssignment({$properties},'#list-assigned','#list-available');
JS;
$this->registerJs($js);
?>
