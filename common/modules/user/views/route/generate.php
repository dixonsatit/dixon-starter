<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use common\modules\user\RbacAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\PermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$rbac = RbacAsset::register($this);
$this->title = Yii::t('user', 'Generate Route');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-index">
  <h1><?= Html::encode($this->title) ?></h1>

  <?=$this->render('/_assignment')?>
</div>

<?php
$properties = Json::htmlEncode([
  'userId' => 0,
  'assignUrl' => Url::to(['/user/route/assigned']),
  'revokeUrl' => Url::to(['/user/route/revoke']),
  'listAssigndUrl' => Url::to(['/user/route/list-assigned']),
  'listAvailableUrl' => Url::to(['/user/route/list-available'])
]);

$js = <<<JS
  yii.rbac.initAssignment({$properties},'#list-assigned','#list-available');
JS;
$this->registerJs($js);
?>
