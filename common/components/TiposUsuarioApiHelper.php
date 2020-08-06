<?php

namespace common\components;

use common\models\Usuarios;
use Yii;
use yii\web\HttpException;

class TiposUsuarioApiHelper
{
    /**
     * Verifica si el usuario tiene el permiso de administradoe. Tira excepción en caso contrario.
     *
     * @throws HttpException Si no no tiene permiso
     */
    public static function dameSiAdministrador()
    {
        $user = self::dameUsuarioPorToken();
        if ($user['TipoUsuario'] === 'Administrador') {
            return $user;
        }
        self::tirarExcepcion();
    }

    /**
     * Verifica si el usuario tiene el permiso de administradoe. Tira excepción en caso contrario.
     *
     * @throws HttpException Si no no tiene permiso
     */
    public static function verificarAdministrador()
    {
        if (!self::esAdministrador()) {
            self::tirarExcepcion();
        }   
    }

    /**
     * Retorna si el usuario tiene el permiso de administrador.
     *
     * @return bool Es administrador
     */
    public static function esAdministrador(): bool
    {
        return Yii::$app->user->identity['TipoUsuario'] === 'Administrador';
    }

    private static function dameUsuarioPorToken()
    {
        $token = '';
        if (Yii::$app->request->post('Token')){
            $token = Yii::$app->request->post('Token');
        }
        return Usuarios::findIdentityByAccessToken($token);
    }

    private static function tirarExcepcion()
    {
        throw new HttpException('403', 'No se tienen los permisos necesarios para ver la página solicitada.');
    }
}