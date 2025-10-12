<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ------------------------------------------

require_once '../app/config/global.php';
require_once '../vendor/autoload.php';
require_once '../app/controllers/homeController.php';
require_once '../app/controllers/perfilController.php';
require_once '../app/controllers/agregarAprendizController.php';
require_once '../app/controllers/agregarEntrenadorController.php';
require_once '../app/controllers/agregarAdminController.php';
require_once '../app/controllers/calendarioController.php';
require_once '../app/controllers/codigoVerificacionController.php';
require_once '../app/controllers/inicioController.php';
require_once '../app/controllers/olvidoContraseniaController.php';
require_once '../app/controllers/ingresoController.php';
require_once '../app/controllers/rutinaController.php';
require_once '../app/controllers/agregarGrupoController.php';
require_once '../app/controllers/agregarCentroController.php';
require_once '../app/controllers/agregarProgramaController.php';
require_once '../app/controllers/agregarRolController.php';
require_once '../app/controllers/ejercicioController.php';
require_once '../app/controllers/agregarUsuarioController.php';



// Acceder a lo que llegue en la URL
$url = $_SERVER["REQUEST_URI"];

// Limpiar la URL quitando parámetros de consulta
$url = parse_url($url, PHP_URL_PATH);

// Normalizar base path cuando la app corre bajo subcarpeta (e.g., /Proyecto-Formativo/public)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
if ($basePath && strpos($url, $basePath) === 0) {
    $url = substr($url, strlen($basePath));
    if ($url === '' || $url === false) {
        $url = '/';
    }
}

// Debug: mostrar la URL que llega
error_log("URL recibida: " . $url);

$routesList = require_once '../app/config/routes.php';

// CORS básico para desarrollo cuando el frontend corre en 8080
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];
    if (preg_match('/^https?:\\/\\/localhost:8080$/', $origin)) {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Vary: Origin');
    }
}

// Responder preflight de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$matchedRoute = null;
foreach ($routesList as $route => $routeConfig) {
    if (preg_match("#^$route$#", $url, $matches)) {
        // Se asigna el Array requerido con el Controller y Action a ejecutar 
        $matchedRoute = $routeConfig;
        error_log("Ruta encontrada: " . $route);
        break;
    }
}

if ($matchedRoute) {
    $controllerName = $matchedRoute['controller'];
    $actionName = $matchedRoute['action'];
    
    // Debug: mostrar información de la ruta
    error_log("Ruta encontrada: " . $url);
    error_log("Controlador: " . $controllerName);
    error_log("Acción: " . $actionName);
    error_log("Clase existe: " . (class_exists($controllerName) ? 'Sí' : 'No'));
    
    if (class_exists($controllerName)) {
        error_log("Método existe: " . (method_exists($controllerName, $actionName) ? 'Sí' : 'No'));
        if (method_exists($controllerName, $actionName)) {
            //Capturar los parametros que llegan por URL
            $parameters = array_slice($matches, 1);
            $controller = new $controllerName();
            // Se llama al metodo del controller correspondiente
            $controller->$actionName(...$parameters);
            exit;
        } else {
            http_response_code(404);
            echo "El método '$actionName' no existe en el controlador '$controllerName'";
        }
    } else {
        http_response_code(404);
        echo "El controlador '$controllerName' no existe";
    }
} else {
    http_response_code(404);
    echo "Error 404. La pagina solicitada no existe";
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
  <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

<body class="index-page">

  <!-- header -->
  <header id="header" class="header dark-background d-flex flex-column">
    <?php include 'assets/config/header.php'; ?>
  </header>
  <!-- fin header -->

  <!-- main -->
  <main class="main ">
    <!-- Hero Section -->
    <section id="hero" class="hero section white-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h2>SenGym</h2>
        <strong>
          <p id="letra">Bienvenido al <span class="typed" data-typed-items=" aplicativo gimnasio SENA"></span><span
              class="typed-cursor typed-cursor--blink" aria-hidden="true"></span><span
              class="typed-cursor typed-cursor--blink" aria-hidden="true"></span></p>
        </strong>
      </div>

    </section><!-- /Hero Section -->


  </main>
  <!-- fin main -->

  <!-- footer -->
  <footer id="footer" class="footer position-relative light-background">
    <?php include 'assets/config/footer.php'; ?>
  </footer>
  <!-- fin footer -->

  <!-- Scroll -->
  <?php include 'assets/config/scroll.php'; ?>
  </a>
  <!-- fin Scroll -->

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <?php include 'assets/config/scripts.php'; ?>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- js calendario -->
  <script src="assets/js/js.js"></script>
</body>

</html>