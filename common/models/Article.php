<?php
namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property integer $category_id
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 *
 * @property User $author
 * @property User $updater
 */
class Article extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

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
           [
               'class'=>BlameableBehavior::className(),
               'createdByAttribute' => 'author_id',
               'updatedByAttribute' => 'updater_id',
           ],
           [
               'class'=>SluggableBehavior::className(),
               'attribute'=>'title',
               'immutable' => true
           ],
           [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'articleAttachments',
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
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['slug'], 'unique'],
            [['published_at'], 'default', 'value' => time()],
            [['published_at'], 'filter', 'filter' => 'strtotime'],
            [['category_id', 'author_id', 'updater_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['view'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['attachments', 'thumbnail'], 'safe']
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
            'category_id' => Yii::t('app', 'Category'),
            'author_id' => Yii::t('app', 'Author ID'),
            'updater_id' => Yii::t('app', 'Updater ID'),
            'status' => Yii::t('app', 'Published'),
            'published_at' => Yii::t('app', 'Published At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'thumbnail_base_url' => Yii::t('app', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('app', 'Thumbnail Path'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::className(), ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
