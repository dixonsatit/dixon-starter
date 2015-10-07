<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

 ?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php echo Nav::widget([
    'items' => [
        [
            'label' => Yii::t('common', 'Article'),
            'url' => ['default/index']
        ],[
            'label' => Yii::t('content','Article'),
            'url' => ['article/index']
        ],[
            'label' => Yii::t('content','Page'),
            'url' => ['page/index']
        ],[
            'label' => Yii::t('content','Settings'),
            'items' => [
                 ['label' => Yii::t('content','Article Category'), 'url' => ['article-category/index']],
                 '<li class="divider"></li>',
                  ['label' => Yii::t('content','Manage Files'), 'url' => ['article-category/index']],
            ],
        ]
    ],
    'options' => ['class' =>'nav-tabs'],
]);
?>

<?php echo $content; ?>

<?php $this->endContent(); ?>
