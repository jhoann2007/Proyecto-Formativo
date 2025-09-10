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
    // '/calendario' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'index'
    // ],
    // '/calendario/guardarEvento' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'guardarEvento'
    // ],
    // '/calendario/obtenerEvento' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'obtenerEvento'
    // ],
    // '/calendario/obtenerEventos' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'obtenerEventos'
    // ],
    // '/calendario/eliminarEvento' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'eliminarEvento'
    // ],
    // '/calendario/registrarAprendiz' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'registrarAprendiz'
    // ],
    // '/calendario/obtenerRegistrosAprendiz' => [
    //     'controller' => 'App\Controller\CalendarioController',
    //     'action' => 'obtenerRegistrosAprendiz'
    // ],

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
    // '/agregarEntrenador' => [
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'index'
    // ],
    // '/agregarEntrenador/new' => [ // Muestra el formulario de creacion
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'new'
    // ],
    // '/agregarEntrenador/create' => [ // Crea el aprendiz en la Base de Datos 
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'create'
    // ],
    // '/agregarEntrenador/view/(\d+)' => [ // Visualiza el aprendiz con el ID especificado 
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'view'
    // ],
    // '/agregarEntrenador/edit/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'editEntrenador'
    // ],
    // '/agregarEntrenador/update' => [
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'updateEntrenador'
    // ],
    // '/agregarEntrenador/delete/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'deleteEntrenador'
    // ],
    // '/agregarEntrenador/borrar' => [
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'borrarEntrenador'
    // ],
    // '/agregarEntrenador/agregarObservacion' => [ // Ruta para agregar observaciones
    //     'controller' => 'App\Controller\AgregarEntrenadorController',
    //     'action' => 'agregarObservacion'
    // ],

    # Agregar Aprendiz
    // '/agregarAprendiz' => [
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'index'
    // ],
    // '/agregarAprendiz/create' => [ // Crea el aprendiz en la Base de Datos 
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'create'
    // ],
    // '/agregarAprendiz/view/(\d+)' => [ // Visualiza el aprendiz con el ID especificado 
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'view'
    // ],
    // '/agregarAprendiz/edit/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'editUsuario'
    // ],
    // '/agregarAprendiz/update' => [
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'updateUsuario'
    // ],
    // '/agregarAprendiz/delete/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'deleteUsuario'
    // ],
    // '/agregarAprendiz/borrar' => [
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'borrarUsuario'
    // ],
    // '/agregarAprendiz/agregarObservacion' => [ // Nueva ruta para agregar observaciones
    //     'controller' => 'App\Controller\AgregarAprendizController',
    //     'action' => 'agregarObservacion'
    // ],

    # Agregar Admin
    // '/agregarAdmin' => [
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'index'
    // ],
    // '/agregarAdmin/create' => [ // Crea el Admin en la Base de Datos 
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'create'
    // ],
    // '/agregarAdmin/view/(\d+)' => [ // Visualiza el Admin con el ID especificado 
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'view'
    // ],
    // '/agregarAdmin/edit/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'editAdmin'
    // ],
    // '/agregarAdmin/update' => [
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'updateAdmin'
    // ],
    // '/agregarAdmin/delete/(\d+)' => [
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'deleteAdmin'
    // ],
    // '/agregarAdmin/borrar' => [
    //     'controller' => 'App\Controller\AgregarAdminController',
    //     'action' => 'borrarAdmin'
    // ],

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

    # Grupo
    '/grupo' => [
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'index'
    ],
    '/grupo/create' => [ 
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'create'
    ],
    '/grupo/view/(\d+)' => [ 
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'view'
    ],
    '/grupo/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'editGroup'
    ],
    '/grupo/update' => [
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'updateGroup'
    ],
    '/grupo/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'deleteGroup'
    ],
    '/grupo/borrar' => [
        'controller' => 'App\Controller\AgregarGrupoController',
        'action' => 'borrarGroup'
    ],

    # Centros de Formación
    '/centro' => [
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'index'
    ],
    '/centro/create' => [ 
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'create'
    ],
    '/centro/view/(\d+)' => [ 
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'view'
    ],
    '/centro/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'editCenter'
    ],
    '/centro/update' => [
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'updateCenter'
    ],
    '/centro/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'deleteCenter'
    ],
    '/centro/borrar' => [
        'controller' => 'App\Controller\AgregarCentroController',
        'action' => 'borrarCenter'
    ],

    # Roles
    '/rol' => [
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'index'
    ],
    '/rol/create' => [ 
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'create'
    ],
    '/rol/view/(\d+)' => [ 
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'view'
    ],
    '/rol/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'editRole'
    ],
    '/rol/update' => [
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'updateRole'
    ],
    '/rol/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'deleteRole'
    ],
    '/rol/borrar' => [
        'controller' => 'App\Controller\AgregarRolController',
        'action' => 'borrarRole'
    ],

    # Programas
    '/programa' => [
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'index'
    ],
    '/programa/create' => [ 
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'create'
    ],
    '/programa/view/(\d+)' => [ 
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'view'
    ],
    '/programa/edit/(\d+)' => [
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'editProgram'
    ],
    '/programa/update' => [
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'updateProgram'
    ],
    '/programa/delete/(\d+)' => [
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'deleteProgram'
    ],
    '/programa/borrar' => [
        'controller' => 'App\Controller\AgregarProgramaController',
        'action' => 'borrarProgram'
    ],

    # Control de Progreso
    '/controlProgreso' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'index'
    ],
    '/controlProgreso/create' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'create'
    ],
    '/controlProgreso/view/(\d+)' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'view'
    ],
    '/controlProgreso/edit/(\d+)' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'editControl'
    ],
    '/controlProgreso/update' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'updateControl'
    ],
    '/controlProgreso/delete/(\d+)' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'deleteControl'
    ],
    '/controlProgreso/borrar' => [
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'borrarControl'
    ],
    '/controlProgreso/agregarObservacion' => [ // Nueva ruta para agregar observaciones
        'controller' => 'App\Controller\ControlProgresoController',
        'action' => 'agregarObservacion'
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
];
?>