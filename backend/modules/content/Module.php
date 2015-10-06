<?php

namespace backend\modules\content;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\content\controllers';
    public $layout = 'content';
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
