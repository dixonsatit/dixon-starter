<?php

namespace common\modules\user;

/**
 * RbacAsset
 *
 * @author Sathit Seethaphon <dixonsatit@gmail.com>
 * @since 1.0
 */
class RbacAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/user/assets';

    public $js = [
        'js/yii.rbac.js',
        '//d3js.org/d3.v3.min.js',
    ];
    public $css = [
        'css/rbac.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
