<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\modules\user\components\AuthorRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        if($this->confirm('Your want to initiaion RBAC Db!')){



          $auth->removeAll();
          Console::outPut(Console::renderColoredString("%g - Remove All RBAC Tables%n"));

          $user = $auth->createRole('User');
          $auth->add($user);
          Console::outPut(Console::renderColoredString("%g - Create Role User%n"));

          $manager = $auth->createRole('Manager');
          $auth->add($manager);
          Console::outPut(Console::renderColoredString("%g - Create Role Manager%n"));

          $admin = $auth->createRole('Admin');
          $auth->add($admin);
          Console::outPut(Console::renderColoredString("%g - Create Role Admin%n"));


          $authorRule = new AuthorRule;
          $auth->add($authorRule);

          $manage = $auth->createPermission('/user/*');
          $auth->add($manage);
          $cms = $auth->createPermission('/cms/*');
          $auth->add($cms);
        //  $updatePost->ruleName = $authorRule->name;


          $auth->addChild($manager, $user);
          $auth->addChild($manager, $manage);
          $auth->addChild($manager, $cms);
          $auth->addChild($admin, $manager);

          $auth->assign($user, 3);
          $auth->assign($manager, 2);
          $auth->assign($admin, 1);
          Console::outPut(Console::renderColoredString("%g - Asignment user id 1,2,3 %n"));

          Console::outPut(Console::renderColoredString("%gSuccess%n"));
        }

    }
}
