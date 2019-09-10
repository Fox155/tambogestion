<?php

namespace backend\models;

use common\components\TiposUsuarioHelper;
use yii\helpers\ArrayHelper;
use Yii;

class Menu
{
    const elements = [
        [
            'name' => 'Inicio',
            'icon' => 'fas fa-home',
            'href' => '/',
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fas fa-users',
            'href' => '/usuarios',
        ],
        [
            'name' => 'Vacas',
            'icon' => 'fas fa-store',
            'href' => '/vacas'
        ],
        [
            'name' => 'Producciones',
            'icon' => 'fas fa-tag',
            'href' => '/producciones'
        ],
    ];

    /**
     * renderiza indica si el elemento se debe renderizar o no.
     */
    public static function renderiza($el)
    {
        if (array_key_exists('permiso', $el)) {
            return Yii::$app->session->get('TipoUsuario')==$el['permiso'];
        }
        // if (array_key_exists('submenu', $el)) {
        //     return TiposUsuarioHelper::tieneAlgunPermiso(ArrayHelper::map($el['submenu'], 'permiso', 'permiso'));
        // }
        return true;
    }
}