<?php
return [

    # EJEMPLOS
    '/' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'index'
    ],
    '/home' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'index'
    ],
    '/saludo' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'saludar'
    ],
    # perfil
    '/perfil' => [
        'controller' => 'App\Controller\PerfilController',
        'action' => 'index'
    ]
];
?>