<?php

namespace common\modules\user\controllers;

class RouteController extends \yii\web\Controller
{
    public $layout = 'rbac';
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
