<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'assets/config/head.php'; ?>
</head>

<body class="index-page calendario-page">
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
    <main class="main">
        <?php include_once $content; ?>
    </main>

    <!-- footer (GLOBAL) -->
    <footer id="footer" class="footer position-relative dark-background">
        <?php include 'assets/config/footer.php'; ?>
        <!-- Asumo que assets/config/footer.php contendrá el HTML de tu footer global -->
    </footer>
    <!-- fin footer -->

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <!-- FullCalendar Locales -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.global.min.js"></script>

    <script src="assets/js/main.js"></script>

<?php
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        if ($basePath === '/') { $basePath = ''; }
    ?>
    <script>
        // Base URL dinámica según ubicación de index.php
        window.BASE_URL = '<?= $basePath ?>';
    </script>
    <!-- Calendario -->
    <script src="<?= $basePath ?>/js/calendario.js"></script>

</body>

</html>