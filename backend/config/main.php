<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'tambogestion-backend',
    'name' => 'Tambo Gestion | Backend',
    'language' => 'es',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'class' => 'yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\Usuarios',
            'loginUrl' => '/usuarios/login',
            'authTimeout' => 60 * 60,
            // 'enableAutoLogin' => true,
            // 'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<id:\d+>' => '<controller>',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller>/index' => '<controller>',
            ],
        ],
        
    ],
    // 'as access' => [
    //     'class' => 'yii\filters\AccessControl',
    //     'rules' => [
    //         /**
    //          *  Usuarios no logueados
    //          */
    //         [
    //             'allow' => true,
    //             'actions' => ['login', 'error'],
    //         ],
    //         /**
    //          *  Debug
    //          */
    //         [
    //             'allow' => true,
    //             'controllers' => ['debug', 'default', 'debug/default'],
    //         ],
    //         /**
    //          *  Usuarios logueados, están activos y tienen Token bueno
    //          */
    //         [
    //             'allow' => true,
    //             'roles' => ['@'],
    //             'matchCallback' => function () {
    //                 $usuario = Yii::$app->user->identity;
    //                 $token = Yii::$app->session->get('Token');
    //                 return $usuario->Estado == 'A' && $usuario->Token == $token;
    //             },
    //         ],
    //     ],
    // ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;