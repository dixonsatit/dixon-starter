<?php

namespace common\modules\user\models;

use Yii;
use yii\base\Model;
use yii\rbac\Rule as BaseRule;
use yii\data\ArrayDataProvider;

/**
 *
 * @property string $name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class Rule extends Model
{
   public $name;
   public $createdAt;
   public $updatedAt;
   public $className;
   public $_item;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['className'], 'required'],
            [['createdAt', 'updatedAt'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['className'], 'string', 'max' => 256],
            [['className'], 'classExists']
        ];
    }

    public function classExists()
    {
        if (!class_exists($this->className) || !is_subclass_of($this->className, BaseRule::className())) {
            $this->addError('className', "Unknown Class: {$this->className}");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            [['name', 'className'], 'required'],
            'name' => Yii::t('user', 'Name'),
            'createdAt' => Yii::t('user', 'Created At'),
            'updatedAt' => Yii::t('user', 'Updated At'),
        ];
    }

    public function search($params)
    {
       $authManager = Yii::$app->authManager;
       $models = [];
       foreach ($authManager->getRules() as $name => $item) {
          $models[$name] = new static([
            'name' => $item->name,
            'className' => get_class($item)
          ]);
       }

       return new ArrayDataProvider([
          'allModels' => $models,
       ]);
    }
}
