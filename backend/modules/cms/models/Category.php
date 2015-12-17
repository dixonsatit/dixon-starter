<?php

namespace backend\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%cms_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $detail
 * @property integer $status
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{

  const STATUS_ACTIVE = 1;

  const STATUS_DRAFT = 0;

    public function behaviors()
    {
      return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
      ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'parent_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'detail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'detail' => Yii::t('app', 'Detail'),
            'status' => Yii::t('app', 'Status'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public function itemsAlias($key){
      $items = [
        'status'=>[
            self::STATUS_DRAFT  => 'Draft' ,
            self::STATUS_ACTIVE => 'Active' ,
        ]
      ];
      return array_key_exists($key, $items) ? $items[$key] : [];
    }

    public function getItemStatus(){
      return $this->itemsAlias('status');
    }
    
    public function getItemStatusName(){
      $items = $this->itemsAlias('status');
      return array_key_exists($this->status, $items) ? $items[$key] : [];
    }

}
