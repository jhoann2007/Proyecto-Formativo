<?php
return [
    # RUTINAS
    '/agregarRutina' => [
        'controller' => 'App\Controller\RutinaController',
        'action' => 'index'
    ],
    
    '/rutina/new' => [
        'controller' => 'App\Controller\RutinaController',
        'action' => 'new'
    ],
    '/rutina/create' => [
        'controller' => 'App\Controller\RutinaController',
        'action' => 'create'
    ],
    '/rutina/verEjercicios/(\d+)' => [
        'controller' => 'App\Controller\RutinaController',
        'action' => 'verEjercicios'
    ],
    # EJEMPLOS
    '/home' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'index'
    ],
    '/saludo' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'saludar'
    ],

    #LOGIN
    '/' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'index'
    ],
    '/login' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'login'
    ],
    '/cerrar' => [
        'controller' => 'App\Controller\HomeController',
        'action' => 'cerrar'
    ],

    # Perfil
    '/perfil' => [
        'controller' => 'App\Controller\PerfilController',
        'action' => 'index'
    ],

    # Calendario
    '/calendario' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'index'
    ],
    '/calendario/guardarEvento' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'guardarEvento'
    ],
    '/calendario/obtenerEvento' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'obtenerEvento'
    ],
    '/calendario/obtenerEventos' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'obtenerEventos'
    ],
    '/calendario/eliminarEvento' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'eliminarEvento'
    ],
    '/calendario/registrarAprendiz' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'registrarAprendiz'
    ],
    '/calendario/obtenerRegistrosAprendiz' => [
        'controller' => 'App\Controller\CalendarioController',
        'action' => 'obtenerRegistrosAprendiz'
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
    ],
    
    # Agregar Entrenador
    '/agregarEntrenador' => [
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'index'
    ],
    '/agregarEntrenador/new' => [ // Muestra el formulario de creacion
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'new'
    ],
    '/agregarEntrenador/create' => [ // Crea el aprendiz en la Base de Datos 
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'create'
    ],
    '/agregarEntrenador/view/(\d+)' => [ // Visualiza el aprendiz con el ID especificado 
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'view'
    ],
    '/agregarEntrenador/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'editEntrenador'
    ],
    '/agregarEntrenador/update' => [
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'updateEntrenador'
    ],
    '/agregarEntrenador/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'deleteEntrenador'
    ],
    '/agregarEntrenador/borrar' => [
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'borrarEntrenador'
    ],
    '/agregarEntrenador/agregarObservacion' => [ // Ruta para agregar observaciones
        'controller' => 'App\Controller\AgregarEntrenadorController',
        'action' => 'agregarObservacion'
    ],

    # Agregar Aprendiz
    '/agregarAprendiz' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'index'
    ],
    '/agregarAprendiz/create' => [ // Crea el aprendiz en la Base de Datos 
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'create'
    ],
    '/agregarAprendiz/view/(\d+)' => [ // Visualiza el aprendiz con el ID especificado 
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'view'
    ],
    '/agregarAprendiz/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'editUsuario'
    ],
    '/agregarAprendiz/update' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'updateUsuario'
    ],
    '/agregarAprendiz/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'deleteUsuario'
    ],
    '/agregarAprendiz/borrar' => [
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'borrarUsuario'
    ],
    '/agregarAprendiz/agregarObservacion' => [ // Nueva ruta para agregar observaciones
        'controller' => 'App\Controller\AgregarAprendizController',
        'action' => 'agregarObservacion'
    ],

    # Agregar Admin
    '/agregarAdmin' => [
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'index'
    ],
    '/agregarAdmin/create' => [ // Crea el Admin en la Base de Datos 
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'create'
    ],
    '/agregarAdmin/view/(\d+)' => [ // Visualiza el Admin con el ID especificado 
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'view'
    ],
    '/agregarAdmin/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'editAdmin'
    ],
    '/agregarAdmin/update' => [
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'updateAdmin'
    ],
    '/agregarAdmin/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'deleteAdmin'
    ],
    '/agregarAdmin/borrar' => [
        'controller' => 'App\Controller\AgregarAdminController',
        'action' => 'borrarAdmin'
    ],
];
?>