<?php
namespace common\modules\account\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\modules\account\models\SignupForm;
use common\modules\account\models\ResendConfirmation;
use common\modules\account\models\Token;

/**
 * Registration Controller
 */
class RegistrationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                  [
                      'actions' => ['index','confirm','resend-confirmation'],
                      'allow' => true,
                      'roles' => ['?'],
                  ]
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getModule('user')->enableConfirmation == false) {
                    Yii::$app->getUser()->login($user);
                    Yii::$app->session->setFlash('success', Yii::t('user', 'Your account has been created'));
                    return $this->goHome();
                }else{
                  $successText = Yii::t("user", "Successfully registered [ {displayName} ].", ["displayName" => $user->username]);
                  return $this->render('message',[
                    'message'=>$successText.' Please check your email to confirm your account. if your can\'t recive email click '.Html::a('resend',['/user/registration/resend-confirmation'])
                  ]);
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionConfirm($token){
        $token = Token::find()->where('token=:token',[':token'=>$token])->one();
        if ($token === null || Yii::$app->getModule('user')->enableConfirmation == false ) {
              throw new NotFoundHttpException('Your confirmation token is invalid');
        }

        if(!empty($token->user->confirmed_email_at) || $token->isExpired ){
           Yii::$app->session->setFlash('danger', 'Your confirmation token is invalid or expired');
        } else {
           $token->delete();
           $token->user->confirmationAccount();
           Yii::$app->session->setFlash('success', Yii::t('user', 'Your email address has been confirmed'));
        }
        return $this->redirect(['/user/auth/login']);
    }

    public function actionResendConfirmation(){
        $model = new ResendConfirmation();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
          if($model->resendEmail()){
            Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
            return $this->redirect(['/user/auth/login']);
          }else{
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend email for email provided.');
          }
        }
        return $this->render('resend_confirmation',[
          'model'=>$model
        ]);
    }
}
