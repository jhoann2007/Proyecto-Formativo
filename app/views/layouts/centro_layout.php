<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

<body>

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // El include del header se mantiene
        include 'assets/config/header.php';
        ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container">
            <!-- Agregar centro -->
            <div class="filters-container">
                <div class="action-buttons">
                    <button class="btn-primary" data-modal="#modalAprendiz">
                        <i class="bi bi-plus-circle"></i> Agregar Centro
                    </button>
                </div>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar...">
                <i class="bi bi-search search-icon"></i>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="footer" class="footer position-relative dark-background">
        <?php include 'assets/config/footer.php'; ?>
        <!-- Asumo que assets/config/footer.php contendrá el HTML de tu footer global -->
    </footer>

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- JS Files -->
    <script src="/js/centro.js"></script>
    <script src="/js/user.js"></script>
</body>

</html>