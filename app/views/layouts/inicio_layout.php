<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'assets/config/head.php'; ?>
</head>

<body class="index-page">

  <!-- header (Sidebar) -->
  <header id="header" class="header dark-background d-flex flex-column">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    // El include del header se mantiene
    include 'assets/config/header.php';
    ?>
  </header>
  <!-- fin header (Sidebar) -->

  <!-- main -->
  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="overlay"></div>
        <div class="content">
          <p class="quote">EL DOLOR ES TEMPORAL, LA SATISFACCIÓN DE LOGRAR TUS METAS ES PARA SIEMPRE</p>
          <h2>GymTech SENA</h2>
          <div class="hero-buttons">
            <form action="/calendario" method="Post">
              <div class="form-group">
                <button type="submit" class="btn01"><span>Ver Calendario</span></button>
              </div>
            </form>

            <form action="/agregarRutina" method="Post">
              <div class="form-group">
                <button type="submit" class="btn02"><span>Iniciar Entrenamiento</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="chart-container">
        <div class="chart-header">
          <span class="arrow">&lt;</span>
          <span class="date">2023 %</span>
          <span class="arrow">&gt;</span>
          <span class="dots">...</span>
        </div>
        <img src="https://mastermetrics.com/wp-content/uploads/2024/05/grafica-de-datos-ES-Capterra-hea.jpg"
          alt="Gráfico de progreso">
      </div>
    </section><!-- /Hero Section -->
  </main>
  <!-- fin main -->

  <!-- footer (GLOBAL) -->
  <footer id="footer" class="footer position-relative dark-background">
    <?php include 'assets/config/footer.php'; ?>
    <!-- Asumo que assets/config/footer.php contendrá el HTML de tu footer global -->
  </footer>
  <!-- fin footer -->

  <!-- Scroll y Preloader -->
  <?php include 'assets/config/scroll.php'; ?>
  <div id="preloader"></div>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/js.js"></script>
</body>

</html>