<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ArticleAttachment]].
 *
 * @see ArticleAttachment
 */
class ArticleAttachmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ArticleAttachment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ArticleAttachment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}