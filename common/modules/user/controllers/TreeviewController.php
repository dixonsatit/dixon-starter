<?php

namespace common\modules\user\controllers;

use Yii;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\ArrayHelper;
/**
 *
 */
class TreeviewController extends Controller
{
    public $layout = 'rbac';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $rbac = [];
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRoles();
        foreach ($roles as $key => $role) {
            if(($item = $authManager->getChildren($role->name))!==null){
              $rbac[] = $item;
            }
        }
        return $this->render('index',[
          'data'=>$rbac
        ]);
    }

    public function actionList()
    {
      Yii::$app->response->format = Response::FORMAT_JSON;
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRoles();
        $permissions = $authManager->getPermissions();
        $items = ArrayHelper::merge($roles, $permissions);
        $namesItems = array_keys($items);
        $links = [];
        foreach ($items as $nameItem => $item) {
            $children = $authManager->getChildren($nameItem);
            foreach ($children as $nameChild => $child) {
                $links[] = [
                    'source' => array_search($nameItem, $namesItems),
                    'target' => array_search($nameChild, $namesItems),
                ];
            }
        }
        return ['nodes' => array_values($items), 'links' => $links];
    }
}
