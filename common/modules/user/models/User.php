<?php

namespace common\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $confirmed_email_at
 *
 * @property UserToken[] $userTokens
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_BLOCKED     = 0;
    const STATUS_ACTIVE      = 1;
    const STATUS_UNCONFIRMED = 2;

    public $password;
    public $old_password;
    public $confirm_password;
    public $roles;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['registration'] = ['username','email'];
        $scenarios['settings'] = ['username','email','password','confirm_password'];
        return $scenarios;
    }

    public function behaviors()
    {
      return [
        TimestampBehavior::className(),
      ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED, self::STATUS_UNCONFIRMED]],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required','on'=>'update'],
            ['password', 'string', 'min' => 6],

            ['confirm_password', 'required','on'=>'update'],
            ['confirm_password', 'string', 'min' => 6],
            ['confirm_password', 'compare','compareAttribute'=>'password'],

            [['confirmed_email_at','password_reset_at'], 'integer'],
            ['roles', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'id' => Yii::t('app', 'ID'),
           'username' => Yii::t('app', 'Username'),
           'auth_key' => Yii::t('app', 'Auth Key'),
           'password_hash' => Yii::t('app', 'Password Hash'),
           'password_reset_token' => Yii::t('app', 'Password Reset Token'),
           'email' => Yii::t('app', 'Email'),
           'status' => Yii::t('app', 'Status'),
           'created_at' => Yii::t('app', 'Created At'),
           'updated_at' => Yii::t('app', 'Updated At'),
           'confirmed_email_at' => Yii::t('app', 'Confirmed Email At'),
           'password' => Yii::t('common', 'Password'),
           'confirm_password' => Yii::t('common', 'Confirm Password'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
      $this->password_reset_token = null;
    }

    /*==================== STATUS =====================*/
    public function getIsActive(){
      return $this->status == static::STATUS_ACTIVE;
    }

    public function getIsUnConfirmed(){
      return $this->status == static::STATUS_UNCONFIRMED;
    }

    public function getIsBlocked(){
      return $this->status == static::STATUS_BLOCKED;
    }

    public function getItemStatus(){
      return [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_BLOCKED => 'Blocked'
      ];
    }

    public function getStatusName()
    {
      $items = $this->getItemStatus();
      return array_key_exists($this->status, $items) ? $items[$this->status] : '';
    }

    public function getAllRoles(){
      $auth = $auth = Yii::$app->authManager;
      return ArrayHelper::map($auth->getRoles(),'name','name');
    }

    public function getRoleByUser(){
      $auth = Yii::$app->authManager;
      $rolesUser = $auth->getRolesByUser($this->id);
      $roleItems = $this->getAllRoles();
      $roleSelect=[];

      foreach ($roleItems as $key => $roleName) {
        foreach ($rolesUser as $role) {
          if($key==$role->name){
            $roleSelect[$key]=$roleName;
          }
        }
      }
      $this->roles = $roleSelect;
    }

    public function assignment(){
        $auth = Yii::$app->authManager;
        $roleUser = $auth->getRolesByUser($this->id);
        $auth->revokeAll($this->id);
        foreach ($this->roles as $key => $roleName) {
          $auth->assign($auth->getRole($roleName),$this->id);
        }
    }

    /**
     * @inheritdoc
     */
    public function getProfile(){
      return $this->hasOne(Profile::className(),['user_id'=>'id']);
    }

    public function createConfirmationToken(){
      $token = new Token([
        'type' => Token::TYPE_CONFIRMATION
      ]);
       $token->link('user',$this);
       return $token;
    }

    public function confirmationAccount(){
      $this->confirmed_email_at = time();
      $this->status = self::STATUS_ACTIVE;
      return $this->save();
    }
}
