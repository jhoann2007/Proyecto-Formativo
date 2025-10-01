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
            if (isset($roles) && is_array($roles) && count($roles) > 0) {
                foreach ($roles as $role) {
                    // Asegurar que las propiedades existan o usar valores por defecto
                    $id_role = $role->id_role ?? 0;
                    $name = $role->name ?? '';

                    echo "<tr data-ficha='{$name}'>
                        <td>{$id_role}</td>
                        <td>{$name}</td>
                        <td><button class='btn btn-sm btn-ver' data-bs-toggle='modal' data-bs-target='#modalView{$id_role}'><i class='bi bi-eye'></i></button></td>
                        <td><button class='btn btn-sm btn-editar' data-bs-toggle='modal' data-bs-target='#modalEdit{$id_role}'><i class='bi bi-pencil-square'></i></button></td>
                        <td><button class='btn btn-sm btn-eliminar' data-bs-toggle='modal' data-bs-target='#modalDelete{$id_role}'><i class='bi bi-trash'></i></button></td>
                    </tr>";

                    // Modal para Ver Aprendiz
                    echo "
                    <div class='modal fade' id='modalView{$id_role}' tabindex='-1' aria-labelledby='modalViewLabel{$id_role}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalViewLabel{$id_role}'>Detalles del Rol</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <p><strong>ID:</strong> {$id_role}</p>
                                            <p><strong>Nombre:</strong> {$name}</p>
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
                    <div class='modal fade' id='modalEdit{$id_role}' tabindex='-1' aria-labelledby='modalEditLabel{$id_role}' aria-hidden='true'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalEditLabel{$id_role}'>Editar Rol</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <form action='/rol/update' method='post'>
                                        <input type='hidden' name='txtIdRole' value='{$id_role}'>
                                        <div class='row mb-3'>
                                            <div class='col-md-6'>
                                                <label class='form-label'>Nombre</label>
                                                <input type='text' class='form-control' name='txtName' value='{$name}'>
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

                    // Modal para Eliminar Centro
                    echo "
                    <div class='modal fade' id='modalDelete{$id_role}' tabindex='-1' aria-labelledby='modalDeleteLabel{$id_role}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalDeleteLabel{$id_role}'>Eliminar Centro</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Está seguro que desea eliminar al rol: <strong>{$name}</strong>?</p>
                                    <form action='/rol/borrar' method='post'>
                                        <input type='hidden' name='txtIdRole' value='{$id_role}'>
                                        <input type='hidden' name='txtName' value='{$name}'>
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
                echo "<tr class='no-data'><td colspan='9' class='text-center'>No hay Roles registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Centro de Formación -->
<div class="modal fade" id="modalAprendiz" tabindex="-1" aria-labelledby="modalAprendizLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titulo" id="modalAprendizLabel">Agregar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="/rol/create" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="txtName" required>
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