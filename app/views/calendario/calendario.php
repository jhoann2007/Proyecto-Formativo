<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'assets/config/head.php'; ?>
    <link rel="stylesheet" href="/css/calendario.css">
</head>
<body class="index-page">
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>

    <main class="main">
        <section id="resume" class="resume section" data-aos="fade-up">
            <div class="container section-title">
                <h2>Calendario</h2>
            </div>

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
                        <div class="card-body" id="calendarBody"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>

    <?php include 'assets/config/scroll.php'; ?>
    <div id="preloader"></div>
    <?php include 'assets/config/scripts.php'; ?>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/js.js"></script>

    <!-- Modal para registrar evento -->
    <div class="modal fade" id="eventoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Registrar Evento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="formEvento">
            <div class="modal-body">
              <input type="hidden" id="fechaCreacion" name="fechaCreacion">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="mb-3">
                <label for="horasDisponibles" class="form-label">Horas Disponibles</label>
                <input type="text" class="form-control" id="horasDisponibles" name="horasDisponibles">
              </div>
              <div class="mb-3">
                <label for="entrenadoresAsignados" class="form-label">Entrenadores Asignados</label>
                <textarea class="form-control" id="entrenadoresAsignados" name="entrenadoresAsignados"></textarea>
              </div>
              <div class="mb-3">
                <label for="eventos" class="form-label">Eventos</label>
                <textarea class="form-control" id="eventos" name="eventos"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html>