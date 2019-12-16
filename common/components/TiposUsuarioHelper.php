<?php

namespace common\components;

use Yii;
use yii\web\HttpException;

class TiposUsuarioHelper
{

    /**
     * Guarda el tipo de usuario en la sesión.
     *
     * @param array $permisos
     */
    public static function guardarTipoUsuarioSesion(string $tipo)
    {
        Yii::$app->session->set('TipoUsuario', $tipo);
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
        return Yii::$app->session->get('TipoUsuario') === 'Administrador';
    }

    private static function tirarExcepcion()
    {
        throw new HttpException('403', 'No se tienen los permisos necesarios para ver la página solicitada.');
    }
}