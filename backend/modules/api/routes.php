<?php

return [
    [
        'class' => yii\rest\UrlRule::className(),
        'controller' => [
            'api/producciones',
        ],
        'pluralize' => false,
        'patterns' => [
            'POST' => 'alta',
            '' => 'options'
        ],
    ],
    [
        'class' => yii\rest\UrlRule::className(),
        'controller' => [
            'api/sesiones',
        ],
        'pluralize' => false,
        'patterns' => [
            'POST' => 'create',
            '' => 'options'
        ],
    ],
    [
        'class' => yii\rest\UrlRule::className(),
        'controller' => [
            'api/usuarios',
        ],
        'pluralize' => false,
        'patterns' => [
            'POST' => 'index',
            '' => 'options'
        ],
    ],
    [
        'class' => yii\rest\UrlRule::className(),
        'controller' => [
            'api/clientes',
            'api/listas-precio',
        ],
        'pluralize' => false,
        'patterns' => [
            'GET' => 'index',
            'GET,HEAD {id}' => 'historico',
            'POST' => 'alta',
            'PUT' => 'editar',
            'PATCH' => 'darbaja',
            '{id}' => 'options',
            '' => 'options'
        ],
    ],
];
