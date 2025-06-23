<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- head -->

<head>
    <?php 
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'assets/config/session_check.php';
    include 'assets/config/head.php'; 
    ?>

    <meta charset="UTF-8">
    <title>Gestión de Entrenadores</title>
    <link rel="stylesheet" href="/css/agregarEntrenador.css">
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <div class="profile-img">
            <img src="/img/gigachad.jpg" alt="" class="img-fluid rounded-circle">
        </div>

        <a href="index.html" class="logo d-flex align-items-center justify-content-center">
            <h1 class="sitename">Fernando</h1>
        </a>

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
            <!-- Agregar entrenador -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalEntrenador">
                        Agregar Entrenador
                    </button>
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

    <!-- Búsqueda en tabla -->
    <script src="/js/agregarEntrenador.js"></script>
</body>

</html>