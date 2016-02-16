<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Assignment]].
 *
 * @see Assignment
 */
class AssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Assignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Assignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}