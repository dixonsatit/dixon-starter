<?php

namespace backend\modules\cms\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use creocoder\taggable\TaggableBehavior;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $published_at
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
class Post extends \yii\db\ActiveRecord
{
  /**
   * @var array
   */
  public $attachments;

  /**
   * @var array
   */
  public $thumbnail;

  /**
   * @var array
   */
  public $tag;

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
          'taggable' => [
              'class' => TaggableBehavior::className(),
              'tagValuesAsArray' => true,
              // 'tagRelation' => 'tags',
              // 'tagValueAttribute' => 'name',
              // 'tagFrequencyAttribute' => 'frequency',
          ],
          [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'postAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
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
        return '{{%cms_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title','body','category_id'], 'required'],
            [['body'], 'string'],
            [['published_at'], 'safe'],
            [['status', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['slug', 'title', 'view', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 255],
            [['tagValues','tag','attachments', 'thumbnail'], 'safe'],
        ];
    }


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
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
            'published_at' => Yii::t('app', 'Published At'),
            'view' => Yii::t('app', 'View'),
            'thumbnail_base_url' => Yii::t('app', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('app', 'Thumbnail Path'),
            'status' => Yii::t('app', 'Published'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function getAuthor(){
      return $this->hasOne(User::className(),['id'=>'created_by']);
    }

    public function getAuthorName(){
      return isset($this->author) ? $this->author->username : null;
    }

    public function getPostAttachments()
    {
        return $this->hasMany(Attachment::className(), ['post_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%cms_post_tag_assn}}', ['post_id' => 'id']);
    }

    public function getTagSelected(){
      return $this->tagValues;
    }

    public function getAllTag(){
      $tagValues = [];
      $tags = Tag::find()->all();
        foreach ($tags as  $tag) {
          $tagValues[$tag->name] = $tag->name;
        }
      return $tagValues;
    }

    public function itemAlias($key){
      $items = [
        'status'=>[
          '0'=>Yii::t('app', 'Pending'),
          '1'=>Yii::t('app', 'Plublished')
        ]
      ];
      return isset($items[$key]) ? $items[$key] : [];
    }

    public function getItemStatus(){
      return $this->itemAlias('status');
    }

    public function getStatusName(){
      $item =  $this->itemAlias('status');
      return isset($item[$this->status]) ? $item[$this->status] : null;
    }
}
