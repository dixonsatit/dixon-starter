<?php
use common\modules\user\RbacAsset;
use yii\helpers\Html;
use yii\helpers\Json;
$rbac = RbacAsset::register($this);
$this->title = Yii::t('rbac', 'Assignments');
yii\helpers\VarDumper::dump($data,10,true);
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="jumbotron well" style="overflow: scroll;">
  <span id='tree'></span>
  <div id="body"></div>
</div>
<?php
$properties = Json::htmlEncode([
    'chartDataUrl' =>Yii::$app->assetManager->getPublishedUrl($rbac->sourcePath).'/flare.json' ,
]);

$js = <<<JS
yii.rbac.initProperties({$properties});
yii.rbac.renderChart('#d3chart');
JS;
$this->registerJs($js);
?>
