<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ArticleCategory]].
 *
 * @see ArticleCategory
 */
class ArticleCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => ArticleCategory::STATUS_ACTIVE]);
        return $this;
    }
    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%article_category}}.parent_id IS NULL');
        return $this;
    }

    /**
     * @inheritdoc
     * @return ArticleCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ArticleCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
