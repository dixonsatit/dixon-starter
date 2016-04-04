<?php
namespace common\modules\account\models;

use Yii;
use common\modules\user\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
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
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                    return Yii::$app->mailer->compose([
                        'html' => 'passwordResetToken-html',
                        'text' => 'passwordResetToken-text'],
                        ['user'=>$user])
                      ->setTo($this->email)
                      ->setFrom([Yii::$app->params['supportEmail'] => 'DX-Starter'])
                      ->setSubject('Password reset')
                      ->send();
            }
        }

        return false;
    }
}
