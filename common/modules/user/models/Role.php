<?php

namespace common\modules\user\models;

use Yii;
use yii\base\Model;
use yii\rbac\Item;
use yii\data\ArrayDataProvider;
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
class Role extends Model
{

    public $name;
    public $type;
    public $description;
    public $ruleName;
    public $data;
    public $createdAt;
    public $updatedAt;
    private $_item = null;

    public function init(){

    }

    public function setOldAttribute(){
      $this->_item = (object) $this->attributes;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
          [['name'], 'required'],
          ['type','default','value'=>Item::TYPE_PERMISSION],
          [['type', 'createdAt', 'updatedAt'], 'integer'],
          [['description', 'data'], 'string'],
          [['name', 'ruleName'], 'string', 'max' => 64]
      ];
    }

    public function save(){
      if($this->validate()){
        $authManager = Yii::$app->authManager;

        if($this->isNewRecord){
          $model = $authManager->createRole($this->name);
        }else{
          $model = $authManager->getRole($this->getOldAttribute('name'));
          $model->name = $this->name;
        }

        $model->description = $this->description;
        $model->ruleName = $this->ruleName ?: null;
        $model->data = $this->data;
        return $this->isNewRecord ? $authManager->add($model) : $authManager->update($this->getOldAttribute('name'),$model);
      }else{
        return false;
      }
    }

    public function delete(){
      $model = Yii::$app->authManager->getRole($this->name);
      return $model !== null ? Yii::$app->authManager->remove($model) : false;
    }

    /**
     * get the named permission.
     * @param  string $name permission name
     * @return null|yii\rbac\Role
     */
    public static function findOne($id)
    {
       $item = Yii::$app->authManager->getRole($id);
       if ($item !== null) {
           $model = new static($item);
           $model->setOldAttribute();
           return $model;
       }
       return null;
    }

    /**
     * get all permissions
     * @return yii\rbac\Role[]
     */
    public static function findAll()
    {
        $items = Yii::$app->authManager->getRoles();
        $models = [];
        foreach ($items as $key => $item) {
          $models[$key] =  new static($item);
        }
        return $models;
    }

    public function search(){
        $models = static::findAll();
        return new ArrayDataProvider([
          'allModels'=>$models
        ]);
    }

    public function getIsNewRecord()
    {
       return $this->_item === null;
    }

    public function getOldAttribute($attribute){
      return isset($this->_item->$attribute) ? $this->_item->$attribute : '';
    }

    public function getOldAttributes(){
      return $this->_item;
    }

}
