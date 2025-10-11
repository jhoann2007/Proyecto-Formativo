<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- head -->
<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

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
        <div class="container">
            <!-- Agregar Usuario -->
            <div class="filters-container">
                <div class="action-buttons">
                    <button class="btn-primary" id="btnAgregarUsuario">
                        <i class="bi bi-person-fill-add"></i> Agregar Usuario
                    </button>

                    <div class="ficha-filters">
                        <a href="#" class="ficha-filter active" data-ficha="todas">Todos los Roles</a>
                        <?php
                        if (isset($roles) && is_array($roles)) {
                            foreach ($roles as $role) {
                                echo '<a href="#" class="ficha-filter" data-ficha="' . $role->id_role . '" data-ficha-nombre="' . $role->name . '">' . $role->name . '</a>';
                            }
                        }
                        ?>
                        <span id="ficha-seleccionada"></span>
                    </div>
                </div>

                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Buscar usuario...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <!-- footer (GLOBAL) -->
    <footer id="footer" class="footer position-relative dark-background">
        <?php include 'assets/config/footer.php'; ?>
        <!-- Asumo que assets/config/footer.php contendrá el HTML de tu footer global -->
    </footer>
    <!-- fin footer -->

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- Main JS File -->
    <script src="../../../public/js/main.js"></script>

    <!-- Funcionalidad específica de usuario -->
    <script src="/js/user.js"></script>
</body>

</html>