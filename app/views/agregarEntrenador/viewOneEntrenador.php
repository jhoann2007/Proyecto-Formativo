<div class="container">
    <h2 class="mb-4">Detalles del Entrenador</h2>
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nombre; ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> <?php echo $id; ?></p>
                    <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
                    <p><strong>Tipo Documento:</strong> <?php echo $tipoDocumento; ?></p>
                    <p><strong>Documento:</strong> <?php echo $documento; ?></p>
                    <p><strong>Fecha Nacimiento:</strong> <?php echo $fechaNacimiento; ?></p>
                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                    <p><strong>Género:</strong> <?php echo $genero; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Estado:</strong> <?php echo $estado; ?></p>
                    <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
                    <p><strong>EPS:</strong> <?php echo $eps; ?></p>
                    <p><strong>Tipo Sangre:</strong> <?php echo $tipoSangre; ?></p>
                    <p><strong>Teléfono Emergencia:</strong> <?php echo $telefonoEmergencia; ?></p>
                    
                    <!-- Mostrar observaciones -->
                    <p><strong>Observaciones:</strong></p>
                    <div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;">
                        <?php
                        // Mostrar observaciones desde la sesión
                        if (isset($_SESSION['observaciones_entrenador'][$id]) && !empty($_SESSION['observaciones_entrenador'][$id])) {
                            foreach ($_SESSION['observaciones_entrenador'][$id] as $obs) {
                                $fecha = isset($obs['fecha']) ? $obs['fecha'] : '';
                                $texto = isset($obs['texto']) ? $obs['texto'] : '';
                                
                                if (!empty($texto)) {
                                    echo "<div class='p-1 mb-1'>";
                                    if (!empty($fecha)) {
                                        echo "<small class='text-muted'>" . date('d/m/Y H:i', strtotime($fecha)) . "</small><br>";
                                    }
                                    echo htmlspecialchars($texto) . "</div>";
                                }
                            }
                        } else if (!empty($observaciones)) {
                            // Intentar mostrar observaciones desde la base de datos
                            $decodedObs = json_decode($observaciones, true);
                            if (is_array($decodedObs)) {
                                foreach ($decodedObs as $obs) {
                                    $fecha = isset($obs['fecha']) ? $obs['fecha'] : '';
                                    $texto = isset($obs['texto']) ? $obs['texto'] : $obs;
                                    
                                    if (!empty($texto)) {
                                        echo "<div class='p-1 mb-1'>";
                                        if (!empty($fecha)) {
                                            echo "<small class='text-muted'>" . date('d/m/Y H:i', strtotime($fecha)) . "</small><br>";
                                        }
                                        echo htmlspecialchars($texto) . "</div>";
                                    }
                                }
                            } else {
                                echo $observaciones;
                            }
                        } else {
                            echo "<p class='text-muted'>No hay observaciones registradas</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="/agregarEntrenador" class="btn btn-secondary">Volver</a>
                <div>
                    <a href="/agregarEntrenador/edit/<?php echo $id; ?>" class="btn btn-primary">Editar</a>
                    <a href="/agregarEntrenador/delete/<?php echo $id; ?>" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
</div>