<i class="header-toggle d-xl-none bi bi-list"></i>

<div class="profile-img">
  <img src="/assets/img/gigachad.png" alt="" class="img-fluid rounded-circle">
</div>

<a href="index.html" class="logo d-flex align-items-center justify-content-center">
  <h1 class="sitename">GigaChad</h1>
</a>

<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="/inicio" class="active"><i class="bi bi-house navicon"></i>Inicio</a></li>
    <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
    <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
    <li><a href="/document"><i class="bi bi-list-check navicon"></i>Documentación</a></li>
    <li><a href="/agregarRutina"><i class="bi bi-clipboard-check navicon"></i>Agregar Rutina</a></li>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    // Asegurarse de que 'user_rol_nombre' existe para evitar notices,
    // aunque tu script de login ya lo convierte a minúsculas y establece 'desconocido' por defecto.
    $rolUsuario = $_SESSION['user_rol_nombre'] ?? 'desconocido';

    // Corregido: switch en lugar de witch
    switch ($rolUsuario) {
      case 'admin':
        echo "
                        <li><a href='/agregarAprendiz' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        <li><a href='/agregarEntrenador' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Entrenador</a></li>
                        ";
        break;
      case 'entrenador':
        echo "
                        <li><a href='/agregarAprendiz' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        ";
        break;
        // Opcional: un caso por defecto si quieres manejar roles no esperados
        // default:
        //     // No mostrar nada extra o mostrar un mensaje
        //     break;
    }

    ?>
  </ul>
</nav>