<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class TodoController extends ActiveController
{
     public $modelClass = 'api\modules\v1\models\Todo';
     public $serializer = [
       'class' => 'yii\rest\Serializer',
       'collectionEnvelope' => 'items',
     ];
}
