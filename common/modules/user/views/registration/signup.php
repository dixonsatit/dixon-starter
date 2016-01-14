<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-signup">

    <div class="row">
        <div class="col-lg-offset-4 col-lg-4">
          <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'signup-button']) ?>
                </div>
                <div class="text-center" style="color:#999;margin:1em 0">
                    Already have an account?  <?= Html::a('Log In', ['/user/auth/login']) ?>

                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
