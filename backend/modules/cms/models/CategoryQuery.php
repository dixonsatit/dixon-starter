<?php

namespace backend\modules\cms\models;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
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
        $this->andWhere(['status' => Category::STATUS_ACTIVE]);
        return $this;
    }
    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%cms_category}}.parent_id IS NULL');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
