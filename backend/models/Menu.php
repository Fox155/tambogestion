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
            'admin' => false,
        ],
        [
            'name' => 'Ventas',
            'icon' => 'fas fa-shopping-cart',
            'href' => '/ventas/0',
            'admin' => true,
        ],
        [
            'name' => 'Sucursales',
            'icon' => 'fas fa-kaaba',
            'href' => '/sucursales',
            'admin' => false,
        ],
        [
            'name' => 'Lotes',
            'icon' => 'fas fa-sitemap',
            'href' => '/lotes/0',
            'admin' => false,
        ],
        [
            'name' => 'Clientes',
            'icon' => 'fas fa-user-friends',
            'href' => '/clientes',
            'admin' => true,
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'fas fa-id-card',
            'href' => '/usuarios',
            'admin' => true,
        ],
        [
            'name' => 'Lista de Precios',
            'icon' => 'fas fa-money-check-alt',
            'href' => '/listas-precio',
            'admin' => true,
        ],
    ];

    /**
     * renderiza indica si el elemento se debe renderizar o no.
     */
    public static function renderiza($el)
    {
        if ($el['admin']) {
            return TiposUsuarioHelper::esAdministrador();
        }
        return true;
    }
}
