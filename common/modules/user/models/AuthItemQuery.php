<?php

namespace common\modules\user\models;

/**
 * This is the ActiveQuery class for [[AuthItem]].
 *
 * @see AuthItem
 */
class AuthItemQuery extends \yii\db\ActiveQuery
{
    public function byRole()
    {
        $this->andWhere('[[type]]=1');
        return $this;
    }
    
    public function byPermission()
    {
        $this->andWhere('[[type]]=2');
        return $this;
    }

    /**
     * @inheritdoc
     * @return AuthItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AuthItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
