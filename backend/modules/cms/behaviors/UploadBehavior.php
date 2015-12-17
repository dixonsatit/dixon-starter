<?php
namespace backend\modules\cms\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use trntv\filekit\behaviors\UploadBehavior as up;
/**
 * Class UploadBehavior
 * @author Satit Seethaphon <dixonsatit@gmail.com>
 */
class UploadBehavior extends up
{
  public function fields()
  {
      $fields = [
          'path' => $this->pathAttribute,
          'base_url' => $this->baseUrlAttribute,
          'type' => $this->typeAttribute,
          'size' => $this->sizeAttribute,
          'name' => $this->nameAttribute,
          'order' => $this->orderAttribute
      ];
      if ($this->attributePrefix !== null) {
          $fields = array_map(function ($fieldName) {
              return $this->attributePrefix . $fieldName;
          }, $fields);
      }
      return $fields;
  }
}
