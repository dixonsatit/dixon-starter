<?php

namespace common\modules\user\models;

use Yii;
use yii\base\Model;
use yii\rba\Item as RbacItem;
/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 */
class Item extends Model
{

  public $name;
  public $type;
  public $description;
  public $ruleName;
  public $data;
  public $createdAt;
  public $updatedAt;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['type', 'in', 'range' => [RbacItem::TYPE_ROLE, RbacItem::TYPE_PERMISSION]],
            [['type', 'createdAt', 'updatedAt'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'ruleName'], 'string', 'max' => 64]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'ruleName' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function find()
    {

    }
}
