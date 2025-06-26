<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

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
    <link href="assets/vendor/bootstrap/css/aprendiz.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/perfil.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

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

    <meta charset="UTF-8">
    <title>Tabla Aprendices</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/agregarAprendiz.css">
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <div class="profile-img">
            <img src="/img/gigachad.jpg" alt="" class="img-fluid rounded-circle">
        </div>

        <!-- <a href="index.html" class="logo d-flex align-items-center justify-content-center">
            <h1 class="sitename">Fernando</h1>
        </a> -->
        <h1 class="sitename">
            <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario');
            ?>
        </h1>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/inicio"><i class="bi bi-house navicon"></i>Inicio</a></li>
                <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
                <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
                <?php



                // Asegurarse de que 'user_rol_nombre' existe para evitar notices,
                // aunque tu script de login ya lo convierte a minúsculas y establece 'desconocido' por defecto.
                $rolUsuario = $_SESSION['user_rol_nombre'] ?? 'desconocido';

                // Corregido: switch en lugar de witch
                switch ($rolUsuario) {
                    case 'admin':
                        echo "
                        <li><a href='/agregarAprendiz' class=''><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        <li><a href='/agregarEntrenador' class=''><i class='bi bi-person-fill-add'></i>   Agregar Entrenador</a></li>
                        <li><a href='/agregarRutina'><i class='bi bi-clipboard-check navicon'></i>Agregar Rutina</a></li>
                        ";
                        break;
                    case 'entrenador':
                        echo "
                        <li><a href='/agregarAprendiz' class=''><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        ";
                        break;
                        // Opcional: un caso por defecto si quieres manejar roles no esperados
                        // default:
                        //     // No mostrar nada extra o mostrar un mensaje
                        //     break;
                }

                ?>
                <li><a href="/cerrar"><i class=""></i>Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5">
            <!-- Agregar aprendiz -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalAprendiz">
                        Agregar Aprendiz
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownFicha" data-bs-toggle="dropdown" aria-expanded="false">
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

                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Buscar" id="searchInput">
                    <button class="btn btn-secondary"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <div class="container">
            <div class="copyright text-center">
                <p>
                    © <span>Copyright</span>
                    <strong class="px-1 sitename">GymTech SENA</strong>
                    <span>All Rights Reserved</span>
                </p>
            </div>
            <div class="credits text-center">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                Distributed by <a href="https://themewagon.com">ThemeWagon</a>
            </div>
        </div>
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
    <script src="/js/agregarAprendiz.js"></script>
</body>

</html>