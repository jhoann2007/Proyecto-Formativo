
    <main class="main">
        <!-- Layout con sidebar y contenido principal -->
        <div class="container-fluid">
            <div class="row">

                <!-- Contenido principal del calendario -->
                <div class="col-md-9 col-lg-10 main-content">
                    <div class="content-wrapper">
                        <div class="page-header mb-4">
                            <h2 class="page-title">Calendario del Gimnasio</h2>
                            <p class="page-subtitle">Gestiona los horarios y entrenadores del gimnasio</p>
                        </div>
                        
                        <div class="calendar-container">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>

    <!-- Modal para registrar/editar evento -->
    <div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Registrar Horario del Gimnasio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEvento">
                    <div class="modal-body">
                        <input type="hidden" id="fechaSeleccionada" name="fecha">
                        <input type="hidden" id="eventoId" name="id_calendario">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora_cierre" class="form-label">Hora de Cierre</label>
                                <input type="time" class="form-control" id="hora_cierre" name="hora_cierre" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_encargado" class="form-label">Entrenador Encargado</label>
                                <select class="form-select" id="id_encargado" name="id_encargado" required>
                                    <option value="">Seleccionar entrenador...</option>
                                    <?php if (isset($entrenadores) && is_array($entrenadores)): ?>
                                        <?php foreach ($entrenadores as $entrenador): ?>
                                            <option value="<?= $entrenador['id'] ?>"><?= htmlspecialchars($entrenador['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="capacidad_max" class="form-label">Capacidad Máxima</label>
                                <input type="number" class="form-control" id="capacidad_max" name="capacidad_max" min="1" max="100" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="">Seleccionar estado...</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnEliminar" style="display: none;">Eliminar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar información del evento -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalTitle">Información del Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoContent">
                    <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar">Editar</button>
                </div>
            </div>
        </div>
    </div>
