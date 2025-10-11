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
                        <td class='name'><i class='bi bi-house'></i><span>{$token_number}</span></td>
                        <td class='data'>{$name}</td>
                        <td class='data'>";
                        
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
                        <td class='data'><button class='btn-ver' data-modal='#modalView{$id_trainingprogram}'><i class='bi bi-eye'></i></button></td>
                        <td class='data'><button class='btn-editar' data-modal='#modalEdit{$id_trainingprogram}'><i class='bi bi-pencil-square'></i></button></td>
                        <td class='data'><button class='btn-eliminar' data-modal='#modalDelete{$id_trainingprogram}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Programa
                    echo "
                    <div class='modal' id='modalView{$id_trainingprogram}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Detalles del Programa</h5>
                                <button type='button' class='btn-close'>&times;</button>
                            </div>
                            <div class='modal-body'>
                                <div class='row'>
                                    <div class='form-group'>
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
                                <button type='button' class='btn-secondary'>Cerrar</button>
                            </div>
                        </div>
                    </div>";

                    // Modal para Editar Programa
                    echo "
                    <div class='modal' id='modalEdit{$id_trainingprogram}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Editar Programa</h5>
                                <button type='button' class='btn-close'>&times;</button>
                            </div>
                            <div class='modal-body'>
                                <form action='/programa/update' method='post'>
                                    <input type='hidden' name='txtIdTrainingProgram' value='{$id_trainingprogram}'>
                                    <div class='row'>
                                        <div class='form-group'>
                                            <label class='form-label'>Ficha</label>
                                            <input type='text' class='form-control' name='txtTokenNumber' value='{$token_number}'>
                                        </div>
                                        <div class='form-group'>
                                            <label class='form-label'>Nombre</label>
                                            <input type='text' class='form-control' name='txtName' value='{$name}'>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='form-group'>
                                            <label class='form-label'>Centro de Formación</label>
                                            <select class='form-control' name='txtIdTrainingCenter'>
                                                <option value=''>Seleccionar Centro</option>";
                                                if (isset($centers) && is_array($centers)) {
                                                    foreach ($centers as $center) {
                                                        $selected = ($id_trainingcenter == $center->id_trainingcenter) ? 'selected' : '';
                                                        echo "<option value='{$center->id_trainingcenter}' {$selected}>{$center->name}</option>";
                                                    }
                                                }                               
                                                echo "
                                            </select>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn-secondary'>Cancelar</button>
                                        <button type='submit' class='btn-primary'>Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";

                    // Modal para Eliminar Programa
                    echo "
                    <div class='modal' id='modalDelete{$id_trainingprogram}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Eliminar Programa</h5>
                                <button type='button' class='btn-close'>&times;</button>
                            </div>
                            <div class='modal-body'>
                                <p>¿Está seguro que desea eliminar el programa <strong>{$token_number} - {$name}</strong>?</p>
                                <form action='/programa/borrar' method='post'>
                                    <input type='hidden' name='txtIdTrainingProgram' value='{$id_trainingprogram}'>
                                    <input type='hidden' name='txtTokenNumber' value='{$token_number}'>
                                    <input type='hidden' name='txtName' value='{$name}'>
                                    <input type='hidden' name='txtIdTrainingCenter' value='{$id_trainingcenter}'>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn-secondary'>Cancelar</button>
                                        <button type='submit' class='btn-primary'>Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<tr class='no-data'><td colspan='9'>No hay Programas registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Programa -->
<div class="modal" id="modalAprendiz">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-titulo">Agregar Programa</h5>
            <button type="button" class="btn-close">&times;</button>
        </div>
        <div class="modal-body">
            <form action="/programa/create" method="post">
                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Ficha</label>
                        <input type="text" class="form-control" name="txtTokenNumber" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="txtName" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Centro de Formación</label>
                        <select class="form-control" name="txtIdTrainingCenter" required>
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
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>