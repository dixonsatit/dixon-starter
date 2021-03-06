<?php

namespace common\modules\user\models;

/**
 * This is the ActiveQuery class for [[Profile]].
 *
 * @see UserProfile
 */
class ProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
