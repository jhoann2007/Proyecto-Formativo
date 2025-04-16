<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
    <?php include 'head.php'; ?>
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'header.php'; ?>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <!-- Resume Section -->
        <section id="resume" class="resume section" data-aos="fade-up">

            <!-- Section Title -->
            <div class="container section-title">
                <h2>Calendario</h2>
            </div><!-- End Section Title -->

            <!-- inicio del Calendario -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card col-sm-8 offset-sm-2">
                        <div class="card-header">
                            <h5>Calendario</h5>
                            <div class="row mb-3" id="calendarControls">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary me-2" id="prevMonth">Mes Anterior</button>
                                    <button class="btn btn-primary" id="nextMonth">Mes Siguiente</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="calendarBody">
                            <!-- Aquí se generará el calendario -->
                        </div>
                    </div>
                </div>
            </div>


        </section><!-- /Resume Section -->

    </main>
    <!-- fin main -->

    <!-- footer -->
    <footer id="footer" class="footer position-relative light-background">
        <?php include 'footer.php'; ?>
    </footer>
    <!-- fin footer -->

    <!-- Scroll -->
    <?php include 'scroll.php'; ?>
    </a>
    <!-- fin Scroll -->

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <?php include 'scripts.php'; ?>

    <!-- Main JS File -->
    <script src="/js/main.js"></script>

    <!-- js calendario -->
    <script src="/js/js.js"></script>
</body>

</html>