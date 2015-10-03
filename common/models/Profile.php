<?php

namespace common\models;

use Yii;
use trntv\filekit\behaviors\UploadBehavior;
/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $title
 * @property string $lastname
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $locale
 * @property integer $gender
 */
class Profile extends \yii\db\ActiveRecord
{

  const GENDER_MALE = 1;
  const GENDER_FEMALE = 2;

  public $picture;

   public function behaviors()
   {
       return [
           'picture' => [
               'class' => UploadBehavior::className(),
               'attribute' => 'picture',
               'pathAttribute' => 'avatar_path',
               'baseUrlAttribute' => 'avatar_base_url'
           ]
       ];
   }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','locale'], 'required'],
            [['gender'], 'integer'],
            [['firstname', 'title', 'lastname', 'avatar_path', 'avatar_base_url'], 'string', 'max' => 255],
            [['locale'], 'string', 'max' => 32],
            ['picture', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'avatar_path' => Yii::t('app', 'Avatar Path'),
            'avatar_base_url' => Yii::t('app', 'Avatar Base Url'),
            'locale' => Yii::t('app', 'Locale'),
            'gender' => Yii::t('app', 'Gender'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }

    public function getGenderItems()
    {
        return [
          self::GENDER_MALE => Yii::t('app','Male'),
          self::GENDER_FEMALE => Yii::t('app','Female')
        ];
    }
}
