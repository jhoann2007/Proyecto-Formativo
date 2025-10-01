<i class="header-toggle d-xl-none bi bi-list"></i>

<div class="profile-img">
  <img src="assets/img/gigachad.png" alt="" class="img-fluid rounded-circle">
</div>

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
    <li><a href="/inicio" class="active"><i class="bi bi-house navicon"></i>Inicio</a></li>
    <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
    <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
    <li><a href="/agregarAprendiz"><i class="bi bi-person-fill-add"></i>&nbsp;&nbsp;Agregar Aprendiz</a></li>
  </ul>
</nav>