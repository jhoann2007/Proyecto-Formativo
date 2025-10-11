<div class="table-responsive">
    <table class="table-aprendiz">
        <thead class="table-group">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th colspan="3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($centers) && is_array($centers) && count($centers) > 0) {
                foreach ($centers as $center) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id_trainingcenter = $center->id_trainingcenter ?? 0;
                    $name = $center->name ?? '';

                    echo "<tr data-ficha='{$name}'>
                        <td>{$id_trainingcenter}</td>
                        <td>{$name}</td>
                        <td><button class='btn-ver' data-modal='modalView{$id_trainingcenter}'><i class='bi bi-eye'></i></button></td>
                        <td><button class='btn-editar' data-modal='modalEdit{$id_trainingcenter}'><i class='bi bi-pencil-square'></i></button></td>
                        <td><button class='btn-eliminar' data-modal='modalDelete{$id_trainingcenter}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal' id='modalView{$id_trainingcenter}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-titulo'>Detalles del Centro</h5>
                                <button type='button' class='btn-close'>&times;</button>
                            </div>
                            <div class='modal-body'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <p><strong>ID:</strong> {$id_trainingcenter}</p>
                                        <p><strong>Nombre:</strong> {$name}</p>
                                    </div>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn-cancelar'>Cerrar</button>
                            </div>
                        </div>
                    </div>";

                    // Modal para Editar Aprendiz
                    echo "
                    <div class='modal' id='modalEdit{$id_trainingcenter}'>
                        <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id_trainingcenter}'>Editar Centro</h5>
                                    <button type='button' class='btn-close'>&times;</button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/centro/update' method='post'>
                                        <input type='hidden' name='txtIdTrainingCenter' value='{$id_trainingcenter}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtName' value='{$name}'>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                    <button type='button' class='btn-cancelar'>Cancelar</button>
                                    <button type='submit' class='btn-guardar'>Guardar Cambios</button>
                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";

                    // Modal para Eliminar Centro
                    echo "
                    <div class='modal' id='modalDelete{$id_trainingcenter}'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-titulo'>Eliminar Centro</h5>
                                <button type='button' class='btn-close'>&times;</button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al centro: <strong>{$name}</strong>?</p>
                                    <form action='/centro/borrar' method='post'>
                                        <input type='hidden' name='txtIdTrainingCenter' value='{$id_trainingcenter}'>
                                        <input type='hidden' name='txtName' value='{$name}'>
                                        <div class='modal-footer'>
                                    <button type='button' class='btn-cancelar'>Cancelar</button>
                                    <button type='submit' class='btn-eliminar'>Eliminar</button>
                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay Centros registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Centro de Formación -->
<div class="modal" id="modalAprendiz">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-titulo">Agregar Centro</h5>
            <button type="button" class="btn-close">&times;</button>
        </div>
        <div class="modal-body">
            <form action="/centro/create" method="post">
                <div class="row">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="txtName" required>
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