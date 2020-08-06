<?php

namespace backend\modules\api\controllers;

use Yii;
use common\models\Usuarios;
use yii\web\HttpException;

class SesionesController extends BaseController
{
    public function actionCreate()
    {
        $usuario = Yii::$app->request->post('Usuario');
        $password = Yii::$app->request->post('Password');
        // $cadena = Yii::$app->request->post('TokenAPI');
        // $app = Yii::$app->request->post('App');

        $user = new Usuarios();
        $user->setScenario(Usuarios::_LOGIN);
        $user->Usuario = $usuario;
        $mensaje = $user->Login('A', $password, Yii::$app->security->generateRandomString(300));
        if ($mensaje['Mensaje'] == 'OK') {
            return [
                'Login' => $mensaje['Mensaje'],
                'Usuario' => $user,
                'Token' => $user->Token,
            ];
        } else {
            throw new HttpException(422, $mensaje['Login']);
        }
    }
}
