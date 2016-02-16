<?php

namespace common\modules\user\controllers;

use Yii;
use common\modules\user\models\Route;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use  yii\caching\TagDependency;

/**
 * PermissionController implements the CRUD actions for Permission model.
 */
class RouteController extends Controller
{
    public $layout = 'rbac';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'assigned' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Permission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Route();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permission model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'permissionName'=>$id
        ]);
    }

    /**
     * Creates a new Permission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Route();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Permission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Permission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Permission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Permission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Route::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAssigned(){
        return $this->assign('assigned');
    }

    public function actionRevoke(){
        return $this->assign('revoke');
    }

    private function assign($type){
      $errors = [];
      $authManager = Yii::$app->authManager;
      $roles =  Yii::$app->request->post('roleName',[]);
      $id =  Yii::$app->request->post('userId');

      foreach ($roles as $key => $route) {
        try {
          if($type == 'assigned'){
            $item = $authManager->createPermission($route);
            $authManager->add($item);
          } else{
            $item = $authManager->getPermission($route);
            $authManager->remove($item);
          }
          $result[$route] = ['sucess'=>true];
        } catch (\Exception $e) {
          $result[$route] = ['sucess'=>false,'error'=>$e->getMessage()];
          $errors[$route] = $e->getMessage();
        }
      }

      Yii::$app->response->format = Response::FORMAT_JSON;
      return [
        'result' => $result,
        'errors' => $errors
      ];
    }

    public function actionListAssigned($id,$term=''){
      Yii::$app->response->format = Response::FORMAT_JSON;
              $result = [];
              $manager = Yii::$app->getAuthManager();
              $exists = array_keys($manager->getPermissions());
              $routes = $this->getAppRoutes();

                  foreach ($exists as $name) {
                      if ($name[0] !== '/') {
                          continue;
                      }
                      if (empty($term) or strpos($name, $term) !== false) {
                          $r = explode('&', $name);
                          $result[$name] = $name;
                      }
                  }

              return ['Routes'=>$result];
    }

    public function actionListAvailable($term='',$refresh=0){
      Yii::$app->response->format = Response::FORMAT_JSON;
      if ($refresh == '1') {
          $this->invalidate();
      }
      $result = [];
      $manager = Yii::$app->getAuthManager();
      $exists = array_keys($manager->getPermissions());
      $routes = $this->getAppRoutes();

      foreach ($routes as $route) {
          if (in_array($route, $exists)) {
              continue;
          }
          if (empty($term) or strpos($route, $term) !== false) {
              $result[$route] = $route;
          }
      }
      return ['Routes'=>$result];
    }

    protected function invalidate()
     {
         if (Yii::$app->cache !== null) {
             TagDependency::invalidate(Yii::$app->cache,'dixonsatit.dx-starter.route' );
         }
     }

    public function actionGenerate(){
      return $this->render('generate',[

      ]);
    }

    /**
     * Get list of application routes
     * @return array
     */
    public function getAppRoutes()
    {
        $key = __METHOD__;
        $cache = Yii::$app->cache;
        if ($cache === null || ($result = $cache->get($key)) === false) {
            $result = [];
            $this->getRouteRecrusive(Yii::$app, $result);
            if ($cache !== null) {
                $cache->set($key, $result, (60*60*24*30), new TagDependency([
                    'tags' => 'dixonsatit.dx-starter.route'
                ]));
            }
        }
        return $result;
    }
    /**
     * Get route(s) recrusive
     * @param \yii\base\Module $module
     * @param array $result
     */
    private function getRouteRecrusive($module, &$result)
    {
        try {
            foreach ($module->getModules() as $id => $child) {
                if (($child = $module->getModule($id)) !== null) {
                    $this->getRouteRecrusive($child, $result);
                }
            }
            foreach ($module->controllerMap as $id => $type) {
                $this->getControllerActions($type, $id, $module, $result);
            }
            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            $this->getControllerFiles($module, $namespace, '', $result);
            $result[] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/*';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }

    }
    /**
     * Get list controller under module
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     * @return mixed
     */
    private function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = @Yii::getAlias('@' . str_replace('\\', '/', $namespace));
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file)) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $id = Inflector::camel2id(substr(basename($file), 0, -14));
                    $className = $namespace . Inflector::id2camel($id) . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }
    /**
     * Get list action of controller
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    private function getControllerActions($type, $id, $module, &$result)
    {
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $result[] = '/' . $controller->uniqueId . '/*';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }
    /**
     * Get route of action
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    private function getActionRoutes($controller, &$result)
    {
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $result[] = $prefix . Inflector::camel2id(substr($name, 6));
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }

    }

}
