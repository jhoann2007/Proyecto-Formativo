<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>N. Documento</th>
                <th>Email</th>
                <th>Estado</th>
                <th colspan="4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($entrenadores) && is_array($entrenadores) && count($entrenadores) > 0) {
                foreach ($entrenadores as $entrenador) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id = $entrenador->id ?? 0;
                    $nombre = $entrenador->nombre ?? '';
                    $tipoDocumento = $entrenador->tipoDocumento ?? '';
                    $documento = $entrenador->documento ?? '';
                    $fechaNacimiento = $entrenador->fechaNacimiento ?? '';
                    $email = $entrenador->email ?? '';
                    $genero = $entrenador->genero ?? '';
                    $estado = $entrenador->estado ?? '';
                    $telefono = $entrenador->telefono ?? '';
                    $eps = $entrenador->eps ?? '';
                    $tipoSangre = $entrenador->tipoSangre ?? '';
                    $telefonoEmergencia = $entrenador->telefonoEmergencia ?? '';
                    $password = $entrenador->password ?? '';
                    $observaciones = $entrenador->observaciones ?? '';
                    
                    echo "<tr>
                        <td>{$nombre}</td>
                        <td>{$tipoDocumento}</td>
                        <td>{$documento}</td>
                        <td>{$email}</td>
                        <td>{$estado}</td>
                        <td><button class='btn btn-sm btn-observaciones' data-bs-toggle='modal' data-bs-target='#modalObservaciones{$id}'><i class='bi bi-chat-left-text'></i></button></td>
                        <td><button class='btn btn-sm btn-ver' data-bs-toggle='modal' data-bs-target='#modalView{$id}'><i class='bi bi-eye'></i></button></td>
                        <td><button class='btn btn-sm btn-editar' data-bs-toggle='modal' data-bs-target='#modalEdit{$id}'><i class='bi bi-pencil-square'></i></button></td>
                        <td><button class='btn btn-sm btn-eliminar' data-bs-toggle='modal' data-bs-target='#modalDelete{$id}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Observaciones
                    echo "
                    <div class='modal fade' id='modalObservaciones{$id}' tabindex='-1' aria-labelledby='modalObservacionesLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalObservacionesLabel{$id}'>Observaciones - {$nombre}</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <!-- Mostrar observaciones existentes -->
                                    <div class='mb-3'>
                                        <h6>Observaciones:</h6>
                                        <div class='p-2 border rounded mb-3' style='max-height: 200px; overflow-y: auto;'>
                                            ";
                                            // Mostrar observaciones desde la sesión
                                            if (isset($_SESSION['observaciones_entrenador'][$id]) && !empty($_SESSION['observaciones_entrenador'][$id])) {
                                                foreach ($_SESSION['observaciones_entrenador'][$id] as $obs) {
                                                    $fecha = isset($obs['fecha']) ? $obs['fecha'] : '';
                                                    $texto = isset($obs['texto']) ? $obs['texto'] : '';
                                                    
                                                    if (!empty($texto)) {
                                                        echo "<div class='p-2 mb-2 bg-light rounded'>";
                                                        if (!empty($fecha)) {
                                                            echo "<small class='text-muted'>" . date('d/m/Y H:i', strtotime($fecha)) . "</small><br>";
                                                        }
                                                        echo htmlspecialchars($texto) . "</div>";
                                                    }
                                                }
                                            } else {
                                                // Intentar mostrar observaciones desde la base de datos
                                                $observacionesArray = [];
                                                if (!empty($observaciones)) {
                                                    // Intentar decodificar JSON
                                                    $decodedObs = json_decode($observaciones, true);
                                                    if (is_array($decodedObs)) {
                                                        $observacionesArray = $decodedObs;
                                                    } else {
                                                        // Si no es JSON, tratar como texto simple
                                                        $observacionesArray = [['texto' => $observaciones, 'fecha' => date('Y-m-d H:i:s')]];
                                                    }
                                                    
                                                    // Mostrar observaciones
                                                    foreach ($observacionesArray as $obs) {
                                                        $fecha = isset($obs['fecha']) ? $obs['fecha'] : '';
                                                        $texto = isset($obs['texto']) ? $obs['texto'] : $obs;
                                                        
                                                        if (!empty($texto)) {
                                                            echo "<div class='p-2 mb-2 bg-light rounded'>";
                                                            if (!empty($fecha)) {
                                                                echo "<small class='text-muted'>" . date('d/m/Y H:i', strtotime($fecha)) . "</small><br>";
                                                            }
                                                            echo htmlspecialchars($texto) . "</div>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<p class='text-muted'>No hay observaciones registradas</p>";
                                                }
                                            }
                                            echo "
                                        </div>
                                    </div>
                                    
                                    <!-- Formulario para agregar nueva observación -->
                                    <form action='/agregarEntrenador/agregarObservacion' method='post'>
                                        <input type='hidden' name='txtId' value='{$id}'>
                                        <div class='mb-3'>
                                            <label for='nuevaObservacion{$id}' class='form-label'>Agregar nueva observación:</label>
                                            <textarea class='form-control' id='nuevaObservacion{$id}' name='nuevaObservacion' rows='3' required></textarea>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                                            <button type='submit' class='btn btn-primary'>Guardar Observación</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                    
                    // Modal para Ver Entrenador
                    echo "
                    <div class='modal fade' id='modalView{$id}' tabindex='-1' aria-labelledby='modalViewLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id}'>Detalles del Entrenador</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <p><strong>ID:</strong> {$id}</p>
                                            <p><strong>Nombre:</strong> {$nombre}</p>
                                            <p><strong>Tipo Documento:</strong> {$tipoDocumento}</p>
                                            <p><strong>Documento:</strong> {$documento}</p>
                                            <p><strong>Fecha Nacimiento:</strong> {$fechaNacimiento}</p>
                                            <p><strong>Email:</strong> {$email}</p>
                                            <p><strong>Género:</strong> {$genero}</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <p><strong>Estado:</strong> {$estado}</p>
                                            <p><strong>Teléfono:</strong> {$telefono}</p>
                                            <p><strong>EPS:</strong> {$eps}</p>
                                            <p><strong>Tipo Sangre:</strong> {$tipoSangre}</p>
                                            <p><strong>Teléfono Emergencia:</strong> {$telefonoEmergencia}</p>
                                            
                                            <!-- Mostrar observaciones -->
                                            <p><strong>Observaciones:</strong></p>
                                            <div class='p-2 border rounded' style='max-height: 150px; overflow-y: auto;'>";
                                            
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
                                            echo "</div>";
                                            echo "
                                        </div>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                    
                    // Modal para Editar Entrenador
                    echo "
                    <div class='modal fade' id='modalEdit{$id}' tabindex='-1' aria-labelledby='modalEditLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id}'>Editar Entrenador</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/agregarEntrenador/update' method='post'>
                                        <input type='hidden' name='txtId' value='{$id}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtNombre' value='{$nombre}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Documento</label>
                                                <select class='form-select' name='txtTipoDocumento'>
                                                    <option value='CC' ".($tipoDocumento == 'CC' ? 'selected' : '').">Cédula de ciudadanía</option>
                                                    <option value='CE' ".($tipoDocumento == 'CE' ? 'selected' : '').">Cédula de Extranjería</option>
                                                    <option value='TI' ".($tipoDocumento == 'TI' ? 'selected' : '').">Tarjeta de identidad</option>
                                                    <option value='PEP' ".($tipoDocumento == 'PEP' ? 'selected' : '').">Permiso especial de permanencia</option>
                                                    <option value='PPT' ".($tipoDocumento == 'PPT' ? 'selected' : '').">Permiso por Protección Temporal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Documento</label>
                                                <input type='text' class='form-control' name='txtDocumento' value='{$documento}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Fecha Nacimiento</label>
                                                <input type='date' class='form-control' name='txtFechaNacimiento' value='{$fechaNacimiento}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Email</label>
                                                <input type='email' class='form-control' name='txtEmail' value='{$email}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Género</label>
                                                <select class='form-select' name='txtGenero'>
                                                    <option value='M' ".($genero == 'M' ? 'selected' : '').">Masculino</option>
                                                    <option value='F' ".($genero == 'F' ? 'selected' : '').">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <select class='form-select' name='txtEstado'>
                                                    <option value='activo' ".($estado == 'activo' ? 'selected' : '').">Activo</option>
                                                    <option value='inactivo' ".($estado == 'inactivo' ? 'selected' : '').">Inactivo</option>
                                                </select>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Teléfono</label>
                                                <input type='text' class='form-control' name='txtTelefono' value='{$telefono}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>EPS</label>
                                                <input type='text' class='form-control' name='txtEps' value='{$eps}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Sangre</label>
                                                <select class='form-select' name='txtTipoSangre'>
                                                    <option value='A+' ".($tipoSangre == 'A+' ? 'selected' : '').">A+</option>
                                                    <option value='A-' ".($tipoSangre == 'A-' ? 'selected' : '').">A-</option>
                                                    <option value='B+' ".($tipoSangre == 'B+' ? 'selected' : '').">B+</option>
                                                    <option value='B-' ".($tipoSangre == 'B-' ? 'selected' : '').">B-</option>
                                                    <option value='AB+' ".($tipoSangre == 'AB+' ? 'selected' : '').">AB+</option>
                                                    <option value='AB-' ".($tipoSangre == 'AB-' ? 'selected' : '').">AB-</option>
                                                    <option value='O+' ".($tipoSangre == 'O+' ? 'selected' : '').">O+</option>
                                                    <option value='O-' ".($tipoSangre == 'O-' ? 'selected' : '').">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Teléfono Emergencia</label>
                                                <input type='text' class='form-control' name='txtTelefonoEmergencia' value='{$telefonoEmergencia}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Contraseña</label>
                                                <input type='password' class='form-control' name='txtPassword' placeholder='Dejar en blanco para mantener la actual'>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-primary'>Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                    
                    // Modal para Eliminar Entrenador
                    echo "
                    <div class='modal fade' id='modalDelete{$id}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id}'>Eliminar Entrenador</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al entrenador <strong>{$nombre}</strong>?</p>
                                    <form action='/agregarEntrenador/borrar' method='post'>
                                        <input type='hidden' name='txtId' value='{$id}'>
                                        <input type='hidden' name='txtNombre' value='{$nombre}'>
                                        <input type='hidden' name='txtTipoDocumento' value='{$tipoDocumento}'>
                                        <input type='hidden' name='txtDocumento' value='{$documento}'>
                                        <input type='hidden' name='txtFechaNacimiento' value='{$fechaNacimiento}'>
                                        <input type='hidden' name='txtEmail' value='{$email}'>
                                        <input type='hidden' name='txtGenero' value='{$genero}'>
                                        <input type='hidden' name='txtEstado' value='{$estado}'>
                                        <input type='hidden' name='txtTelefono' value='{$telefono}'>
                                        <input type='hidden' name='txtEps' value='{$eps}'>
                                        <input type='hidden' name='txtTipoSangre' value='{$tipoSangre}'>
                                        <input type='hidden' name='txtTelefonoEmergencia' value='{$telefonoEmergencia}'>
                                        <input type='hidden' name='txtPassword' value='{$password}'>
                                        <input type='hidden' name='txtObservaciones' value='{$observaciones}'>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay entrenadores registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Entrenador -->
<div class="modal fade" id="modalEntrenador" tabindex="-1" aria-labelledby="modalEntrenadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEntrenadorLabel">Agregar Entrenador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/agregarEntrenador/create" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtNombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Documento</label>
                            <select class="form-select" name="txtTipoDocumento" required>
                                <option value="">Seleccionar</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="PEP">Permiso especial de permanencia</option>
                                <option value="PPT">Permiso por Protección Temporal</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" name="txtDocumento" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="txtFechaNacimiento" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="txtEmail" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Género</label>
                            <select class="form-select" name="txtGenero" required>
                                <option value="">Seleccionar</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="txtEstado" required>
                                <option value="">Seleccionar</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="txtTelefono" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">EPS</label>
                            <input type="text" class="form-control" name="txtEps">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo Sangre</label>
                            <select class="form-select" name="txtTipoSangre" required>
                                <option value="">Seleccionar Tipo de Sangre</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Teléfono Emergencia</label>
                            <input type="text" class="form-control" name="txtTelefonoEmergencia">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="txtPassword" required>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="txtObservaciones"></textarea>
                        </div>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>