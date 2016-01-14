<?php
namespace common\modules\user\models;

use Yii;
use yii\helpers\Html;
use yii\base\Model;
use common\modules\user\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password', 'validateConfirmation'],
            ['password', 'validateBlocked'],

        ];
    }

    /**
     * Validate account is blocked
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateBlocked($attribute, $params){
      if (!$this->hasErrors()) {
          $user = $this->getUser();
          if (!$user || $user->getIsBlocked()) {
              $this->addError($attribute, Yii::t('common', 'Your account is blocked.'));
          }
      }
    }

    /**
     * Validate account is confirmation
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateConfirmation($attribute, $params){
      if (!$this->hasErrors()) {
          $user = $this->getUser();
          if (!$user || $user->getIsUnConfirmed()) {
              $this->addError($attribute, Yii::t('common', 'Your account is not confirmation.'));
          }
      }
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
