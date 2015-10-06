<?php

namespace common\modules\user;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\user\controllers';

    public $defaultRoute = 'profile';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
