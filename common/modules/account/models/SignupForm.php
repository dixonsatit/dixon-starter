<?php
namespace common\modules\account\models;

use Yii;
use yii\base\Model;
use common\models\Profile;
use common\modules\user\models\User;
use common\modules\user\models\Token;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $enableConfirmation = Yii::$app->getModule('user')->enableConfirmation;
        if ($this->validate()) {
            $profile = new Profile([
              'locale' => 'en-US'
            ]);
            $user = new User([
              'username' => $this->username,
              'email' => $this->email,
              'status' => $enableConfirmation ? User::STATUS_UNCONFIRMED : User::STATUS_ACTIVE
            ]);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $profile->link('user',$user);
                $this->assignmentDefaultRole($user->id);
                if (Yii::$app->getModule('user')->enableConfirmation) {
                  if(($token = $user->createConfirmationToken()) != null){
                     $this->sendMailConfirm($user,$token);
                  }
                }else{
                     $this->sendMailWelcome($user);
                }
                return $user;
            }
        }
        return false;
    }

    private function assignmentDefaultRole($user_id){
      $auth = Yii::$app->authManager;
      return $auth->assign($auth->getRole('User'),$user_id);
    }

    // public function createConfirmationToken(User $user){
    //   $token = new Token([
    //     'type'=>Token::TYPE_CONFIRMATION
    //   ]);
    //   return $token->link('user',$user);
    // }

    private function sendMailWelcome(User $user){
      return Yii::$app->getModule('user')->sendMail(
        Yii::t('user','Welcome! Registration is complete.'),
        'dixonsatit@gmail.com',
        ['content'=>Yii::t('user','Welcome! You have been successfully registered and logged in {name}',['name'=>Yii::$app->name])]);
    }

    private function sendMailConfirm(User $user,Token $token){
        return Yii::$app->getModule('user')->sendMail(
        Yii::t('user','Verify Your Account.'),
        $user->email,
        ['token' => $token,'user'=>$user],
        'confirmEmailToken');
    }
}
