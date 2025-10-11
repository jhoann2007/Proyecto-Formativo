<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GymTech SENA - Programas</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/vistas-comunes.css">

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'assets/config/session_check.php';
    ?>
</head>

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5">
            <!-- Agregar aprendiz -->
            <div class="container-general">
                <div class="button-agregarAprendiz">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-modal="modalAprendiz">
                        Agregar Programa
                    </button>

                    <div id="ficha-seleccionada" class="d-flex align-items-center ms-3 text-muted"></div>
                </div>

                <div class="buscar">
                    <input type="text" class="texto-busqueda" placeholder="Buscar" id="searchInput">
                    <button class="lupa"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="../../../public/js/main.js"></script>

    <!-- js calendario -->
    <script src="../../../public/js/js.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Búsqueda en tabla y filtrado por ficha -->
    <script src="/js/user.js"></script>
</body>

</html>