<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<div class="profile-img">
  <img src="../img/gigachad.png" alt="" class="img-fluid rounded-circle">
  <!-- <img src="<?php echo htmlspecialchars($user->picture); ?>" alt="Foto de perfil" class="img-fluid rounded-circle"> -->
</div>

<h1 class="sitename">
  <?php
  echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuario');
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

    $userRole = $_SESSION['user_role_name'] ?? 'desconocido';

    switch ($userRole) {
      case 'admin':
        echo '
        <li class="dropdown">
          <a href="#" class="dropdown-toggle">
            <i class="bi bi-plus-circle navicon"></i><span>Gestionar</span><i class="bi bi-chevron-down toggle-icon"></i>
          </a>
          <ul>
            <li><a href="/centro"><i class="bi bi-building"></i>Centros</a></li>
            <li><a href="/programa"><i class="bi bi-file-earmark-code"></i>Programas</a></li>
            <li><a href="/grupo"><i class="bi bi-people"></i>Grupos</a></li>
            <li><a href="/rol"><i class="bi bi-person-badge"></i>Roles</a></li>
            <li><a href="/usuario"><i class="bi bi-person-fill-gear"></i>Usuarios</a></li>
          </ul>
        </li>';
        echo "          
                        <li><a href='/controlProgreso'><i class='bi bi-speedometer'></i>Control Progreso</a></li>
                        <li><a href='/ejercicio'><i class='bi bi-clipboard-check navicon'></i>Crear ejercicio</a></li>
                        <li><a href='/agregarRutina'><i class='bi bi-clipboard-check navicon'></i>Agregar Rutina</a></li>
                        ";
        break;
      case 'entrenador':
        echo "
                        <li><a href='/agregarAprendiz' class=''><i class='bi bi-person-fill-add'></i>Agregar Aprendiz</a></li>
                        ";
        break;
    }

    ?>
    <li><a href="/cerrar"><i class="bi bi-box-arrow-right"></i>Cerrar Sesion</a></li>
  </ul>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault(); 

        const parentDropdown = this.closest('.dropdown');

        parentDropdown.classList.toggle('active-dropdown');

        dropdownToggles.forEach(otherToggle => {
          const otherParentDropdown = otherToggle.closest('.dropdown');
          if (otherParentDropdown !== parentDropdown && otherParentDropdown.classList.contains('active-dropdown')) {
            otherParentDropdown.classList.remove('active-dropdown');
          }
        });
      });
    });
  });
</script>