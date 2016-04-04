<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="padding-top:100px;">
    <div class="row">
        <div class="col-md-offset-4 col-md-5 col-lg-offset-4 col-lg-4">
            <h1 class="text-center">DX Strater</h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
                </div>
                <div style="color:#999;margin:1em 0">
                    Don't have an account? <?= Html::a('Sign up', ['/user/registration/index']) ?> |
                    <?= Html::a('Forgot password?', ['auth/request-password-reset']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
