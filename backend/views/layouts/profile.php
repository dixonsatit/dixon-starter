<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

 ?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<?php
echo Nav::widget([
    'items' => [
        [
            'label' => 'Edit Profile',
            'url' => ['profile/index'],
        ]
    ],
    'options' => ['class' =>'nav nav-tabs'], // set this to nav-tab to get tab-styled navigation
]);
 ?>



  <?php echo $content; ?>




<?php $this->endContent(); ?>
