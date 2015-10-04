<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $confirm_new_password;
    public $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_password', 'new_password','confirm_new_password'], 'required'],
            [['old_password','new_password','confirm_new_password'], 'string', 'min' => 6],
            ['old_password', 'validateOldPassword'],
            ['confirm_new_password', 'compare','compareAttribute'=>'new_password'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect old password.');
            }
        }
    }

    public function save(){
      $model = $this->getUser();
      $model->setPassword($this->new_password);
      return $model->save();
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }
        return $this->_user;
    }
}
