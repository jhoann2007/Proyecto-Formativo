<div class="table-responsive">
    <table class="table-aprendiz">
        <thead class="table-group">
            <tr>
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>N. Documento</th>
                <th>Email</th>
                <th>Estado</th>
                <th colspan="5">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($aprendices) && is_array($aprendices) && count($aprendices) > 0) {
                foreach ($aprendices as $aprendiz) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id = $aprendiz->id_user ?? 0;
                    $nombre = $aprendiz->name ?? '';
                    $tipoDocumento = $aprendiz->document_type ?? '';
                    $documento = $aprendiz->document ?? '';
                    $fechaNacimiento = $aprendiz->birthdate ?? '';
                    $email = $aprendiz->email ?? '';
                    $genero = $aprendiz->gender ?? '';
                    $estado = $aprendiz->status ?? '';
                    $telefono = $aprendiz->phone ?? '';
                    $eps = $aprendiz->eps ?? '';
                    $tipoSangre = $aprendiz->blood_type ?? '';
                    $peso = $aprendiz->weight ?? '';
                    $estatura = $aprendiz->stature ?? '';
                    $telefonoEmerjencia = $aprendiz->emergency_phone ?? '';
                    $password = $aprendiz->password ?? '';
                    $observaciones = $aprendiz->observations ?? '';

                    // Verificar si existen las propiedades o usar valores por defecto
                    $fkidRol = property_exists($aprendiz, 'fkIdRol') ? $aprendiz->fkIdRol : (property_exists($aprendiz, 'fkidRol') ? $aprendiz->fkidRol : '');
                    $fkidGrupo = property_exists($aprendiz, 'fkIdGrupo') ? $aprendiz->fkIdGrupo : (property_exists($aprendiz, 'fkidGrupo') ? $aprendiz->fkidGrupo : '');
                    $fkidCentroFormacion = property_exists($aprendiz, 'fkIdCentroFormacion') ? $aprendiz->fkIdCentroFormacion : (property_exists($aprendiz, 'fkidCentroFormacion') ? $aprendiz->fkidCentroFormacion : '');

                    echo "<tr data-ficha='{$fkidGrupo}'>
                        <td>{$nombre}</td>
                        <td>{$tipoDocumento}</td>
                        <td>{$documento}</td>
                        <td>{$email}</td>
                        <td>{$estado}</td>
                        <td><button class='btn btn-sm btn-control' data-bs-toggle='modal' data-bs-target='#modalControl{$id}'><i class='bi bi-person-fill-add'></i>Control</button></td>
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
                    if (isset($_SESSION['observaciones_aprendiz'][$id]) && !empty($_SESSION['observaciones_aprendiz'][$id])) {
                        foreach ($_SESSION['observaciones_aprendiz'][$id] as $obs) {
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
                                    <form action='/agregarAprendiz/agregarObservacion' method='post'>
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

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal fade' id='modalView{$id}' tabindex='-1' aria-labelledby='modalViewLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id}'>Detalles del Aprendiz</h5>
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
                                            <p><strong>Estado:</strong> {$estado}</p>
                                            <p><strong>Teléfono:</strong> {$telefono}</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <p><strong>EPS:</strong> {$eps}</p>
                                            <p><strong>Tipo Sangre:</strong> {$tipoSangre}</p>
                                            <p><strong>Peso:</strong> {$peso}</p>
                                            <p><strong>Estatura:</strong> {$estatura}</p>
                                            <p><strong>Teléfono Emergencia:</strong> {$telefonoEmerjencia}</p>";

                    // Mostrar nombre del rol en lugar del ID
                    if (isset($roles) && is_array($roles)) {
                        foreach ($roles as $rol) {
                            if ($rol->id_role == $fkidRol) {
                                echo "<p><strong>Rol:</strong> {$rol->nombre}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Rol:</strong> {$fkidRol}</p>";
                    }

                    // Mostrar ficha en lugar del ID de grupo
                    if (isset($grupos) && is_array($grupos)) {
                        foreach ($grupos as $grupo) {
                            if ($grupo->id == $fkidGrupo) {
                                echo "<p><strong>Ficha:</strong> {$grupo->ficha}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Grupo:</strong> {$fkidGrupo}</p>";
                    }

                    // Mostrar nombre del centro de formación en lugar del ID
                    if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                        foreach ($centrosFormacion as $centro) {
                            if ($centro->id == $fkidCentroFormacion) {
                                echo "<p><strong>Centro Formación:</strong> {$centro->nombre}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Centro Formación:</strong> {$fkidCentroFormacion}</p>";
                    }

                    // Mostrar observaciones
                    echo "<p><strong>Observaciones:</strong></p>";
                    echo "<div class='p-2 border rounded' style='max-height: 150px; overflow-y: auto;'>";

                    // Mostrar observaciones desde la sesión
                    if (isset($_SESSION['observaciones_aprendiz'][$id]) && !empty($_SESSION['observaciones_aprendiz'][$id])) {
                        foreach ($_SESSION['observaciones_aprendiz'][$id] as $obs) {
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

                    // Modal para Editar Aprendiz
                    echo "
                    <div class='modal fade' id='modalEdit{$id}' tabindex='-1' aria-labelledby='modalEditLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id}'>Editar Aprendiz</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/agregarAprendiz/update' method='post'>
                                        <input type='hidden' name='txtId' value='{$id}'>
                                        <!-- Campo oculto para el rol de aprendiz (posición 0) -->
                                        <input type='hidden' name='txtFKidRol' value='" . (isset($roles[2]) ? $roles[2]->id_role : '') . "'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtNombre' value='{$nombre}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Documento</label>
                                                <select class='form-control' name='txtTipoDocumento'>
                                                    <option value='CC' " . ($tipoDocumento == 'CC' ? 'selected' : '') . ">Cédula de ciudadanía</option>
                                                    <option value='CE' " . ($tipoDocumento == 'CE' ? 'selected' : '') . ">Cédula de Extranjería</option>
                                                    <option value='TI' " . ($tipoDocumento == 'TI' ? 'selected' : '') . ">Tarjeta de identidad</option>
                                                    <option value='PEP' " . ($tipoDocumento == 'PEP' ? 'selected' : '') . ">Permiso especial de permanencia</option>
                                                    <option value='PPT' " . ($tipoDocumento == 'PPT' ? 'selected' : '') . ">Permiso por Protección Temporal</option>
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
                                                <select class='form-control' name='txtGenero'>
                                                    <option value='M' " . ($genero == 'M' ? 'selected' : '') . ">Masculino</option>
                                                    <option value='F' " . ($genero == 'F' ? 'selected' : '') . ">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <select class='form-control' name='txtEstado'>
                                                    <option value='activo' " . ($estado == 'activo' ? 'selected' : '') . ">Activo</option>
                                                    <option value='inactivo' " . ($estado == 'inactivo' ? 'selected' : '') . ">Inactivo</option>
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
                                                <select class='form-control' name='txtTipoSangre'>
                                                    <option value='A+' " . ($tipoSangre == 'A+' ? 'selected' : '') . ">A+</option>
                                                    <option value='A-' " . ($tipoSangre == 'A-' ? 'selected' : '') . ">A-</option>
                                                    <option value='B+' " . ($tipoSangre == 'B+' ? 'selected' : '') . ">B+</option>
                                                    <option value='B-' " . ($tipoSangre == 'B-' ? 'selected' : '') . ">B-</option>
                                                    <option value='AB+' " . ($tipoSangre == 'AB+' ? 'selected' : '') . ">AB+</option>
                                                    <option value='AB-' " . ($tipoSangre == 'AB-' ? 'selected' : '') . ">AB-</option>
                                                    <option value='O+' " . ($tipoSangre == 'O+' ? 'selected' : '') . ">O+</option>
                                                    <option value='O-' " . ($tipoSangre == 'O-' ? 'selected' : '') . ">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Peso</label>
                                                <input type='text' class='form-control' name='txtPeso' value='{$peso}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estatura</label>
                                                <input type='text' class='form-control' name='txtEstatura' value='{$estatura}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Teléfono Emergencia</label>
                                                <input type='text' class='form-control' name='txtTelefonoEmergencia' value='{$telefonoEmerjencia}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Contraseña</label>
                                                <input type='password' class='form-control' name='txtPassword' placeholder='Dejar en blanco para mantener la actual'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-12'>
                                                <label class='form-label'>Observaciones</label>
                                                <textarea class='form-control' name='txtObservaciones'></textarea>
                                                <small class='text-muted'>Deje este campo en blanco si no desea agregar una nueva observación.</small>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Ficha</label>
                                                <select class='form-control' name='txtFKidGrupo'>
                                                    <option value=''>Seleccionar Ficha</option>";
                    if (isset($grupos) && is_array($grupos)) {
                        foreach ($grupos as $grupo) {
                            $selected = ($fkidGrupo == $grupo->id_group) ? 'selected' : '';
                            echo "<option value='{$grupo->id_group}' {$selected}>{$grupo->token_number}</option>";
                        }
                    }
                    echo "</select>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Centro Formación</label>
                                                <select class='form-control' name='txtFKidCentroFormacion'>
                                                    <option value=''>Seleccionar Centro</option>";
                    if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                        foreach ($centrosFormacion as $centro) {
                            $selected = ($fkidCentroFormacion == $centro->id_trainingcenter) ? 'selected' : '';
                            echo "<option value='{$centro->id_trainingcenter}' {$selected}>{$centro->name}</option>";
                        }
                    }
                    echo "</select>
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

                    // Modal para Eliminar Aprendiz
                    echo "
                    <div class='modal fade' id='modalDelete{$id}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id}'>Eliminar Aprendiz</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al aprendiz <strong>{$nombre}</strong>?</p>
                                    <form action='/agregarAprendiz/borrar' method='post'>
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
                                        <input type='hidden' name='txtPeso' value='{$peso}'>
                                        <input type='hidden' name='txtEstatura' value='{$estatura}'>
                                        <input type='hidden' name='txtTelefonoEmergencia' value='{$telefonoEmerjencia}'>
                                        <input type='hidden' name='txtPassword' value='{$password}'>
                                        <input type='hidden' name='txtObservaciones' value='{$observaciones}'>
                                        <input type='hidden' name='txtFKidRol' value='{$fkidRol}'>
                                        <input type='hidden' name='txtFKidGrupo' value='{$fkidGrupo}'>
                                        <input type='hidden' name='txtFKidCentroFormacion' value='{$fkidCentroFormacion}'>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";

                    echo "
                    <div class='modal fade' id='modalControl{$id}' tabindex='-1' aria-labelledby='modalControlLabel{$id}' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-titulo' id='modalAprendizLabel'>Agregar Control de Progreso</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
            </div>
            <div class='modal-body'>
                <form action='/controlProgreso/create' method='post'>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Fecha Realización</label>
                            <input type='date' class='form-control' name='txtFechaRealizacion' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Peso</label>
                            <input type='text' class='form-control' name='txtPeso' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Cintura</label>
                            <input type='text' class='form-control' name='txtCintura' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Cadera</label>
                            <input type='text' class='form-control' name='txtCadera' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Muslo Derecho</label>
                            <input type='text' class='form-control' name='txtMusloDerecho' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Muslo Izquierdo</label>
                            <input type='text' class='form-control' name='txtMusloIzquierdo' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Brazo Derecho</label>
                            <input type='text' class='form-control' name='txtBrazoDerecho' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Brazo Izquierdo</label>
                            <input type='text' class='form-control' name='txtBrazoIzquierdo' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Antebrazo Derecho</label>
                            <input type='text' class='form-control' name='txtAntebrazoDerecho' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Antebrazo Izquierdo</label>
                            <input type='text' class='form-control' name='txtAntebrazoIzquierdo' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Pantorrilla Derecha</label>
                            <input type='text' class='form-control' name='txtPantorrillaDerecha' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Pantorrilla Izquierda</label>
                            <input type='text' class='form-control' name='txtPantorrillaIzquierda' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <label class='form-label'>Examén Médico</label>
                            <input type='text' class='form-control' name='txtExamenMedico' required>
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label'>Fecha examén</label>
                            <input type='date' class='form-control' name='txtFechaExamen' required>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class='col-md-12'>
                            <label class='form-label'>Observaciones</label>
                            <textarea class='form-control' name='txtObservaciones'></textarea>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-primary'>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    ";
                }
            } else {
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay aprendices registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Aprendiz -->
<div class="modal fade" id="modalAprendiz" tabindex="-1" aria-labelledby="modalAprendizLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titulo" id="modalAprendizLabel">Agregar Aprendiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/agregarAprendiz/create" method="post">
                    <!-- Campo oculto para asignar automáticamente el rol de aprendiz (posición 3) -->
                    <!-- <input type="hidden" name="txtFKidRol" value="<?php echo isset($roles[2]) ? $roles[2]->id : ''; ?>"> -->

                    <?php
                    $aprendizRoleId = '';
                    if (isset($roles) && is_array($roles)) {
                        foreach ($roles as $rol) {
                            if (strtolower($rol->name) === 'aprendiz' || $rol->id_role == 3) {
                                $aprendizRoleId = $rol->id_role;
                                break;
                            }
                        }
                    }
                    ?>
                    <input type="hidden" name="txtFKidRol" value="<?php echo $aprendizRoleId; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtNombre" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Documento</label>
                            <select class="form-control" name="txtTipoDocumento" required>
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
                            <select class="form-control" name="txtGenero" required>
                                <option value="">Seleccionar</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-control" name="txtEstado" required>
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
                            <select class="form-control" name="txtTipoSangre" required>
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
                            <label class="form-label">Peso</label>
                            <input type="text" class="form-control" name="txtPeso" placeholder="kg">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estatura</label>
                            <input type="text" class="form-control" name="txtEstatura" placeholder="cm">
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
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="txtObservaciones"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ficha</label>
                            <select class="form-control" name="txtFKidGrupo">
                                <option value="">Seleccionar Ficha</option>
                                <?php
                                if (isset($grupos) && is_array($grupos)) {
                                    foreach ($grupos as $grupo) {
                                        echo "<option value='{$grupo->id_group}'>{$grupo->token_number}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Centro Formación</label>
                            <select class="form-control" name="txtFKidCentroFormacion">
                                <option value="">Seleccionar Centro</option>
                                <?php
                                if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                                    foreach ($centrosFormacion as $centro) {
                                        echo "<option value='{$centro->id_trainingcenter}'>{$centro->name}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>