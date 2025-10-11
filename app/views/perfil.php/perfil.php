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
                        <img src="/assets/img/default-profile.png" alt="Foto de perfil" class="img-fluid rounded-circle">
                    </div>
                    <div class="user-info-details">
                        <p class="fst-italic py-3">
                            Aprendiz con actitud proactiva, habilidades sociales y compromiso con el aprendizaje constante.
                        </p>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <!-- Usamos los nombres de columna correctos de la BD -->
                                    <li><i class="bi bi-chevron-right"></i> <strong>Nombre:</strong> <span><?php echo htmlspecialchars($user->name); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Documento:</strong> <span><?php echo htmlspecialchars($user->document_type . ' ' . $user->document); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Correo:</strong> <span><?php echo htmlspecialchars($user->email); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Teléfono:</strong> <span><?php echo htmlspecialchars($user->phone); ?></span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <!-- Usamos los campos que trajimos con los JOINs -->
                                    <li><i class="bi bi-chevron-right"></i> <strong>Rol:</strong> <span><?php echo htmlspecialchars(ucfirst($user->role_name)); ?></span></li>
                                    
                                    <?php if (isset($user->group_token)): // Mostrar solo si es aprendiz y tiene ficha ?>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Ficha:</strong> <span><?php echo htmlspecialchars($user->group_token); ?></span></li>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($user->program_name)): // Mostrar solo si tiene programa ?>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Programa:</strong> <span><?php echo htmlspecialchars($user->program_name); ?></span></li>
                                    <?php endif; ?>

                                    <li><i class="bi bi-chevron-right"></i> <strong>EPS:</strong> <span><?php echo htmlspecialchars($user->eps); ?></span></li>
                                    <li><i class="bi bi-chevron-right"></i> <strong>Tipo Sangre:</strong> <span><?php echo htmlspecialchars($user->blood_type); ?></span></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- El resto de tu layout... -->
                <div class="profile-right-panel">
                     <!-- ... -->
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>

    <!-- Tus scripts JS -->
</body>
</html>