<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "{{%app_todos}}".
 *
 * @property integer $id
 * @property string $todo
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Todo extends ActiveRecord
{

  // public function getLinks()
  //   {
  //       return [
  //           Link::REL_SELF => Url::to(['todo/view', 'id' => $this->id], true),
  //       ];
  //   }
  //
    public function behaviors()
    {
        return [
             BlameableBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_todos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['todo'], 'required'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['todo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'todo' => 'Todo',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return TodoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TodoQuery(get_called_class());
    }
}
