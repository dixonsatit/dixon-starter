<?php

namespace backend\modules\cms;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\cms\controllers';
    public $contentType = 'html';
    public $uploadUrl = null;

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
