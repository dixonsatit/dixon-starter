<?php

namespace common\modules\user\controllers;

use Yii;
use common\models\User;
use common\models\ChangePasswordForm;
use frontend\models\ProfileSearch;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;


class ProfileController extends Controller
{
    public $layout = 'profile'; // set this to profile,profile2

    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'actions' => ['index','update','settings','change-password','avatar-upload','avatar-delete'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::className(),
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::className()
            ]
        ];
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex()
    {
        $user = $this->findModel(Yii::$app->user->id);
        $model = $user->profile;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('common','Profile updated successfully'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    public function actionSettings()
    {
      $model = $this->findModel(Yii::$app->user->id);
      $model->scenario = 'registration';
      $profile = $model->profile;

      if ($model->load(Yii::$app->request->post()) &&
          $profile->load(Yii::$app->request->post()) &&
          User::validateMultiple([$model,$profile]))
      {
        if($model->save() && $profile->save()){
            Yii::$app->getSession()->setFlash('success', Yii::t('common','Account settings updated successfully'));
            return $this->redirect(['settings']);
        }
      }

      return $this->render('setting_form',[
        'model' => $model,
        'profile'=> $profile
      ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', Yii::t('common','Password updated successfully'));
                return $this->redirect(['change-password']);
            }
        }else{
            return $this->render('change_password',[
              'model'=>$model
            ]);
        }
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
