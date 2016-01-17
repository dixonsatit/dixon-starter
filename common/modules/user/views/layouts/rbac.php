<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
array_unshift($this->params['breadcrumbs'],Yii::t('rbac','Rbac'));
 ?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php echo Nav::widget([
    'items' => [
        [
          'label' => Yii::t('rbac','Assignment'),
          'url' => ['/user/assignment/index']
        ],[
            'label' => Yii::t('rbac', 'Role'),
            'url' => ['/user/role/index']
        ],[
            'label' => Yii::t('rbac','Permission'),
            'url' => ['/user/permission/index']
        ],[
            'label' => Yii::t('rbac','Rule'),
            'url' => ['/user/rule/index']
        ],[
            'label' => Yii::t('rbac','Settings'),
            'items' => [
                 ['label' => Yii::t('rbac','Article Category'), 'url' => ['article-category/index']],
                 '<li class="divider"></li>',
                  ['label' => Yii::t('rbac','Manage Files'), 'url' => ['article-category/index']],
            ],
        ]
    ],
    'options' => ['class' =>'nav-tabs'],
]);
?>

<?php echo $content; ?>

<?php $this->endContent(); ?>
