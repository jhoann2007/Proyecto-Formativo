<div class="table-responsive">
    <table class="table-aprendiz">
        <thead class="table-group">
            <tr>
                <th>Ficha</th>
                <th>Nombre</th>
                <th>Centro</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($programs) && is_array($programs) && count($programs) > 0) {
                foreach ($programs as $program) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id_trainingprogram = $program->id_trainingprogram ?? '';
                    $token_number = $program->token_number ?? '';
                    $name = $program->name ?? '';

                    $id_trainingcenter = property_exists($program, 'id_trainingcenter') ? $program->id_trainingcenter : (property_exists($program, 'id_trainingcenter') ? $program->id_trainingcenter : '');

                    echo "<tr data-ficha='{$token_number}'>
                        <td>{$token_number}</td>
                        <td>{$name}</td>
                        <td>";
                        
                        if (isset($centers) && is_array($centers)) {
                        foreach ($centers as $center) {
                            if ($center->id_trainingcenter == $id_trainingcenter) {
                                echo "<p>{$center->name}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p>{$id_trainingcenter}</p>";
                    }
                        echo"</td>
                        <td><button class='btn btn-sm btn-ver' data-bs-toggle='modal' data-bs-target='#modalView{$id_trainingprogram}'><i class='bi bi-eye'></i></button></td>
                        <td><button class='btn btn-sm btn-editar' data-bs-toggle='modal' data-bs-target='#modalEdit{$id_trainingprogram}'><i class='bi bi-pencil-square'></i></button></td>
                        <td><button class='btn btn-sm btn-eliminar' data-bs-toggle='modal' data-bs-target='#modalDelete{$id_trainingprogram}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal fade' id='modalView{$id_trainingprogram}' tabindex='-1' aria-labelledby='modalViewLabel{$id_trainingprogram}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id_trainingprogram}'>Detalles del Programa</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <p><strong>ID:</strong> {$id_trainingprogram}</p>
                                            <p><strong>Ficha:</strong> {$token_number}</p>
                                            <p><strong>Nombre:</strong> {$name}</p>";

                    // Mostrar nombre del centro en lugar del ID
                    if (isset($centers) && is_array($centers)) {
                        foreach ($centers as $center) {
                            if ($center->id_trainingcenter == $id_trainingcenter) {
                                echo "<p><strong>Centro:</strong> {$center->name}</p>";
                                break;
                            }
                        }
                    } else {
                        echo "<p><strong>Centro:</strong> {$id_trainingcenter}</p>";
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
                    <div class='modal fade' id='modalEdit{$id_trainingprogram}' tabindex='-1' aria-labelledby='modalEditLabel{$id_trainingprogram}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id_trainingprogram}'>Editar Grupo</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/programa/update' method='post'>
                                        <input type='hidden' name='txtIdTrainingProgram' value='{$id_trainingprogram}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Ficha</label>
                                                <input type='text' class='form-control' name='txtTokenNumber' value='{$token_number}'>
                                            </div>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtName' value='{$name}'>
                                            </div>
                                        </div>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Centro de Formación</label>
                                                <select class='form-control' name='txtIdTrainingCenter'>
                                                    <option value=''>Seleccionar Centro</option>";
                                                    if (isset($centers) && is_array($centers)) {
                                                        foreach ($centers as $center) {
                                                            $selected = ($id_trainingcenter == $center->id) ? 'selected' : '';
                                                            echo "<option value='{$center->id_trainingcenter}' {$selected}>{$center->name}</option>";
                                                        }
                                                    }                               
                                                    echo "
                                                </select>
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
                    <div class='modal fade' id='modalDelete{$id_trainingprogram}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id_trainingprogram}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id_trainingprogram}'>Eliminar Grupo</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al grupo <strong>{$token_number} - {$name}</strong>?</p>
                                    <form action='/programa/borrar' method='post'>
                                        <input type='hidden' name='txtIdTrainingProgram' value='{$id_trainingprogram}'>
                                        <input type='hidden' name='txtTokenNumber' value='{$token_number}'>
                                        <input type='hidden' name='txtName' value='{$name}'>
                                        <input type='hidden' name='txtIdTrainingCenter' value='{$id_trainingcenter}'>
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
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay Programas registrados</td></tr>";
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
                <h5 class="modal-titulo" id="modalAprendizLabel">Agregar Programa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/programa/create" method="post">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ficha</label>
                            <input type="text" class="form-control" name="txtTokenNumber" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtName" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Centros de Formación</label>
                            <select class="form-control" name="txtIdTrainingCenter">
                                <option value="">Seleccionar Centro</option>
                                <?php
                                if (isset($centers) && is_array($centers)) {
                                    foreach ($centers as $center) {
                                        echo "<option value='{$center->id_trainingcenter}'>{$center->name}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
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