<?php
return [
    'timeZone' => 'America/Argentina/Tucuman',
    'language' => 'es',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
        // 'user' => [
        //     'identityClass' => 'common\models\Usuarios',
        //     'loginUrl' => 'usuarios/login',
        //     'authTimeout' => 60 * 60,
        // ],
        // 'cache' => [
        //     'class' => 'yii\caching\FileCache',
        //     'user' => [
        //         'identityClass' => 'common\models\Usuarios',
        //         'loginUrl' => '/usuarios/login',
        //         'authTimeout' => 60 * 60,
        //     ],
        // ], 
        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'rules' => [
        //         '<controller>/<id:\d+>' => '<controller>',
        //         '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
        //         '<controller>/index' => '<controller>',
        //     ],
        // ],
        'formatter' => [
            'defaultTimeZone' => 'America/Argentina/Tucuman',
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyyy H:mm',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'locale' => 'es-AR'
        ],
    ],
];