<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

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

          $updatePost = $auth->createPermission('updatePost');
          $updatePost->description = 'Update post';
          $auth->add($updatePost);

          $auth->addChild($user,$updatePost);
          $auth->addChild($manager, $user);
          $auth->addChild($admin, $manager);

          $auth->assign($user, 1);
          $auth->assign($manager, 2);
          $auth->assign($admin, 3);
          Console::outPut(Console::renderColoredString("%g - Asignment user id 1,2,3 %n"));

          Console::outPut(Console::renderColoredString("%gSuccess%n"));
        }

    }
}
