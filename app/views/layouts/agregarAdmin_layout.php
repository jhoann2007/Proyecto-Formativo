<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GymTech SENA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="">
  <link href="../css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <!-- Vendor CSS Files -->
     <link href="assets/vendor/bootstrap/css/inicio.css" rel="stylesheet">
     <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
     <link href="assets/vendor/aos/aos.css" rel="stylesheet">
     <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
     <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/aprendiz.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/perfil.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

  <!-- Estilos propios -->
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/agregarAdmin.css">

  <div class="background-shapes">
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
  </div>

  <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'assets/config/session_check.php';
    ?>
</head>
<!-- fin head -->

<body class="index-page">

  <!-- header -->
  <header id="header" class="header dark-background d-flex flex-column">
    <?php include 'assets/config/header.php'; ?>
  </header>
  <!-- fin header -->

  <!-- main -->
  <main class="main">
        <div class="container mt-5">
            <!-- Agregar admin -->
            <div class="container-general">
                <div class="button-agregarAdmin">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalAprendiz">
                        Agregar Administrador
                    </button>
                </div>

                <div class="buscar">
                    <input type="text" class="texto-busqueda" placeholder="Buscar" id="searchInput">
                    <button class="lupa"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>
  <!-- fin main -->

  <!-- footer -->
  <footer id="footer" class="footer position-relative light-background">
    <?php include 'assets/config/footer.php'; ?>
  </footer>
  <!-- fin footer -->

  <!-- Scroll -->
  <?php include 'assets/config/scroll.php'; ?>
  <!-- fin Scroll -->

  <!-- Preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- Vendor JS Files -->
  <?php include 'assets/config/scripts.php'; ?>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Búsqueda en tabla y filtrado por ficha -->
    <script src="/js/agregarAdmin.js"></script>
</body>

</html>
