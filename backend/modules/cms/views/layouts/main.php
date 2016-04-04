<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<h1><?=isset($this->title)? $this->title : '';?></h1>

<div class="row">
  <div class="col-lg-3">
    <?php
          echo Nav::widget([
          'encodeLabels'=>false,
          'items' => [

              [
                  'label' => '<i class="glyphicon glyphicon-dashboard"></i> Post',
                  'url' => ['/kirb/default/view','research_id'=>0]
              ],
              [
                  'label' => '<i class="glyphicon glyphicon-edit"></i> Page',
                  'url' => ['/kirb/default/update-research','research_id'=>0]
              ],
              [
                  'label' => '<i class="glyphicon glyphicon-edit"></i> Category',
                  'url' => ['/kirb/default/update-researcher','research_id'=>0]
              ],
              [
                  'label' => '<i class="glyphicon glyphicon-book"></i> เอกสาร',
                  'url' => ['/kirb/document/index','research_id'=>0]
              ],
              
          ],
          'options' => ['class' =>' nav-stacked'], // set this to nav-tab to get tab-styled navigation
      ]);
     ?>
  </div>

  <div class="col-lg-9 ">

      <?php echo  $content ?>

  </div>
</div>

<?php $this->endContent(); ?>
