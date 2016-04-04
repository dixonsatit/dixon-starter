<?php

namespace common\modules\user\models;

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
 * @property string $website
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
            [['locale'], 'required'],
            [['gender'], 'integer'],
            [['website'], 'url'],
            [['firstname', 'title', 'lastname', 'avatar_path', 'avatar_base_url','website'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('common', 'User ID'),
            'title' => Yii::t('common', 'Title'),
            'firstname' => Yii::t('common', 'Firstname'),
            'lastname' => Yii::t('common', 'Lastname'),
            'avatar_path' => Yii::t('common', 'Avatar Path'),
            'avatar_base_url' => Yii::t('common', 'Avatar Base Url'),
            'locale' => Yii::t('common', 'Locale'),
            'gender' => Yii::t('common', 'Gender'),
            'picture' => Yii::t('common', 'Profile picture'),
            'website' => Yii::t('common', 'Website'),
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

    /**
     * @inheritdoc
     */
    public function getUser(){
      return $this->hasOne(User::className(),['id'=>'user_id']);
    }
}
