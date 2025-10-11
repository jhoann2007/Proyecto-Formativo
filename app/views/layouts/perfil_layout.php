<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'assets/config/head.php'; ?>
</head>

<body class="index-page">
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
                                    <li><i class="bi bi-credit-card-2-front"></i> <strong>Documento:</strong> <span><?php echo htmlspecialchars($user->document); ?></span></li>
                                    <li><i class="bi bi-cc-square"></i> <strong>Tipo Doc:</strong> <span><?php echo htmlspecialchars($user->document_type); ?></span></li>
                                    <li><i class="bi bi-cake2"></i> <strong>Fecha Nac:</strong> <span><?php echo htmlspecialchars($user->birthdate); ?></span></li>
                                    <li><i class="bi bi-envelope-at"></i> <strong>Correo:</strong> <span><?php echo htmlspecialchars($user->email); ?></span></li>
                                    <li><i class="bi bi-telephone"></i> <strong>Teléfono:</strong> <span><?php echo htmlspecialchars($user->phone); ?></span></li>
                                    <li><i class="bi bi-telephone-plus"></i> <strong>Teléfono Emj:</strong> <span><?php echo htmlspecialchars($user->emergency_phone); ?></span></li>
                                    <li><i class="bi bi-person-badge"></i> <strong>Rol:</strong> <span><?php echo htmlspecialchars(ucfirst($user->role_name)); ?></span></li>
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
                                        <li><i class="bi bi-house"></i> <strong>Centro For:</strong> <span><?php echo htmlspecialchars($user->center_name); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-house"></i> <strong>Centro For:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                    <?php if (isset($user->program_name)): // Mostrar solo si tiene programa 
                                    ?>
                                        <li><i class="bi bi-person-plus"></i> <strong>Programa:</strong> <span><?php echo htmlspecialchars($user->program_name); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-person-plus"></i> <strong>Programa:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                    <?php if (isset($user->group_token)): // Mostrar solo si es aprendiz y tiene ficha 
                                    ?>
                                        <li><i class="bi bi-people-fill"></i> <strong>Grupo:</strong> <span><?php echo htmlspecialchars($user->group_token); ?></span></li>
                                    <?php else: ?>
                                        <li><i class="bi bi-people-fill"></i> <strong>Grupo:</strong> <span>No vinculado</span></li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">Salud</h3>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-gender-ambiguous"></i> <strong>Genero:</strong> <span><?php echo htmlspecialchars($user->gender); ?></span></li>
                                    <li><i class="bi bi-droplet-half"></i> <strong>Tipo Sangre:</strong> <span><?php echo htmlspecialchars($user->blood_type); ?></span></li>
                                    <li><i class="bi bi-apple"></i> <strong>Peso:</strong> <span><?php echo htmlspecialchars($user->weight); ?></span></li>
                                    <li><i class="bi bi-file-arrow-up"></i> <strong>Estatura:</strong> <span><?php echo htmlspecialchars($user->stature); ?></span></li>
                                    <li><i class="bi bi-capsule"></i> <strong>EPS:</strong> <span><?php echo htmlspecialchars($user->eps); ?></span></li>
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
                                <li><i class="bi bi-eye"></i> <strong>Observaciones:</strong> <span><?php echo htmlspecialchars($user->observations); ?></span></li>
                            <?php else: ?>
                                <li><i class="bi bi-eye"></i> <strong>Observaciones:</strong> <span>No emitida</span></li>
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
</body>

</html>