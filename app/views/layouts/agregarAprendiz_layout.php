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
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5">
            <!-- Agregar aprendiz -->
            <div class="container-general">
                <div class="button-agregarAprendiz">
                    <button class="btn01" data-bs-toggle="modal" data-bs-target="#modalAprendiz">
                        Agregar Aprendiz
                    </button>

                    <div class="dropdown">
                        <button class="btn02" type="button" id="dropdownFicha" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar Ficha
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownFicha">
                            <li><a class="dropdown-item ficha-filter" href="#" data-ficha="todas">Todas las fichas</a></li>
                            <?php
                            if (isset($grupos) && is_array($grupos)) {
                                foreach ($grupos as $grupo) {
                                    echo '<li><a class="dropdown-item ficha-filter" href="#" data-ficha="' . $grupo->id . '" data-ficha-nombre="' . $grupo->ficha . '">' . $grupo->ficha . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
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

    <!-- footer (GLOBAL) -->
    <footer id="footer" class="footer position-relative dark-background">
        <?php include 'assets/config/footer.php'; ?>
        <!-- Asumo que assets/config/footer.php contendrá el HTML de tu footer global -->
    </footer>
    <!-- fin footer -->

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
    <script src="/js/agregarAprendiz.js"></script>
</body>

</html>