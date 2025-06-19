<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio SenGym</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="">
    <link href="../css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/calendario.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <div class="background-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="/css/reset.css"> -->

    <link rel="stylesheet" href="/css/calendario.css">
</head>
<!-- fin head -->

<body class="index-page">
    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php 
        include 'assets/config/header.php'; 
        ?>
        <!-- Ejemplo de header para que no de error -->
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