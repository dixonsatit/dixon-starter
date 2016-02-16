<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\AccessControl;
class UserController extends ActiveController
{
     public $modelClass = 'api\modules\v1\models\User';
     public $serializer = [
       'class' => 'yii\rest\Serializer',
       'collectionEnvelope' => 'items',
     ];

     public function actions()
    {
        $actions = parent::actions();
        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'],$actions['update']);
        return $actions;
    }
}
