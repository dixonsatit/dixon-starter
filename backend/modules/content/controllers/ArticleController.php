<?php

namespace backend\modules\content\controllers;

use Yii;
use common\models\Article;
use backend\modules\content\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\imperavi\actions\GetAction;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use yii\filters\AccessControl;
/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
              'class' => 'vova07\imperavi\actions\UploadAction',
              'url' => 'http://saveenergy.kkh.go.th/uploads/images/', // Directory URL address, where files are stored.
              'path' => '@webroot/uploads/images' // Or absolute path to directory where files are stored.
            ],
            'file-upload' => [
              'class' => 'vova07\imperavi\actions\UploadAction',
              'url' => 'http://saveenergy.kkh.go.th/uploads/images/files/',
              'path' => '@webroot/uploads/files',
              'uploadOnlyImage' => false,
            ],
            'images-get' => [
                'class' => GetAction::className(),
                'url' => 'http://saveenergy.kkh.go.th/uploads/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/images', // Or absolute path to directory where files are stored.
                'type' => GetAction::TYPE_IMAGES,
            ],
            'files-get' => [
               'class' => GetAction::className(),
                'url' => 'http://saveenergy.kkh.go.th/uploads/files/', // Directory URL address, where files are stored.
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
          ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->published_at = date('Y-m-d H:i',$model->published_at);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
