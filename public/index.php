<?php
require_once '../app/config/global.php';
require_once '../app/controllers/homeController.php';
require_once '../app/controllers/perfilController.php';
require_once '../app/controllers/agregarAprendizController.php';
require_once '../app/controllers/calendarioController.php';
require_once '../app/controllers/codigoVerificacionController.php';
require_once '../app/controllers/inicioController.php';
require_once '../app/controllers/olvidoContraseniaController.php';
require_once '../app/controllers/ingresoController.php';



// Acceder a lo que llegue en la URL
$url = $_SERVER["REQUEST_URI"];

$routesList = require_once '../app/config/routes.php';

$matchedRoute = null;
foreach ($routesList as $route => $routeConfig) {
    if (preg_match("#^$route$#", $url, $matches)) {
        // Se asigna el Array requerido con el Controller y Action a ejecutar 
        $matchedRoute = $routeConfig;
        break;
    }
}

if ($matchedRoute) {
    $controllerName = $matchedRoute['controller'];
    $actionName = $matchedRoute['action'];
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        //Capturar los parametros que llegan por URL
        $parameters = array_slice($matches, 1);
        $controller = new $controllerName();
        // Se llama al metodo del controller correspondiente
        $controller->$actionName(...$parameters);
        exit;
    } else {
        http_response_code(404);
        echo "La accion y/o controlador no existen en la aplicacion ";
    }
} else {
    http_response_code(404);
    echo "Error 404. La pagina solicitada no existe";
}
?>