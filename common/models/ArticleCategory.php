<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_category}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Article[] $articles
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $articleCategories
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

  const STATUS_ACTIVE = 1;
  const STATUS_DRAFT = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['body'], 'string'],
            [['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ArticleCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleCategoryQuery(get_called_class());
    }
}
