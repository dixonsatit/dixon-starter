<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
      'fileStorage'=>[
            'class' => 'trntv\filekit\Storage',
            'baseUrl' => '@web/uploads',
            'filesystem'=> [
                'class' => 'common\components\LocalFlysystemBuilder',
                'path' => '@backend/web/uploads'
            ]
      ],
      'glide' => [
        'class' => 'trntv\glide\components\Glide',
        'sourcePath' => '@backend/web/uploads',
        'cachePath' => '@runtime/glide',
        'signKey' => false // "false" if you do not want to use HTTP signatures
      ],
      'authManager' => [
          'class' => 'yii\rbac\DbManager',
      ],
      'cache' => [
            'class' => 'yii\caching\FileCache',
      ],
      'i18n' => [
      			'translations' => [
        				'*' => [
        					'class' => 'yii\i18n\PhpMessageSource',
        					'basePath' => '@common/messages',
        				],
      			],
    	],
    ],
];
