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
require_once '../app/controllers/agregarEntrenadorController.php';
require_once '../app/controllers/documentController.php';
require_once '../app/controllers/rutinaController.php';




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