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
            'icon' => 'fas fa-id-card',
            'href' => '/usuarios',
        ],
        [
            'name' => 'Sucursales',
            'icon' => 'fas fa-kaaba',
            'href' => '/sucursales'
        ],
        [
            'name' => 'Lotes',
            'icon' => 'fas fa-sitemap',
            'href' => '/lotes/0'
        ],
        [
            'name' => 'Clientes',
            'icon' => 'fas fa-user-friends',
            'href' => '/clientes'
        ],
        [
            'name' => 'Lista de Precios',
            'icon' => 'fas fa-money-check-alt',
            'href' => '/listas-precio'
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
