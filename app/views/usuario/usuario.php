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
            if (isset($usuarios) && is_array($usuarios) && count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id_user = $usuario->id_user ?? 0;
                    $name = $usuario->name ?? '';
                    $document_type = $usuario->document_type ?? '';
                    $document = $usuario->document ?? '';
                    $birthdate = $usuario->birthdate ?? '';
                    $email = $usuario->email ?? '';
                    $gender = $usuario->gender ?? '';
                    $status = $usuario->status ?? '';
                    $phone = $usuario->phone ?? '';
                    $eps = $usuario->eps ?? '';
                    $blood_type = $usuario->blood_type ?? '';
                    $weight = $usuario->weight ?? '';
                    $stature = $usuario->stature ?? '';
                    $emergency_phone = $usuario->emergency_phone ?? '';
                    $password = $usuario->password ?? '';
                    $observations = $usuario->observations ?? '';

                    // Verificar si existen las propiedades o usar valores por defecto
                    $id_role = property_exists($usuario, 'id_role') ? $usuario->id_role : (property_exists($usuario, 'id_role') ? $usuario->id_role : '');
                    $id_group = property_exists($usuario, 'id_group') ? $usuario->id_group : (property_exists($usuario, 'id_group') ? $usuario->id_group : '');
                    $id_trainingcenter = property_exists($usuario, 'id_trainingcenter') ? $usuario->id_trainingcenter : (property_exists($usuario, 'id_trainingcenter') ? $usuario->id_trainingcenter : '');

                    echo "<tr data-ficha='{$id_group}'>
                        <td class='name'><i class='bi bi-person-fill'></i><span>{$name}</span></td>
                        <td class='data'>{$document_type}</td>
                        <td class='data'>{$document}</td>
                        <td class='data'>{$email}</td>
                        <td class='data'>{$status}</td>
                        <td class='data'><button class='btn-control' data-modal='modalControl{$id_user}'><i class='bi bi-person-fill-add'></i>Control</button></td>
                        <td class='data'><button class='btn-observaciones' data-modal='modalObservaciones{$id_user}'><i class='bi bi-chat-left-text'></i></button></td>
                        <td class='data'><button class='btn-ver' data-modal='modalView{$id_user}'><i class='bi bi-eye'></i></button></td>
                        <td class='data'><button class='btn-editar' data-modal='modalEdit{$id_user}'><i class='bi bi-pencil-square'></i></button></td>
                        <td class='data'><button class='btn-eliminar' data-modal='modalDelete{$id_user}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal' id='modalView{$id_user}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='modalViewLabel{$id_user}'>Detalles del Aprendiz</h5>
                                <button type='button' class='btn-close'>&times;</button>
                            </div>
                                <div class='modal-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <p><strong>ID:</strong> {$id_user}</p>
                                            <p><strong>Nombre:</strong> {$name}</p>
                                            <p><strong>Tipo Documento:</strong> {$document_type}</p>
                                            <p><strong>Documento:</strong> {$document}</p>
                                            <p><strong>Fecha Nacimiento:</strong> {$birthdate}</p>
                                            <p><strong>Email:</strong> {$email}</p>
                                            <p><strong>Género:</strong> {$gender}</p>
                                            <p><strong>Estado:</strong> {$status}</p>
                                            <p><strong>Teléfono:</strong> {$phone}</p>
                                        </div>
                                        <div class='col-md-6'>
                                            <p><strong>EPS:</strong> {$eps}</p>
                                            <p><strong>Tipo Sangre:</strong> {$blood_type}</p>
                                            <p><strong>Peso:</strong> {$weight}</p>
                                            <p><strong>Estatura:</strong> {$stature}</p>
                                            <p><strong>Teléfono Emergencia:</strong> {$emergency_phone}</p>";

                    // Mostrar nombre del rol en lugar del ID
                    if (isset($roles) && is_array($roles)) {
                        foreach ($roles as $rol) {
                            if ($rol->id_role == $id_role) {
                                echo "<p><strong>Rol:</strong> {$rol->name}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Rol:</strong> {$id_role}</p>";
                    }

                    // Mostrar ficha en lugar del ID de grupo
                    if (isset($grupos) && is_array($grupos)) {
                        foreach ($grupos as $grupo) {
                            if ($grupo->id_group == $id_group) {
                                echo "<p><strong>Ficha:</strong> {$grupo->token_number}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Grupo:</strong> {$id_group}</p>";
                    }

                    // Mostrar nombre del centro de formación en lugar del ID
                    if (isset($centrosFormacion) && is_array($centrosFormacion)) {
                        foreach ($centrosFormacion as $centro) {
                            if ($centro->id_trainingcenter == $id_trainingcenter) {
                                echo "<p><strong>Centro Formación:</strong> {$centro->name}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Centro Formación:</strong> {$id_trainingcenter}</p>";
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
                    <div class='modal fade' id='modalEdit{$id_user}' tabindex='-1' aria-labelledby='modalEditLabel{$id_user}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id_user}'>Editar Aprendiz</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/usuario/update' method='post'>
                                        <input type='hidden' name='txtId' value='{$id_user}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtNombre' value='{$name}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Tipo Documento</label>
                                                <select class='form-control' name='txtTipoDocumento'>
                                                    <option value='CC' " . ($document_type == 'CC' ? 'selected' : '') . ">Cédula de ciudadanía</option>
                                                    <option value='CE' " . ($document_type == 'CE' ? 'selected' : '') . ">Cédula de Extranjería</option>
                                                    <option value='TI' " . ($document_type == 'TI' ? 'selected' : '') . ">Tarjeta de identidad</option>
                                                    <option value='PEP' " . ($document_type == 'PEP' ? 'selected' : '') . ">Permiso especial de permanencia</option>
                                                    <option value='PPT' " . ($document_type == 'PPT' ? 'selected' : '') . ">Permiso por Protección Temporal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Documento</label>
                                                <input type='text' class='form-control' name='txtDocumento' value='{$document}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Fecha Nacimiento</label>
                                                <input type='date' class='form-control' name='txtFechaNacimiento' value='{$birthdate}'>
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
                                                    <option value='M' " . ($gender == 'M' ? 'selected' : '') . ">Masculino</option>
                                                    <option value='F' " . ($gender == 'F' ? 'selected' : '') . ">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <select class='form-control' name='txtEstado'>
                                                    <option value='activo' " . ($status == 'activo' ? 'selected' : '') . ">Activo</option>
                                                    <option value='inactivo' " . ($status == 'inactivo' ? 'selected' : '') . ">Inactivo</option>
                                                </select>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Teléfono</label>
                                                <input type='text' class='form-control' name='txtTelefono' value='{$phone}'>
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
                                                    <option value='A+' " . ($blood_type == 'A+' ? 'selected' : '') . ">A+</option>
                                                    <option value='A-' " . ($blood_type == 'A-' ? 'selected' : '') . ">A-</option>
                                                    <option value='B+' " . ($blood_type == 'B+' ? 'selected' : '') . ">B+</option>
                                                    <option value='B-' " . ($blood_type == 'B-' ? 'selected' : '') . ">B-</option>
                                                    <option value='AB+' " . ($blood_type == 'AB+' ? 'selected' : '') . ">AB+</option>
                                                    <option value='AB-' " . ($blood_type == 'AB-' ? 'selected' : '') . ">AB-</option>
                                                    <option value='O+' " . ($blood_type == 'O+' ? 'selected' : '') . ">O+</option>
                                                    <option value='O-' " . ($blood_type == 'O-' ? 'selected' : '') . ">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Peso</label>
                                                <input type='text' class='form-control' name='txtPeso' value='{$weight}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estatura</label>
                                                <input type='text' class='form-control' name='txtEstatura' value='{$stature}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Teléfono Emergencia</label>
                                                <input type='text' class='form-control' name='txtTelefonoEmergencia' value='{$emergency_phone}'>
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
                                            <div class='col-md-6'>
                                                <label class='form-label'>Rol</label>
                                                <select class='form-control' name='txtFKidRol'>
                                                    <option value=''>Seleccionar Rol</option>";
                    if (isset($roles) && is_array($roles)) {
                        foreach ($roles as $role) {
                            $selected = ($id_role == $role->id_role) ? 'selected' : '';
                            echo "<option value='{$role->id_role}' {$selected}>{$role->name}</option>";
                        }
                    }
                    echo "</select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Ficha</label>
                                                <select class='form-control' name='txtFKidGrupo'>
                                                    <option value=''>Seleccionar Ficha</option>";
                    if (isset($grupos) && is_array($grupos)) {
                        foreach ($grupos as $grupo) {
                            $selected = ($id_group == $grupo->id_group) ? 'selected' : '';
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
                            $selected = ($id_trainingcenter == $centro->id_trainingcenter) ? 'selected' : '';
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
                    <div class='modal fade' id='modalDelete{$id_user}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id_user}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id_user}'>Eliminar Aprendiz</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al aprendiz <strong>{$name}</strong>?</p>
                                    <form action='/usuario/borrar' method='post'>
                                        <input type='hidden' name='txtId' value='{$id_user}'>
                                        <input type='hidden' name='txtNombre' value='{$name}'>
                                        <input type='hidden' name='txtTipoDocumento' value='{$document_type}'>
                                        <input type='hidden' name='txtDocumento' value='{$document}'>
                                        <input type='hidden' name='txtFechaNacimiento' value='{$birthdate}'>
                                        <input type='hidden' name='txtEmail' value='{$email}'>
                                        <input type='hidden' name='txtGenero' value='{$gender}'>
                                        <input type='hidden' name='txtEstado' value='{$status}'>
                                        <input type='hidden' name='txtTelefono' value='{$phone}'>
                                        <input type='hidden' name='txtEps' value='{$eps}'>
                                        <input type='hidden' name='txtTipoSangre' value='{$blood_type}'>
                                        <input type='hidden' name='txtPeso' value='{$weight}'>
                                        <input type='hidden' name='txtEstatura' value='{$stature}'>
                                        <input type='hidden' name='txtTelefonoEmergencia' value='{$emergency_phone}'>
                                        <input type='hidden' name='txtPassword' value='{$password}'>
                                        <input type='hidden' name='txtObservaciones' value='{$observations}'>
                                        <input type='hidden' name='txtFKidRol' value='{$id_role}'>
                                        <input type='hidden' name='txtFKidGrupo' value='{$id_group}'>
                                        <input type='hidden' name='txtFKidCentroFormacion' value='{$id_trainingcenter}'>
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
                    <div class='modal fade' id='modalControl{$id_user}' tabindex='-1' aria-labelledby='modalControlLabel{$id_user}' aria-hidden='true'>
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
                <form action="/usuario/create" method="post">
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
                            <!-- <input type="text" class="form-control" name="txtEps"> -->
                            <select class="form-control" name="txtEps" required>
                                <option value="">Seleccionar EPS</option>
                                <option value="Nueva EPS">Nueva EPS</option>
                                <option value="Salud Total EPS">Salud Total EPS</option>
                                <option value="EPS Sura">EPS Sura</option>
                                <option value="EPS Sanitas">EPS Sanitas</option>
                                <option value="Famisanar">Famisanar</option>
                            </select>
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
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select class="form-control" name="txtFKidRol">
                                <option value="">Seleccionar Rol</option>
                                <?php
                                if (isset($roles) && is_array($roles)) {
                                    foreach ($roles as $rol) {
                                        echo "<option value='{$rol->id_role}'>{$rol->name}</option>";
                                    }
                                }
                                ?>
                            </select>
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