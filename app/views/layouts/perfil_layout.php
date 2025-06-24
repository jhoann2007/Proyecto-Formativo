<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio SenGym</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="">
    <link href="../css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
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

</head>

<body class="index-page">

    <header id="header" class="header dark-background d-flex flex-column">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        include 'assets/config/header.php';

        if (isset($aprendices) && is_array($aprendices) && count($aprendices) > 0) {
            foreach ($aprendices as $aprendiz) {
                // Asegurar que las propiedades existan o usar valores por defecto
                $id = $aprendiz->id ?? 0;
                $nombre = $aprendiz->nombre ?? '';
                $tipoDocumento = $aprendiz->tipoDocumento ?? '';
                $documento = $aprendiz->documento ?? '';
                $fechaNacimiento = $aprendiz->fechaNacimiento ?? '';
                $email = $aprendiz->email ?? '';
                $genero = $aprendiz->genero ?? '';
                $estado = $aprendiz->estado ?? '';
                $telefono = $aprendiz->telefono ?? '';
                $eps = $aprendiz->eps ?? '';
                $tipoSangre = $aprendiz->tipoSangre ?? '';
                $peso = $aprendiz->peso ?? '';
                $estatura = $aprendiz->estatura ?? '';
                $telefonoEmerjencia = $aprendiz->telefonoEmerjencia ?? '';
                $password = $aprendiz->password ?? '';
                $observaciones = $aprendiz->observaciones ?? '';

                // Verificar si existen las propiedades o usar valores por defecto
                $fkidRol = property_exists($aprendiz, 'fkIdRol') ? $aprendiz->fkIdRol : (property_exists($aprendiz, 'fkidRol') ? $aprendiz->fkidRol : '');
                $fkidGrupo = property_exists($aprendiz, 'fkIdGrupo') ? $aprendiz->fkIdGrupo : (property_exists($aprendiz, 'fkidGrupo') ? $aprendiz->fkidGrupo : '');
                $fkidCentroFormacion = property_exists($aprendiz, 'fkIdCentroFormacion') ? $aprendiz->fkIdCentroFormacion : (property_exists($aprendiz, 'fkidCentroFormacion') ? $aprendiz->fkidCentroFormacion : '');

                $idUsuario = $_SESSION['user_id'] ?? 'desconocido';
                $rolUsuario = $_SESSION['user_rol_nombre'] ?? 'desconocido';
                $nombreUsuario = $_SESSION['user_nombre'] ?? 'desconocido';
                $emailUsuario = $_SESSION['user_email'] ?? 'desconocido';

                // Mostrar nombre del rol en lugar del ID
                if (isset($roles) && is_array($roles)) {
                    foreach ($roles as $rol) {
                        if ($rol->id == $fkidRol) {
                            $rol->nombre;
                            break;
                        }
                    }
                } else {
                    $fkidRol;
                }

                // Mostrar ficha en lugar del ID de grupo
                if (isset($grupos) && is_array($grupos)) {
                    foreach ($grupos as $grupo) {
                        if ($grupo->id == $fkidGrupo) {
                            $grupo->ficha;
                            break;
                        }
                    }
                } else {
                    $fkidGrupo;
                }

                // Mostrar nombre del centro de formación en lugar del ID
                if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                    foreach ($centrosFormacion as $centro) {
                        if ($centro->id == $fkidCentroFormacion) {
                            $centro->nombre;
                            break;
                        }
                    }
                } else {
                    $fkidCentroFormacion;
                }
                
            }
        }
        ?>
        <!-- Ejemplo de header para que no de error -->
    </header>

    <main class="main">
        <section id="about" class="about section">
            <div class="container section-title" data-aos="fade-up">
                <h2 class="text-success">Perfil Profesional</h2>
                <p>Descripción general de un aprendiz enfocado en el desarrollo profesional y personal.</p>
            </div>

            <!-- Contenedor principal para el layout del perfil -->
            <div class="container profile-layout-container" data-aos="fade-up" data-aos-delay="100">

                <!-- Panel Izquierdo: Imagen e Información del Usuario -->
                <div class="profile-left-panel">
                    <div class="user-image-container">
                        <img src="assets/img/gigachad.png" alt="Foto de perfil" class="img-fluid rounded-circle">
                    </div>
                    <div class="user-info-details">
                        <p class="fst-italic py-3">Aprendiz con actitud proactiva, habilidades sociales y compromiso con el aprendizaje constante.</p>
                        <div class="row"> <!-- Bootstrap row para mantener la estructura interna de dos columnas -->
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-chevron-right"></i> <strong>Nombre:</strong> <span><?php echo "$nombreUsuario" ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Documento:</strong> <span><?php echo "$documento" ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Correo:</strong> <span><?php echo "$emailUsuario" ?></span></li>
                                    <?php
                                    if ($rolUsuario == 'aprendiz') {
                                        echo "<li><i class='bi bi-chevron-right'></i> <strong>Ficha:</strong> <span>" . $grupo->ficha . "</span></li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-chevron-right"></i> <strong>Cargo:</strong> <span><?php echo "$rolUsuario" ?></span></li>
                                    <?php
                                    if ($rolUsuario == 'aprendiz') {
                                        echo "<li><i class='bi bi-chevron-right'></i> <strong>Programa:</strong> <span>" . $centro->nombre . "</span></li>";
                                    }
                                    ?>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Contraseña:</strong> <span>******</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Derecho -->
                <div class="profile-right-panel">
                    <!-- Parte Superior Derecha: Formación y Experiencia -->
                    <div class="profile-right-top">
                        <div class="row"> <!-- Usamos row de Bootstrap para mantener la división interna -->
                            <div class="col-md-6">
                                <h3 class="text-success">Formación</h3>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-mortarboard-fill"></i> Título académico</li>
                                    <li><i class="bi bi-globe"></i> Idiomas</li>
                                    <li><i class="bi bi-translate"></i> Cursos complementarios</li>
                                    <li><i class="bi bi-pc-display"></i> Programa técnico o tecnológico</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">Experiencia</h3>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-briefcase-fill"></i> Cargo 1</li>
                                    <li><i class="bi bi-briefcase-fill"></i> Cargo 2</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Parte Inferior Derecha: Habilidades -->
                    <div class="profile-right-bottom">
                        <h3 class="text-success">Habilidades</h3>
                        <!-- Mantenemos la estructura de Bootstrap para las habilidades si se desea responsive interno -->
                        <ul class="list-unstyled row">
                            <li class="col-md-6"><i class="bi bi-check-circle"></i> Habilidad 1</li>
                            <li class="col-md-6"><i class="bi bi-check-circle"></i> Habilidad 2</li>
                            <li class="col-md-6"><i class="bi bi-check-circle"></i> Habilidad 3</li>
                            <li class="col-md-6"><i class="bi bi-check-circle"></i> Habilidad 4</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container text-center mt-5" data-aos="fade-up" data-aos-delay="200">
                <p class="text-muted">Este contenido es editable por el aprendiz para fines académicos y profesionales.</p>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
        <!-- Ejemplo de footer para que no de error -->

    </footer>

    <!-- Scroll -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- fin Scroll -->

    <div id="preloader"></div>

    <!-- Vendor JS Files (asumiendo que están en las rutas correctas) -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="../../../public/js/js.js"></script>
    <script src="assets/js/js.js"></script>

    <script>
        // Inicializar AOS (si lo estás usando)
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>

</body>

</html>