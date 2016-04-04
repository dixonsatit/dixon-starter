<?php

namespace common\modules\user\controllers;

use Yii;
use yii\web\Response;
use common\modules\user\models\User;
use common\modules\user\models\AuthItem;
use common\modules\user\models\Assignment;
use common\modules\user\models\AssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AssignmentController implements the CRUD actions for User model.
 */
class AssignmentController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'userId'=> $id
        ]);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAssigned(){
      $roles =  Yii::$app->request->post('roleName',[]);
      $user_id =  Yii::$app->request->post('userId');
      $errors = [];
      $authManager = Yii::$app->authManager;
      foreach ($roles as $key => $roleName) {
        try {
          $item = $authManager->getRole($roleName);
          $item = $item ? : $authManager->getPermission($roleName);
          $authManager->assign($item,$user_id);
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

    public function actionRevoke(){
      $roles =  Yii::$app->request->post('roleName',[]);
      $user_id =  Yii::$app->request->post('userId');
      $errors = [];
      $authManager = Yii::$app->authManager;
      foreach ($roles as $key => $roleName) {
        try {
          $item = $authManager->getRole($roleName);
          $item = $item ? : $authManager->getPermission($roleName);
          $authManager->revoke($item,$user_id);
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
     foreach ($authManager->getAssignments($id) as $assigment) {
         if (isset($roles[$assigment->roleName])) {
             if (empty($term) || strpos($assigment->roleName, $term) !== false) {
                 $assigned['Roles'][$assigment->roleName] = $assigment->roleName;
             }
            unset($roles[$assigment->roleName]);
         } elseif (isset($permissions[$assigment->roleName])) {
              if (empty($term) || strpos($assigment->roleName, $term) !== false) {
                  if($assigment->roleName[0] == '/') {
                    $assigned['Routes'][$assigment->roleName] = $assigment->roleName;
                  } else {
                    $assigned['Permissions'][$assigment->roleName] = $assigment->roleName;
                  }
              }
              unset($permissions[$assigment->roleName]);
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
      foreach ($authManager->getAssignments($id) as $assigment) {
        if (isset($roles[$assigment->roleName])) {
          unset($roles[$assigment->roleName]);
        }
        else{
          unset($permissions[$assigment->roleName]);
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

    public function actionHierarchy(){
        return $this->render('hierarchy');
    }

}
