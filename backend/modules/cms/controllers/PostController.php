<?php

namespace backend\modules\cms\controllers;

use Yii;
use backend\modules\cms\models\Post;
use backend\modules\cms\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\imperavi\actions\GetAction;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use trntv\filekit\actions\ViewAction;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{


    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
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

    public function actions(){
      return [
        'image-upload' => [
          'class' => 'vova07\imperavi\actions\UploadAction',
          'url' => Yii::$app->getModule('cms')->uploadUrl.'/uploads/images/', // Directory URL address, where files are stored.
          'path' => '@webroot/uploads/images' // Or absolute path to directory where files are stored.
        ],
        'file-upload' => [
          'class' => 'vova07\imperavi\actions\UploadAction',
          'url' => Yii::$app->getModule('cms')->uploadUrl.'/uploads/files/',
          'path' => '@webroot/uploads/files',
          'uploadOnlyImage' => false,
        ],
        'images-get' => [
            'class' => GetAction::className(),
            'url' => Yii::$app->getModule('cms')->uploadUrl.'/uploads/images/', // Directory URL address, where files are stored.
            'path' => '@webroot/uploads/images', // Or absolute path to directory where files are stored.
            'type' => GetAction::TYPE_IMAGES,
        ],
        'files-get' => [
           'class' => GetAction::className(),
            'url' => Yii::$app->getModule('cms')->uploadUrl.'/uploads/files/', // Directory URL address, where files are stored.
            'path' => '@webroot/uploads/files', // Or absolute path to directory where files are stored.
            'type' => GetAction::TYPE_FILES,
       ],
        'upload'=>[
           'class' => UploadAction::className(),
             'deleteRoute' => 'file-delete',
             'on afterSave' => function ($event) {
                 /* @var $file \League\Flysystem\File */
                 $file = $event->file;
                //  $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                //  $file->put($img->encode());
               }
          ],
          'file-delete' => [
              'class' => DeleteAction::className()
          ],
          'download'=>[
              'class'=>ViewAction::className(),
          ]
      ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {

        
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post([
            'published_at'=>date('Y-m-d H:i:s')
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
