<?php

namespace backend\modules\api;

use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class Api extends Module
{
    public $controllerNamespace = 'backend\modules\api\controllers';

    public function init()
    {
        Yii::$app->id = 'tg-apibackend';
        Yii::$app->user->loginUrl = null;
        Yii::$app->errorHandler->errorAction = null;

        Yii::$app->attachBehavior('access', [
            'class' => \yii\filters\AccessControl::className(),
            'rules' => [
                    [
                    'allow' => true,
                    'roles' => ['?', '@'],
                ],
            ],
        ]);

        return parent::init();
    }

    public function behaviors()
    {
        Yii::$app->detachBehavior('access');
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'OPTIONS', 'PATCH'],
                    'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                ],
            ],
        ];
    }
}
