<?php
$conf = [
    'timeZone' => 'America/Argentina/Tucuman',
    'language' => 'es',
    'name' => 'Tambo Gestion',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
        'user' => [
            'identityClass' => 'common\models\Usuarios',
            'loginUrl' => 'usuarios/login',
            'authTimeout' => 60 * 60,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'user' => [
                'identityClass' => 'common\models\Usuarios',
                'loginUrl' => '/usuarios/login',
                'authTimeout' => 60 * 60,
            ],
        ], 
        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'rules' => [
        //         '<controller>/<id:\d+>' => '<controller>',
        //         '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
        //         '<controller>/index' => '<controller>',
        //     ],
        // ],
    ],
];

// Si se encuentra en modo Desarrollo
if (YII_ENV_DEV) {
    $conf['bootstrap'][] = 'debug';
    $conf['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $conf;