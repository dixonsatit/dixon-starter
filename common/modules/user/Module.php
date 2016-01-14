<?php

namespace common\modules\user;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\user\controllers';

    public $defaultRoute = 'profile';

    /**
     * Enable registration.
     * @var boolean
     */
    public $enableRegistration = true;

    /**
     * Ennable unconfirm registration
     * @var boolean
     */
    public $enableConfirmation = true;

    public $confirmWithin = 86400; // 24 hours

    public $recoverWithin = 21600; // 6 hours

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }

    public function sendMail($subject,$emailTo,$params,$view='default'){
      return Yii::$app->mailer->compose(['html' => $view.'-html','text' => $view.'-text'],$params)
        ->setTo($emailTo)
        ->setFrom([Yii::$app->params['supportEmail'] => 'DX-Starter'])
        ->setSubject($subject)
        ->send();
    }
}
