<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img(Url::base().'/images/logo-dimple-new.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-topr',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('common', 'Home'), 'url' => ['/site/index']],
        ['label' => 'Content', 'items' => [
          ['label' => 'Post', 'url' => ['/cms/post/index']],
          ['label' => 'Page', 'url' => ['/cms/page/index']],
          ['label' => 'Category', 'url' => ['/cms/category/index']],
        ]],
        ['label' => Yii::t('backend', 'Management'), 'items' => [
              ['label' => Yii::t('backend', 'Manage Users'), 'url' => ['/user/manage-user/index']],
              ['label' => Yii::t('common', 'Content'), 'url' => ['/content/default/index']],
        ]],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
          'label' => Yii::t('common', 'Account ({username})',['username'=>Yii::$app->user->identity->username]),
          'items'=>[
              ['label' => Yii::t('common', 'Settings'), 'url' => ['/user/profile/index']],
              [
                 'label' => Yii::t('common', 'Logout ({username})',['username'=>Yii::$app->user->identity->username]),
                 'url' => ['/site/logout'],
                 'linkOptions' => ['data-method' => 'post']
             ]
          ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <?php if(isset($this->params['breadcrumbs'])): ?>
    <div class="main-container-nav">
      <div class="container container-nav">
        <i class="glyphicon glyphicon-list-alt"></i><?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
      </div>
    </div>
  <?php endif ?>


    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Dimple Techonogy Co., Ltd. <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
