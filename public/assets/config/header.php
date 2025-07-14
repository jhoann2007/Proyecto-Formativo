<i class="header-toggle d-xl-none bi bi-list"></i>

<div class="profile-img">
  <img src="/assets/img/gigachad.png" alt="" class="img-fluid rounded-circle">
</div>

<!-- <a href="/perfil" class="logo d-flex align-items-center justify-content-center">
  <h1 class="sitename">GigaChad</h1>
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
    <li><a href="/inicio" class=""><i class="bi bi-house navicon"></i>Inicio</a></li>
    <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
    <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
      
    <?php
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'assets/config/session_check.php';

    // Asegurarse de que 'user_rol_nombre' existe para evitar notices,
    // aunque tu script de login ya lo convierte a minúsculas y establece 'desconocido' por defecto.
    $rolUsuario = $_SESSION['user_rol_nombre'] ?? 'desconocido';

    // Corregido: switch en lugar de witch
    switch ($rolUsuario) {
      case 'admin':
        echo "          
                        <li><a href='/agregarAdmin' class=''><i class='bi bi-person-fill-add'></i>Agregar Administrador</a></li>
                        <li><a href='/agregarEntrenador' class=''><i class='bi bi-person-fill-add'></i>Agregar Entrenador</a></li>
                        <li><a href='/agregarAprendiz' class=''><i class='bi bi-person-fill-add'></i>Agregar Aprendiz</a></li>
                        <li><a href='/agregarRutina'><i class='bi bi-clipboard-check navicon'></i>Agregar Rutina</a></li>
                        ";
        break;
      case 'entrenador':
        echo "
                        <li><a href='/agregarAprendiz' class=''><i class='bi bi-person-fill-add'></i>Agregar Aprendiz</a></li>
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