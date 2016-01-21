<?php

namespace common\modules\user\controllers;

use Yii;
use yii\web\Response;
use common\modules\user\models\Role;
use common\modules\user\models\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'roleName'=>$id
        ]);
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

      foreach ($roles as $key => $roleName) {
        try {
          $itemChild = $authManager->getRole($roleName);
          $itemChild = $itemChild ? : $authManager->getPermission($roleName);

          $item = $authManager->getRole($id);
          $item = $item ? : $authManager->getPermission($id);

          $type == 'assigned' ? $authManager->addChild($item,$itemChild) : $authManager->removeChild($item,$itemChild);
          $result[$roleName] = ['sucess'=>true];
        } catch (\Exception $e) {
          $result[$roleName] = ['sucess'=>false,'error'=>$e->getMessage()];
          $errors[$roleName] = $e->getMessage();
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
     $authManager = Yii::$app->authManager;
     $roles = $authManager->getRoles();
     $permissions = $authManager->getPermissions();
     $assigned = [];
     //$assignments = ArrayHelper::merge($authManager->getRolesByUser($id),$authManager->getPermissionsByUser($id));
     foreach ($authManager->getChildren($id) as $key => $assigment) {
         if (isset($roles[$assigment->name])) {
              if (empty($term) || strpos($assigment->name, $term) !== false) {
                 $assigned['Roles'][$assigment->name] = $assigment->name;
              }
              unset($roles[$assigment->name]);
         } elseif (isset($permissions[$assigment->name])) {
              if (empty($term) || strpos($assigment->name, $term) !== false) {
                  if($assigment->name[0] == '/') {
                    $assigned['Routes'][$assigment->name] = $assigment->name;
                  } else {
                    $assigned['Permissions'][$assigment->name] = $assigment->name;
                  }
              }
              unset($permissions[$assigment->name]);
         }
     }

     return $assigned;
    }

    public function actionListAvailable($id,$term=''){
      Yii::$app->response->format = Response::FORMAT_JSON;
      $authManager = Yii::$app->authManager;
      $roles = $authManager->getRoles();
      $permissions = $authManager->getPermissions();
      $avaliable = [];
      unset($roles[$id]);
      foreach ($authManager->getChildren($id) as $assigment) {
        if (isset($roles[$assigment->name])) {
          unset($roles[$assigment->name]);
        }
        else{
          unset($permissions[$assigment->name]);
        }
      }
      if (count($roles)) {
          foreach ($roles as $role) {
              if (empty($term) || strpos($role->name, $term) !== false) {
                  $avaliable['Roles'][$role->name] = $role->name;
              }
          }
      }
      if (count($permissions)) {
          foreach ($permissions as $role) {
              if ($role->name[0] != '/' && (empty($term) || strpos($role->name, $term) !== false)) {
                  $avaliable['Permissions'][$role->name] = $role->name;
              }elseif(empty($term) || strpos($role->name, $term) !== false){
                  $avaliable['Routes'][$role->name] = $role->name;
              }
          }
      }
      return $avaliable;
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $authManager = Yii::$app->authManager;
            $role = $authManager->createRole($model->name);
            $role->description = $model->description;
            $authManager->add($role);
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $model = $this->findModel($id);
      $authManager = Yii::$app->authManager;
      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          $role = $authManager->getRole($model->getOldAttribute('name'));
          if($role != null){
            $role->name = $model->name;
            $role->description = $model->description;
            $authManager->update($model->getOldAttribute('name'),$role);
          }
          return $this->redirect(['index']);
      } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$model = $this->findModel($id);
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($id);
        $authManager->remove($role);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
