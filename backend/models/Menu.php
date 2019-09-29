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
            'href' => '/tambogestion/backend/web/',
        ],
        // [
        //     'name' => 'Usuarios',
        //     'icon' => 'fas fa-users',
        //     'href' => '/tambogestion/backend/web/usuarios',
        // ],
        [
            'name' => 'Sucursales',
            'icon' => 'fas fa-kaaba',
            'href' => '/tambogestion/backend/web/sucursales'
        ],
        [
            'name' => 'Lotes',
            'icon' => 'fas fa-sitemap',
            'href' => '/tambogestion/backend/web/lotes/0'
        ],
        // [
        //     'name' => 'Vacas',
        //     'icon' => 'fas fa-hat-cowboy-side',
        //     'href' => '/tambogestion/backend/web/vacas/?idS=0&idL=0'
        // ],
    ];

    /**
     * renderiza indica si el elemento se debe renderizar o no.
     */
    public static function renderiza($el)
    {
        // if (array_key_exists('permiso', $el)) {
        //     return Yii::$app->session->get('TipoUsuario')==$el['permiso'];
        // }
        // if (array_key_exists('submenu', $el)) {
        //     return TiposUsuarioHelper::tieneAlgunPermiso(ArrayHelper::map($el['submenu'], 'permiso', 'permiso'));
        // }
        return true;
    }
}