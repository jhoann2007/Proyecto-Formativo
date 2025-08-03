<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Gymtech</title>
    <!-- Tus enlaces a CSS y Fonts ... -->
    <link href="/assets/vendor/bootstrap/css/perfil.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/header.css">
    <link href="/assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">
    <div class="background-shapes">
        <!-- ... tus shapes ... -->
    </div>

    <header id="header" class="header dark-background d-flex flex-column">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // El include del header se mantiene
        include 'assets/config/header.php';
        ?>
    </header>

    <main class="main">
        <section id="about" class="about section">
            <div class="container section-title" data-aos="fade-up">
                <h2 class="text-success">Perfil Profesional</h2>
                <p><?php echo htmlspecialchars($user->observations ?? 'Descripción general del usuario.'); ?></p>
            </div>

            <div class="container profile-layout-container" data-aos="fade-up" data-aos-delay="100">

                <div class="profile-left-panel">
                    <div class="user-image-container">
                        <!-- Asumo que tendrás una URL de imagen en la BD en el futuro -->
                        <img src="<?php echo htmlspecialchars($user->picture); ?>" alt="Foto de perfil" class="img-fluid rounded-circle">
                    </div>
                    <div class="user-info-details">
                        <h1 class="sitename"><?php echo htmlspecialchars($user->name); ?></h1>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <!-- Usamos los nombres de columna correctos de la BD -->
                                    <li><i class="bi bi-chevron-right"></i> <strong>Documento:</strong> <span><?php echo htmlspecialchars($user->document); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Tipo Doc:</strong> <span><?php echo htmlspecialchars($user->document_type); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Fecha Nac:</strong> <span><?php echo htmlspecialchars($user->birthdate); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Correo:</strong> <span><?php echo htmlspecialchars($user->email); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Teléfono:</strong> <span><?php echo htmlspecialchars($user->phone); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Teléfono Emerjencia:</strong> <span><?php echo htmlspecialchars($user->emergency_phone); ?></span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <!-- Usamos los campos que trajimos con los JOINs -->
                                    <li><i class="bi bi-chevron-right"></i> <strong>Rol:</strong> <span><?php echo htmlspecialchars(ucfirst($user->role_name)); ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- El resto de tu layout... -->
                <div class="profile-right-panel">
                    <!-- Parte Superior Derecha: Formación y Experiencia -->
                    <div class="profile-right-top">
                        <div class="row"> <!-- Usamos row de Bootstrap para mantener la división interna -->
                            <div class="col-md-6">
                                <h3 class="text-success">Formación</h3>
                                <ul class="list-unstyled">

                                    <?php if (isset($user->center_name)): // Mostrar solo si tiene programa 
                                    ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Centro Formacion:</strong> <span><?php echo htmlspecialchars($user->center_name); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Centro Formacion:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                    <?php if (isset($user->program_name)): // Mostrar solo si tiene programa 
                                    ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Programa:</strong> <span><?php echo htmlspecialchars($user->program_name); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Programa:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                    <?php if (isset($user->group_token)): // Mostrar solo si es aprendiz y tiene ficha 
                                    ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Grupo:</strong> <span><?php echo htmlspecialchars($user->group_token); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Grupo:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">Salud</h3>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-chevron-right"></i> <strong>Genero:</strong> <span><?php echo htmlspecialchars($user->gender); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Tipo Sangre:</strong> <span><?php echo htmlspecialchars($user->blood_type); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Peso:</strong> <span><?php echo htmlspecialchars($user->weight); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Estatura:</strong> <span><?php echo htmlspecialchars($user->stature); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>EPS:</strong> <span><?php echo htmlspecialchars($user->eps); ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Parte Inferior Derecha: Habilidades -->
                    <div class="profile-right-bottom">
                        <h3 class="text-success">Observaciones</h3>
                        <!-- Mantenemos la estructura de Bootstrap para las habilidades si se desea responsive interno -->
                        <ul class="list-unstyled row">
                            <?php if (isset($user->observations)): // Mostrar solo si es aprendiz y tiene ficha 
                                    ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Observaciones:</strong> <span><?php echo htmlspecialchars($user->observations); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Observaciones:</strong> <span>No emitida</span></li>
                                    <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
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