<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use common\modules\user\RbacAsset;
/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Permission */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$rbac = RbacAsset::register($this);
?>
<div class="permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options'=>['class'=>'table table-striped'],
        'attributes' => [
          'name',
          'description:ntext',
          'ruleName',
          'data:ntext',
          'createdAt:dateTime',
          'updatedAt:dateTime',
        ],
    ]) ?>

    <?=$this->render('/_assignment')?>
</div>

<?php
$properties = Json::htmlEncode([
    'userId' => $permissionName,
    'assignUrl' => Url::to(['/user/permission/assigned']),
    'revokeUrl' => Url::to(['/user/permission/revoke']),
    'listAssigndUrl' => Url::to(['/user/permission/list-assigned']),
    'listAvailableUrl' => Url::to(['/user/permission/list-available'])
]);

$js = <<<JS
    yii.rbac.initAssignment({$properties},'#list-assigned','#list-available');
JS;
$this->registerJs($js);
?>
