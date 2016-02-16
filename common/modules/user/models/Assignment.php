<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class Assignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('rbac', 'Item Name'),
            'user_id' => Yii::t('rbac', 'User ID'),
            'created_at' => Yii::t('rbac', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    /**
     * @inheritdoc
     * @return AssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssignmentQuery(get_called_class());
    }

    public static function getAllItemsAssigned($user_id){
      $assigned = [];
      $authManager = Yii::$app->authManager;
      $assigned['Roles'] = ArrayHelper::map($authManager->getRolesByUser($user_id),'name','name');
      $assigned['Permissions'] = ArrayHelper::map($authManager->getPermissionsByUser($user_id),'name','name');
      return $assigned;
    }
}
