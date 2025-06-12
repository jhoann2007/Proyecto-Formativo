<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
    <?php include 'assets/config/head.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/reset.css">

    <link rel="stylesheet" href="/css/calendario.css">
</head>
<!-- fin head -->

<body class="index-page">
    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <div class="container">
        <h2 class="text-center mb-4">Calendario de Eventos</h2>


        <div id="calendar"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalLabel" class="modal-title">Información del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Aquí se mostrará la información -->
                </div>
            </div>
        </div>
    </div>
    <!-- fin main -->
    
    <!-- footer -->
    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>
    <!-- fin footer -->

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    </a>
    <!-- fin Scroll -->

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- js calendario -->
    <script src="/js/js.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>