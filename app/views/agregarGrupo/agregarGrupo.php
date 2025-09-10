<div class="table-responsive">
    <table class="table-aprendiz">
        <thead class="table-group">
            <tr>
                <th>Ficha</th>
                <th>Número de Aprendices</th>
                <th>Estado</th>
                <th>Inicio Lectivo</th>
                <th>Cierre Lectivo</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($grupos) && is_array($grupos) && count($grupos) > 0) {
                foreach ($grupos as $group) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id_group = $group->id_group ?? '';
                    $token_number = $group->token_number ?? '';
                    $number_aprenttices = $group->number_aprenttices ?? '';
                    $status = $group->status ?? '';
                    $star_date = $group->star_date ?? '';
                    $end_date = $group->end_date ?? '';

                    $id_trainingprogram = property_exists($group, 'id_trainingprogram') ? $group->id_trainingprogram : (property_exists($group, 'id_trainingprogram') ? $group->id_trainingprogram : '');

                    echo "<tr data-ficha='{$token_number}'>
                        <td>{$token_number}</td>
                        <td>{$number_aprenttices}</td>
                        <td>{$status}</td>
                        <td>{$star_date}</td>
                        <td>{$end_date}</td>
                        <td><button class='btn btn-sm btn-ver' data-bs-toggle='modal' data-bs-target='#modalView{$id_group}'><i class='bi bi-eye'></i></button></td>
                        <td><button class='btn btn-sm btn-editar' data-bs-toggle='modal' data-bs-target='#modalEdit{$id_group}'><i class='bi bi-pencil-square'></i></button></td>
                        <td><button class='btn btn-sm btn-eliminar' data-bs-toggle='modal' data-bs-target='#modalDelete{$id_group}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal fade' id='modalView{$id_group}' tabindex='-1' aria-labelledby='modalViewLabel{$id_group}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id_group}'>Detalles del Grupo</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <p><strong>ID:</strong> {$id_group}</p>
                                            <p><strong>Ficha:</strong> {$token_number}</p>
                                            <p><strong>Número de Aprendices:</strong> {$number_aprenttices}</p>
                                            <p><strong>Estado:</strong> {$status}</p>
                                            <p><strong>Fecha Inicio Lectivo:</strong> {$star_date}</p>
                                            <p><strong>Fecha Fin Lectivo:</strong> {$end_date}</p>";

                    // Mostrar nombre del programa en lugar del ID
                    if (isset($programas) && is_array($programas)) {
                        foreach ($programas as $program) {
                            if ($program->id_trainingprogram == $id_trainingprogram) {
                                echo "<p><strong>Programa:</strong> {$program->name}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Programa:</strong> {$id_trainingprogram}</p>";
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

                    // Modal para Editar Aprendiz
                    echo "
                    <div class='modal fade' id='modalEdit{$id_group}' tabindex='-1' aria-labelledby='modalEditLabel{$id_group}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id_group}'>Editar Grupo</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/grupo/update' method='post'>
                                        <input type='hidden' name='txtIdGroup' value='{$id_group}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Ficha</label>
                                                <input type='text' class='form-control' name='txtTokenNumber' value='{$token_number}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Número de Aprendices</label>
                                                <input type='number' class='form-control' name='txtAprenttices' value='{$number_aprenttices}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Estado</label>
                                                <select class='form-control' name='txtStatus'>
                                                    <option value='activo' " . ($status == 'activo' ? 'selected' : '') . ">Activo</option>
                                                    <option value='inactivo' " . ($status == 'inactivo' ? 'selected' : '') . ">Inactivo</option>
                                                </select>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Programa de Formación</label>
                                                <select class='form-control' name='txtTrainingProgram'>
                                                    <option value=''>Seleccionar Programa</option>";
                                                    if (isset($programas) && is_array($programas)) {
                                                        foreach ($programas as $program) {
                                                            $selected = ($id_trainingprogram == $program->id) ? 'selected' : '';
                                                            echo "<option value='{$program->id_trainingprogram}' {$selected}>{$program->token_number}</option>";
                                                        }
                                                    }                               
                                                    echo "
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Fecha de Inicio Lectivo</label>
                                                <input type='date' class='form-control' name='txtStarDate' value='{$star_date}' required>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Fecha de Fin Lectivo</label>
                                                <input type='date' class='form-control' name='txtEndDate' value='{$end_date}' required>
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

                    // Modal para Eliminar Grupo
                    echo "
                    <div class='modal fade' id='modalDelete{$id_group}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id_group}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id_group}'>Eliminar Grupo</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al grupo <strong>{$token_number}</strong>?</p>
                                    <form action='/grupo/borrar' method='post'>
                                        <input type='hidden' name='txtIdGroup' value='{$id_group}'>
                                        <input type='hidden' name='txtTokenNumber' value='{$token_number}'>
                                        <input type='hidden' name='txtAprenttices' value='{$number_aprenttices}'>
                                        <input type='hidden' name='txtStatus' value='{$status}'>
                                        <input type='hidden' name='txtStarDate' value='{$star_date}'>
                                        <input type='hidden' name='txtEndDate' value='{$end_date}'>
                                        <input type='hidden' name='txtTrainingProgram' value='{$id_trainingprogram}'>
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
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay Grupos registrados</td></tr>";
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
                <h5 class="modal-titulo" id="modalAprendizLabel">Agregar Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/grupo/create" method="post">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ficha</label>
                            <input type="text" class="form-control" name="txtTokenNumber" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número de Aprendices</label>
                            <input type="text" class="form-control" name="txtAprenttices" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-control" name="txtStatus" required>
                                <option value="">Seleccionar</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Programa de Formación</label>
                            <select class="form-control" name="txtTrainingProgram">
                                <option value="">Seleccionar Programa</option>
                                <?php
                                if (isset($programas) && is_array($programas)) {
                                    foreach ($programas as $program) {
                                        echo "<option value='{$program->id_trainingprogram}'>{$program->token_number} - {$program->name}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Inicio Lectivo</label>
                            <input type="date" class="form-control" name="txtStarDate" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Fin Lectivo</label>
                            <input type="date" class="form-control" name="txtEndDate" required>
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