<?php

namespace backend\modules\cms\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use trntv\filekit\behaviors\UploadBehavior;
//use backend\modules\cms\behaviors\UploadBehavior;
use creocoder\taggable\TaggableBehavior;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%cms_page}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property integer $status
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Page extends \yii\db\ActiveRecord
{

  const STATUS_DRAFT = 0;
  const STATUS_PUBLISHED = 1;
    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    public function behaviors()
    {
      return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
               'class'=>SluggableBehavior::className(),
               'attribute'=>'title',
               'immutable' => true
            ],
            [
                  'class' => UploadBehavior::className(),
                  'attribute' => 'attachments',
                  'multiple' => true,
                  'uploadRelation' => 'pageAttachments',
                  'pathAttribute' => 'path',
                  'baseUrlAttribute' => 'base_url',
                  'typeAttribute' => 'type',
                  'sizeAttribute' => 'size',
                  'nameAttribute' => 'name'
              ],
              [
                  'class' => UploadBehavior::className(),
                  'attribute' => 'thumbnail',
                  'pathAttribute' => 'thumbnail_path',
                  'baseUrlAttribute' => 'thumbnail_base_url'
              ]
      ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body', 'title'], 'required'],
            [['body'], 'string'],
            [['status', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['slug', 'title', 'view', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 255],
            [['attachments', 'thumbnail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'view' => Yii::t('app', 'View'),
            'thumbnail_base_url' => Yii::t('app', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('app', 'Thumbnail Path'),
            'status' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    public function getPageAttachments()
    {
        return $this->hasMany(Attachment::className(), ['page_id' => 'id']);;
    }
}
