<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GymTech SENA - Centros</title>
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
    <link rel="stylesheet" href="/css/vistas-comunes.css">
</head>
<!-- fin head -->

<body>

    <!-- header -->
    <header id="header" class="header">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container">
            <!-- Agregar centro -->
            <div class="filters-container">
                <div class="action-buttons">
                    <button class="btn-control" data-modal="#modalAprendiz">
                        <i class="bi bi-plus-circle"></i> Agregar Centro
                    </button>
                </div>

                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Buscar...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="footer" class="footer">
        <?php include 'assets/config/footer.php'; ?>
    </footer>

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- JS Files -->
    <script src="/js/centro.js"></script>
    <script src="/js/user.js"></script>
</body>

</html>