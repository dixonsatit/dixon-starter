<?php
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

 ?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="row">
  <div class="col-sm-4 col-md-3">

        <?php
        echo Nav::widget([
            'encodeLabels'=>false,
            'items' => [
                [
                    'label' =>  '<i class="glyphicon glyphicon-user"></i> '.Yii::t('common', 'Profile'),
                    'url' => ['profile/index'],
                ],
                [
                    'label' =>  '<i class="glyphicon glyphicon-cog"></i> '.Yii::t('common', 'Account Settings'),
                    'url' => ['profile/settings'],
                ],
                [
                    'label' =>  '<i class="glyphicon glyphicon-lock"></i> '.Yii::t('common', 'Change password'),
                    'url' => ['profile/change-password'],
                ]
            ],
            'options' => ['class' =>'nav-pills nav-stacked'], // set this to nav-tab to get tab-styled navigation
        ]);
         ?>


  </div>
  <div class="col-sm-8 col-md-9">
    <?php echo $content; ?>

  </div>
</div>

<?php $this->endContent(); ?>
