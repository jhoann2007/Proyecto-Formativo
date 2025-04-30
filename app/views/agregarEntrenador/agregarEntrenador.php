<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>N. Documento</th>
                <th>Email</th>
                <th>Género</th>
                <th>Peso</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($aprendices) && is_array($aprendices) && count($aprendices) > 0) {
                foreach ($aprendices as $aprendiz) {
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
                    $peso = $entrenador->peso ?? '';
                    $estatura = $entrenador->estatura ?? '';
                    $telefonoEmergencia = $entrenador->telefonoEmergencia ?? '';
                    $password = $entrenador->password ?? '';
                    $observaciones = $entrenador->observaciones ?? '';
                    
                    // Verificar si existen las propiedades o usar valores por defecto
                    $fkidRol = property_exists($aprendiz, 'fkIdRol') ? $aprendiz->fkIdRol : 
                              (property_exists($aprendiz, 'fkidRol') ? $aprendiz->fkidRol : '');
                    $fkidGrupo = property_exists($aprendiz, 'fkIdGrupo') ? $aprendiz->fkIdGrupo : 
                                (property_exists($aprendiz, 'fkidGrupo') ? $aprendiz->fkidGrupo : '');
                    $fkidCentroFormacion = property_exists($aprendiz, 'fkIdCentroFormacion') ? $aprendiz->fkIdCentroFormacion : 
                                         (property_exists($aprendiz, 'fkidCentroFormacion') ? $aprendiz->fkidCentroFormacion : '');
                    
                    echo "<tr data-ficha='{$fkidGrupo}'>
                        <td>{$nombre}</td>
                        <td>{$tipoDocumento}</td>
                        <td>{$documento}</td>
                        <td>{$email}</td>
                        <td>{$genero}</td>
                        <td>{$peso}</td>
                        <td><button class='btn btn-sm btn-observaciones' data-bs-toggle='modal' data-bs-target='#modalView{$id}'>Observaciones</button></td>
                        <td><button class='btn btn-sm btn-editar' data-bs-toggle='modal' data-bs-target='#modalEdit{$id}'>Editar</button></td>
                        <td><button class='btn btn-sm btn-eliminar' data-bs-toggle='modal' data-bs-target='#modalDelete{$id}'>Eliminar</button></td>
                    </tr>";
                    
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
                                                    if ($rol->id == $fkidRol) {
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
                                            
                                            echo "<p><strong>Observaciones:</strong> {$observaciones}</p>
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
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtNombre' value='{$nombre}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Documento</label>
                                                <select class='form-select' name='txtTipoDocumento'>
                                                    <option value='CC' ".($tipoDocumento == 'CC' ? 'selected' : '').">Cédula de ciudadanía</option>
                                                    <option value='TI' ".($tipoDocumento == 'TI' ? 'selected' : '').">Tarjeta de identidad</option>
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
                                                    <option value='O' ".($genero == 'O' ? 'selected' : '').">Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <input type='text' class='form-control' name='txtEstado' value='{$estado}'>
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
                                                <input type='text' class='form-control' name='txtTipoSangre' value='{$tipoSangre}'>
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
                                                <textarea class='form-control' name='txtObservaciones'>{$observaciones}</textarea>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-4'>
                                                <label class='form-label'>Rol</label>
                                                <select class='form-select' name='txtFKidRol' required>
                                                    <option value=''>Seleccionar Rol</option>";
                                                    if (isset($roles) && is_array($roles)) {
                                                        foreach ($roles as $rol) {
                                                            $selected = ($fkidRol == $rol->id) ? 'selected' : '';
                                                            echo "<option value='{$rol->id}' {$selected}>{$rol->nombre}</option>";
                                                        }
                                                    }
                                                echo "</select>
                                            </div>
                                            <div class='col-md-4'>
                                                <label class='form-label'>Ficha</label>
                                                <select class='form-select' name='txtFKidGrupo'>
                                                    <option value=''>Seleccionar Ficha</option>";
                                                    if (isset($grupos) && is_array($grupos)) {
                                                        foreach ($grupos as $grupo) {
                                                            $selected = ($fkidGrupo == $grupo->id) ? 'selected' : '';
                                                            echo "<option value='{$grupo->id}' {$selected}>{$grupo->ficha}</option>";
                                                        }
                                                    }
                                                echo "</select>
                                            </div>
                                            <div class='col-md-4'>
                                                <label class='form-label'>Centro Formación</label>
                                                <select class='form-select' name='txtFKidCentroFormacion'>
                                                    <option value=''>Seleccionar Centro</option>";
                                                    if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                                                        foreach ($centrosFormacion as $centro) {
                                                            $selected = ($fkidCentroFormacion == $centro->id) ? 'selected' : '';
                                                            echo "<option value='{$centro->id}' {$selected}>{$centro->nombre}</option>";
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
                <h5 class="modal-title" id="modalAprendizLabel">Agregar Aprendiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/agregarAprendiz/create" method="post">
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
                                <option value="TI">Tarjeta de identidad</option>
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
                                <option value="O">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control" name="txtEstado" required>
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
                            <input type="text" class="form-control" name="txtTipoSangre" required>
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
                        <div class="col-md-4">
                            <label class="form-label">Rol</label>
                            <select class="form-select" name="txtFKidRol" required>
                                <option value="">Seleccionar Rol</option>
                                <?php
                                if (isset($roles) && is_array($roles)) {
                                    foreach ($roles as $rol) {
                                        echo "<option value='{$rol->id}'>{$rol->nombre}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ficha</label>
                            <select class="form-select" name="txtFKidGrupo">
                                <option value="">Seleccionar Ficha</option>
                                <?php
                                if (isset($grupos) && is_array($grupos)) {
                                    foreach ($grupos as $grupo) {
                                        echo "<option value='{$grupo->id}'>{$grupo->ficha}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Centro Formación</label>
                            <select class="form-select" name="txtFKidCentroFormacion">
                                <option value="">Seleccionar Centro</option>
                                <?php
                                if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                                    foreach ($centrosFormacion as $centro) {
                                        echo "<option value='{$centro->id}'>{$centro->nombre}</option>";
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