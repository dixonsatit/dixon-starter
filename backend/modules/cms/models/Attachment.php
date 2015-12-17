<?php

namespace backend\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%cms_attachment}}".
 *
 * @property integer $id
 * @property integer $ref_id
 * @property string $path
 * @property string $base_url
 * @property string $name
 * @property integer $type
 * @property integer $size
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Attachment extends \yii\db\ActiveRecord
{

  public function behaviors()
  {
    return [
          TimestampBehavior::className(),
          BlameableBehavior::className()
    ];
  }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'page_id', 'path', 'base_url', 'name'], 'required'],
            [['post_id', 'page_id', 'type', 'size', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path', 'base_url', 'name'], 'string', 'max' => 255],
            ['group','default','value'=>'post']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ref_id' => Yii::t('app', 'Referent ID'),
            'path' => Yii::t('app', 'Path'),
            'base_url' => Yii::t('app', 'Base Url'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return AttachmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttachmentQuery(get_called_class());
    }
}
