<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Profile;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use pheme\grid\actions\ToggleAction;

/**
 * ManageUserController implements the CRUD actions for User model.
 */
class ManageUserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions(){
      return [
        'toggle' => [
            'class' => ToggleAction::className(),
            'modelClass' => User::className(),
            'attribute'=>'status',
            'setFlash' => true,
            'onValue'=>'10',
            'onValue'=>'0'
        ]
      ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $model = User::findOne(1);
        // $model->status =10;
        // $model->save();
        // print_r($model->getErrors());

        $searchModel = new UserSearch();
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
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new User([
           'status'=> User::STATUS_ACTIVE
         ]);
         $profile = new Profile([
           'scenario'=>'admin',
           'locale'=>'en-US'
         ]);

         if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())&& Model::validateMultiple([$model,$profile])) {
             $model->setPassword($model->password);
             $model->generateAuthKey();
             if($model->save()){
                 $profile->link('user',$model);
                 $model->assignment();
             }
             return $this->redirect(['view', 'id' => $model->id]);
         } else {
             return $this->render('create', [
                 'model' => $model,
                 'profile'=>$profile
             ]);
         }
     }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($id)
     {
         $model = $this->findModel($id);
         $model->getRoleByUser();
         $profile = $model->profile;

         $model->password = $model->password_hash;
         $model->confirm_password = $model->password_hash;
         $oldPass = $model->password_hash;

           if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())&& Model::validateMultiple([$model,$profile])) {
           if($oldPass!==$model->password){
             $model->setPassword($model->password);
           }
           if($model->save() && $profile->save()){
             $model->assignment();
           }

             return $this->redirect(['view', 'id' => $model->id]);
         } else {
             return $this->render('update', [
                 'model' => $model,
                 'profile'=>$profile
             ]);
         }
     }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
