<?php

namespace common\modules\user\models;

use Yii;
use common\modules\user\models\User;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property integer $created_at
 * @property integer $expire_at
 * @property string $type
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
  const TYPE_CONFIRMATION='confirm';
  const TYPE_RECOVERY = 'recovery';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'expire_at'], 'integer'],
            [['type'], 'required'],
            [['type'], 'string'],
            [['token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'created_at' => 'Created At',
            'expire_at' => 'Expire At',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            static::deleteAll(['user_id' => $this->user_id, 'type' => $this->type]);
            $this->setAttribute('created_at', time());
            $this->setAttribute('token', Yii::$app->security->generateRandomString());
        }
        return parent::beforeSave($insert);
    }

    /**
      * @return bool Whether token has expired.
      */
     public function getIsExpired()
     {
         switch ($this->type) {
             case self::TYPE_CONFIRMATION:
             case self::TYPE_RECOVERY:
                 $expirationTime = Yii::$app->getModule('user')->confirmWithin;
                 break;
             default:
                 throw new \RuntimeException();
         }
         return ($this->created_at + $expirationTime) < time();
     }
}
