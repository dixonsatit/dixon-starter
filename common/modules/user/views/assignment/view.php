<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use common\modules\user\RbacAsset;
$rbac = RbacAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\modules\user\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <h1 >Assignments <small> > <?=$model->username?></small></h1>
    <?= DetailView::widget([
        'model' => $model,
        'options'=>['class'=>'table table-striped'],
        'attributes' => [
          'username',
          'email',
          //'created_at:dateTime',
          'updated_at:dateTime',
        ],
    ]) ?>
    <?=$this->render('/_assignment')?>
</div>

<?php

$properties = Json::htmlEncode([
    'userId' => $userId,
    'assignUrl' => Url::to(['/user/assignment/assigned']),
    'revokeUrl' => Url::to(['/user/assignment/revoke']),
    'listAssigndUrl' => Url::to(['/user/assignment/list-assigned','id'=>$userId]),
    'listAvailableUrl' => Url::to(['/user/assignment/list-available'])
]);

$js = <<<JS

  yii.rbac.initAssignment({$properties},'#list-assigned','#list-available');
JS;
$this->registerJs($js);
?>
