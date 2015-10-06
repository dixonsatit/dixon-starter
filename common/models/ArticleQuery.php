<?php

namespace common\models;

use common\models\Article;

/**
 * This is the ActiveQuery class for [[Article]].
 *
 * @see Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{

    public function published()
    {
        $this->andWhere(['status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
        return $this;
    }

    public function knowledge()
    {
        $this->andWhere(['category_id' => 2]); // career
        return $this;
    }

    public function activities()
    {
        $this->andWhere(['category_id' => 1]); // products
        return $this;
    }

    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
