<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'as locale' => [
        'class' => 'common\components\LocaleBehavior',
        'enablePreferredLanguage' => true
    ],
    'components' => [
      'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
          'translations' => [
              'app'=>[
                  'class' => 'yii\i18n\PhpMessageSource',
                  'basePath'=>'@app/messages',
              ],
              '*'=> [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'basePath'=>'@common/messages',
                  'fileMap'=>[
                      'backend'=>'backend.php',
                      'common'=>'common.php',
                      'frontend'=>'frontend.php',
                  ]
              ],
              /* Uncomment this code to use DbMessageSource
               '*'=> [
                  'class' => 'yii\i18n\DbMessageSource',
                  'sourceMessageTable'=>'{{%i18n_source_message}}',
                  'messageTable'=>'{{%i18n_message}}',
                  'enableCaching' => YII_ENV_DEV,
                  'cachingDuration' => 3600,
                  'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
              ],
              */
          ],
      ],
    ],
];
