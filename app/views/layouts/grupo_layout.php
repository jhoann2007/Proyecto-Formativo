<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'assets/config/head.php'; ?>
</head>

<body class="index-page">

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
        <div class="container mt-5">
            <!-- Agregar aprendiz -->
            <div class="container-general">
                <div>
                    <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modalAprendiz">
                        <i class="bi bi-plus-circle"></i> Agregar Grupo
                    </button>

                    <div id="ficha-seleccionada" class="d-flex align-items-center ms-3 text-muted"></div>
                </div>

                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Buscar usuario...">
                    <i class="bi bi-search search-icon"></i>
                </div>
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

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="../../../public/js/main.js"></script>

    <!-- js calendario -->
    <script src="../../../public/js/js.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Búsqueda en tabla y filtrado por ficha -->
    <script src="/js/grupo.js"></script>
</body>

</html>