<?php
namespace common\modules\account\models;

use Yii;
use common\modules\user\models\User;
use yii\base\Model;

class ResendConfirmation extends Model{

  public $email;

  /**
   * @inheritdoc
   */
  public function rules()
  {
      return [
          ['email', 'filter', 'filter' => 'trim'],
          ['email', 'required'],
          ['email', 'email'],
          ['email', 'exist',
              'targetClass' => '\common\modules\user\models\User',
              'filter' => ['status' => User::STATUS_UNCONFIRMED],
              'message' => 'There is no user with such email.'
          ],
      ];
  }

  public function resendEmail(){
    $user = User::findOne([
        'status' => User::STATUS_UNCONFIRMED,
        'email' => $this->email,
    ]);
    if($user){
      if(($token = $user->createConfirmationToken()) != null){
          $this->sendMailConfirm($user,$token);
          return true;
      }
    }
    return false;
  }

  private function sendMailConfirm(User $user,Token $token){
      return Yii::$app->getModule('user')->sendMail(
      Yii::t('user','Verify Your Account.'),
      $user->email,
      ['token' => $token,'user'=>$user],
      'confirmEmailToken');
  }
}
