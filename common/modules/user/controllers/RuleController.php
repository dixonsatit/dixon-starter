<?php

namespace common\modules\user\controllers;

use Yii;
use common\modules\user\models\Rule;
use common\modules\user\models\RuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RuleController implements the CRUD actions for Rule model.
 */
class RuleController extends Controller
{
    public $layout = 'rbac';

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

    /**
     * Lists all Rule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Rule();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rule model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $role = $rule = $this->findModel($id);
        $model = new Rule([
           'name' => $role->name,
           'className' => get_class($role),
           'createdAt' => $role->createdAt,
           'updatedAt' => $role->updatedAt
        ]);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Rule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rule();
        $authManager = Yii::$app->authManager;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
              $role = new $model->className;
              $authManager->add($role);
              return $this->redirect(['view', 'id' => $role->name]);
            } catch (\Exception $e) {
                $model->addError('className', "Duplicate entry '{$role->name}' Role" );
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Rule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $rule = $this->findModel($id);
        Yii::$app->authManager->remove($rule);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Rule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Rule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Yii::$app->authManager->getRule($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
