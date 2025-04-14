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
    ],

    # Agregar Aprendiz
    '/agregarAprendiz' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'index'
    ],

    # Calendario
    '/calendario' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'index'
    ],

    # Codigo de Verificacion
    '/codigo' => [
        'controller' => 'App\Controller\CodigoVerificacionController',
        'action' => 'index'
    ],

    # Inicio
    '/inicio' => [
        'controller' => 'App\Controller\InicioController',
        'action' => 'index'
    ],

    # Olvido Contraseña
    '/olvido' => [
        'controller' => 'App\Controller\OlvidoContraseniaController',
        'action' => 'index' 
    ],

    # Ingreso Sistema
    '/ingreso' => [
    'controller' => 'App\Controller\ingresoController',
    'action' => 'index' 
    ]
];
?>