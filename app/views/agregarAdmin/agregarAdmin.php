<div class="table-responsive">
    <table class="table-admin">
        <thead class="table-group">
            <tr>
                <th>Nombre</th>
                <th>Tipo Documento</th>
                <th>N. Documento</th>
                <th>Email</th>
                <th>Estado</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <tbody class="tbody-admin">
            <?php
            if (isset($admins) && is_array($admins) && count($admins) > 0) {
                foreach ($admins as $admin) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id = $admin->id_user ?? 0;
                    $nombre = $admin->name ?? '';
                    $tipoDocumento = $admin->document_type ?? '';
                    $documento = $admin->document ?? '';
                    $fechaNacimiento = $admin->birthdate ?? '';
                    $email = $admin->email ?? '';
                    $genero = $admin->gender ?? '';
                    $estado = $admin->status ?? '';
                    $telefono = $admin->phone ?? '';
                    $eps = $admin->eps ?? '';
                    $tipoSangre = $admin->blood_type ?? '';
                    $telefonoEmerjencia = $admin->emergency_phone ?? '';
                    $password = $admin->password ?? '';
                    $observaciones = $admin->observations ?? '';
                    

                    $fkidRol = $admin->id_role ?? '';
                    // Verificar si existen las propiedades o usar valores por defecto
                    // $fkidRol = property_exists($admin, 'id_role') ? $admin->id_role : 
                    //           (property_exists($admin, 'id_role') ? $admin->id_role : '');
                    
                    echo "<tr data-ficha='{}'>
                        <td>{$nombre}</td>
                        <td>{$tipoDocumento}</td>
                        <td>{$documento}</td>
                        <td>{$email}</td>
                        <td>{$estado}</td>
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
                                            if (isset($_SESSION['observaciones_admin'][$id]) && !empty($_SESSION['observaciones_admin'][$id])) {
                                                foreach ($_SESSION['observaciones_admin'][$id] as $obs) {
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
                                </div>
                            </div>
                        </div>
                    </div>";
                    
                    // Modal para Ver Admin
                    echo "
                    <div class='modal fade' id='modalView{$id}' tabindex='-1' aria-labelledby='modalViewLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id}'>Detalles del Administrador</h5>
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
                                                    if ($rol->id_role == $fkidRol) {
                                                        echo "<p><strong>Rol:</strong> {$rol->name}</p>";
                                                        break;
                                                    }
                                                }
                                            } else {
                                                echo "<p><strong>Rol:</strong> {$fkidRol}</p>";
                                            }
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
                    
                    // Modal para Editar Admin
                    echo "
                    <div class='modal fade' id='modalEdit{$id}' tabindex='-1' aria-labelledby='modalEditLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id}'>Editar Administrador</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/agregarAdmin/update' method='post'>
                                        <input type='hidden' name='txtId' value='{$id}'>
                                        <!-- Campo oculto para el rol de admin (posición 1) -->
                                        <input type='hidden' name='txtFKidRol' value='" . (isset($roles[0]) ? $roles[0]->id_role : '') . "'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtNombre' value='{$nombre}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Documento</label>
                                                <select class='form-control' name='txtTipoDocumento'>
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
                                                <select class='form-control' name='txtGenero'>
                                                    <option value='M' ".($genero == 'M' ? 'selected' : '').">Masculino</option>
                                                    <option value='F' ".($genero == 'F' ? 'selected' : '').">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <select class='form-control' name='txtEstado'>
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
                                                <select class='form-control' name='txtTipoSangre'>
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
                                                <input type='text' class='form-control' name='txtTelefonoEmergencia' value='{$telefonoEmerjencia}'>
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
                    
                    // Modal para Eliminar Admin
                    echo "
                    <div class='modal fade' id='modalDelete{$id}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id}'>Eliminar Administrador</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al Administrador <strong>{$nombre}</strong>?</p>
                                    <form action='/agregarAdmin/borrar' method='post'>
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
                                        <input type='hidden' name='txtFKidRol' value='{$fkidRol}'>
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
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay Administradores registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Admin -->
<div class="modal fade" id="modalAprendiz" tabindex="-1" aria-labelledby="modalAprendizLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titulo" id="modalAprendizLabel">Agregar Administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/agregarAdmin/create" method="post">
                    <!-- Campo oculto para asignar automáticamente el rol de administrador (posición 1) -->
                    <!-- <input type="hidden" name="txtFKidRol" value="<?php echo isset($roles[0]) ? $roles[0]->id_role : ''; ?>"> -->
                    <!-- ✅ CORREGIDO: Buscar específicamente el rol de administrador -->
                    <?php
                    $adminRoleId = '';
                    if (isset($roles) && is_array($roles)) {
                        foreach ($roles as $rol) {
                            if (strtolower($rol->name) === 'admin' || $rol->id_role == 1) {
                                $adminRoleId = $rol->id_role;
                                break;
                            }
                        }
                    }
                    ?>
                    <input type="hidden" name="txtFKidRol" value="<?php echo $adminRoleId; ?>">
                    
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
                            <label class="form-label">Teléfono Emergencia</label>
                            <input type="text" class="form-control" name="txtTelefonoEmergencia">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="txtPassword" required>
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