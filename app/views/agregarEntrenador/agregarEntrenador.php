<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>N. Documento</th>
                <th>Email</th>
                <th>Género</th>
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
                    
                    // Verificar si existen las propiedades o usar valores por defecto
                    $fkidRol = property_exists($entrenador, 'fkIdRol') ? $entrenador->fkIdRol : 
                              (property_exists($entrenador, 'fkidRol') ? $entrenador->fkidRol : '');
                    
                   
                    // Modal para Ver Entrenador
                    echo "
                    <div class='modal fade' id='modalView{$id}' tabindex='-1' aria-labelledby='modalViewLabel{$id}' aria-hidden='true'>
                        <div      <div class='modal-header'>
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
                                            <p><strong>Estado:</strong> {$estado}</p>
                                            <p><strong>Teléfono:</strong> {$telefono}</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <p><strong>EPS:</strong> {$eps}</p>
                                            <p><strong>Tipo Sangre:</strong> {$tipoSangre}</p>
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
                                        <input type='hidden' name='txtTelefonoEmergencia' value='{$telefonoEmerjencia}'>
                                        <input type='hidden' name='txtPassword' value='{$password}'>
                                        <input type='hidden' name='txtObservaciones' value='{$observaciones}'>
                                        <input type='hidden' name='txtFKidRol' value='{$fkidRol}'>
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