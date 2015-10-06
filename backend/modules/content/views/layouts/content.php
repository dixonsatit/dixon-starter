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
            'label' => Yii::t('content','Article'),
            'url' => ['article/index']
        ],
        [
            'label' => Yii::t('content','Page'),
            'url' => ['page/index']
        ],
        [
          'label' => Yii::t('content','Article Category'),
          'url' => ['article-category/index']],
        [
            'label' => Yii::t('content','Settings'),
            'items' => [
                 ['label' => Yii::t('content','Article Category'), 'url' => ['article-category/index']],
                 '<li class="divider"></li>',
                 '<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ]
    ],
    'options' => ['class' =>'nav-tabs'], // set this to nav-tab to get tab-styled navigation
]);
?>

<?php echo $content; ?>

<?php $this->endContent(); ?>
