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
    <div class="row">
       <div class="col-lg-5">
            <h5>Available</h5>
            <select id="list-available" class="form-control" name="list-avaliable[]" multiple="multiple" size="20" style="width:100%;"></select>
       </div>
       <div class="col-lg-2" style="padding-top:80px;">
           <a href="#" id="btn-assign" class="btn btn-success btn-block btn-md">Assign <i class="glyphicon glyphicon-chevron-right"></i></a>
           <a href="#" id="btn-assign-all" class="btn btn-success btn-block btn-md">Assign All<i class="glyphicon glyphicon-chevron-right"></i><i class="glyphicon glyphicon-chevron-right"></i></a>
           <hr>
           <a href="#" id="btn-revoke" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-chevron-left"></i> Revoke</a>
           <a href="#" id="btn-revoke-all" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-chevron-left"></i><i class="glyphicon glyphicon-chevron-left"></i> Revoke All</a>
       </div>
       <div class="col-lg-5">
            <h5>Assigned</h5>
            <select id="list-assigned" class="form-control" name="list-avaliable[]" multiple="multiple" size="20" style="width:100%;"></select>
       </div>
   </div>
   <br>
   <div class="jumbotron well" style="overflow: scroll;">
     <span id='tree'></span>
   </div>
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
