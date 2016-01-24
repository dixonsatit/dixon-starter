<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
 $c = Yii::$app->controller->id;
if(isset($this->params['breadcrumbs'])){
  array_unshift($this->params['breadcrumbs'],Yii::t('rbac','Rbac'));
}

 ?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php echo Nav::widget([
    'encodeLabels'=>false,
    'items' => [
        // [
        //   'label' => '<i class="glyphicon glyphicon-blackboard"></i> '.Yii::t('rbac','Rbac Hierarchy'),
        //   'url' => ['/user/treeview/index'],
        //   'active' => $c=='treeview'
        // ],
        [
          'label' => '<i class="glyphicon glyphicon-user"></i> '.Yii::t('rbac','Assignment'),
          'url' => ['/user/assignment/index'],
          'active' => $c=='assignment'
        ],[
            'label' => '<i class="glyphicon glyphicon-th-large"></i> '.Yii::t('rbac', 'Role'),
            'url' => ['/user/role/index'],
            'active' => $c=='role'
        ],[
            'label' => '<i class="glyphicon glyphicon-th"></i> '.Yii::t('rbac','Permission'),
            'url' => ['/user/permission/index'],
            'active' => $c=='permission'
        ],[
            'label' => '<i class="glyphicon glyphicon-road"></i> '.Yii::t('rbac','Route'),
            'url' => ['/user/route/index'],
            'active' => $c=='route'
        ],[
            'label' => '<i class="glyphicon glyphicon-gift"></i> '.Yii::t('rbac','Rule'),
            'url' => ['/user/rule/index'],
            'active' => $c=='rule'
        ],[
            'label' => '<i class="glyphicon glyphicon-plus"></i>',
            'items' => [
                 ['label' => 'Create Role', 'url' => '#'],
                 ['label' => 'Create Permission', 'url' => '#'],
                 ['label' => 'Create Rule', 'url' => '#'],
                 ['label' => 'Create Route', 'url' => '#'],
                 '<li class="divider"></li>',

                 ['label' => 'Generate Route Items', 'url' => '#'],
            ],
        ],
    ],
    'options' => ['class' =>'nav-tabs'],
]);
?>

<?php echo $content; ?>

<?php $this->endContent(); ?>
