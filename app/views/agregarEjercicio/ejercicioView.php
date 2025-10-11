<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Gestión de Ejercicios</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <button type="button" class="btn-ejercicio" onclick="abrirModalEjercicio()">
                            Agregar Nuevo Ejercicio
                        </button>
                        <button type="button" class="btn-grupo" onclick="abrirModalGrupoMuscular()">
                            Agregar Grupo Muscular
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Video/Imagen</th>
                                    <th>Grupo Muscular</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($exercise) && !empty($exercise)) : ?>
                                    <?php foreach ($exercise as $exercise) : ?>
                                        <tr>
                                            <td><?= $exercise->id_exercise ?></td>
                                            <td><?= $exercise->name ?></td>
                                            <td>
                                                <img src="<?= $exercise->example ?>" alt="<?= $exercise->name ?>" class="ejercicio-thumbnail">
                                            </td>
                                            <td>
                                                <?php
                                                foreach ($musclegroup as $grupo) {
                                                    if ($grupo->id_musclegroup == $exercise->id_musclegroup) {
                                                        echo $grupo->name;
                                                        break;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalView<?= $exercise->id_exercise ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay ejercicios registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Ejercicio (estilo nuevo) -->
<div id="modal-ejercicio" class="modal-ejercicios">
    <div class="modal-content">
        <span class="close" onclick="cerrarModalEjercicio()">&times;</span>
        <h3 class="modal-title">Agregar Nuevo Ejercicio</h3>

        <form action="/ejercicio/agregarEjercicio" method="POST" id="form-ejercicio" enctype="multipart/form-data">
            <div class="form-group">
                <label for="txtNombre" class="form-label">Nombre del Ejercicio</label>
                <input type="text" id="txtNombre" name="txtNombre" required class="form-input">
            </div>

            <div class="form-group">
                <label for="fileImagen" class="form-label">Imagen del Ejercicio</label>
                <input type="file" id="fileImagen" name="fileImagen" accept="image/*" required class="form-input">
                <small class="form-help-text">Sube una imagen o GIF que muestre el ejercicio (formatos: jpg, png, gif)</small>
                <div id="image-preview" class="image-preview">
                    <img id="preview" src="" alt="Vista previa" class="preview-img">
                </div>
            </div>

            <div class="form-group last">
                <label for="txtGrupoMuscular" class="form-label">Grupo Muscular</label>
                <select id="txtGrupoMuscular" name="txtGrupoMuscular" required class="form-input">
                    <option value="">Seleccione un grupo muscular</option>
                    <?php foreach ($musclegroup as $grupo) : ?>
                        <option value="<?= $grupo->id_musclegroup ?>" class="option-text"><?= $grupo->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="add-selected-btn">Guardar Ejercicio</button>
        </form>
    </div>
</div>

<!-- Modal para Agregar Grupo Muscular -->
<div id="modal-grupo-muscular" class="modal-ejercicios">
    <div class="modal-content">
        <span class="close" onclick="cerrarModalGrupoMuscular()">&times;</span>
        <h3 class="modal-title">Agregar Nuevo Grupo Muscular</h3>

        <form action="/ejercicio/agregarGrupoMuscular" method="POST" id="form-grupo-muscular" enctype="multipart/form-data">
            <div class="form-group">
                <label for="txtNombreGrupo" class="form-label">Nombre del Grupo Muscular</label>
                <input type="text" id="txtNombreGrupo" name="txtNombreGrupo" required class="form-input">
            </div>

            <div class="form-group">
                <label for="fileImagenGrupo" class="form-label">Imagen del Grupo Muscular</label>
                <input type="file" id="fileImagenGrupo" name="fileImagenGrupo" accept="image/*" required class="form-input">
                <small class="form-help-text">Sube una imagen representativa del grupo muscular (formatos: jpg, png, gif)</small>
                <div id="image-preview-grupo" class="image-preview">
                    <img id="preview-grupo" src="" alt="Vista previa" class="preview-img">
                </div>
            </div>

            <button type="submit" class="add-selected-btn">Guardar Grupo Muscular</button>
        </form>
    </div>
</div>

<!-- Modales para Ver Ejercicios -->
<?php if (isset($exercise) && !empty($exercise)) : ?>
    <?php foreach ($exercise as $exercise) : ?>
        <div class="modal fade" id="modalView<?= $exercise->id_exercise ?>" tabindex="-1" aria-labelledby="modalViewLabel<?= $exercise->id ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bootstrap-modal">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="modalViewLabel<?= $exercise->id_exercise ?>">Detalles del Ejercicio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> <?= $exercise->id_exercise ?></p>
                                <p><strong>Nombre:</strong> <?= $exercise->exercise ?></p>
                                <p><strong>Grupo Muscular:</strong>
                                    <?php
                                    foreach ($musclegroup as $grupo) {
                                        if ($grupo->id == $exercise->musclegroup) {
                                            echo $grupo->exercise;
                                            break;
                                        }
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-6 text-center">
                                <img src="<?= $exercise->example ?>" alt="<?= $exercise->exercise ?>" class="ejercicio-detail-img">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<style>
    /* Estilos para las imágenes en la tabla */
    .ejercicio-thumbnail {
        max-width: 100px;
        max-height: 100px;
    }

    /* Estilos para la imagen detallada */
    .ejercicio-detail-img {
        max-width: 100%;
        max-height: 300px;
    }

    .card-header {
        background: rgba(25, 25, 46, 0.25) !important;
        backdrop-filter: blur(15px) !important;
    }

    .card {
        background: rgba(25, 25, 46, 0.25) !important;
        backdrop-filter: blur(15px) !important;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4) !important;
    }

    .table-responsive {
        background: rgba(25, 25, 46, 0.25) !important;
        backdrop-filter: blur(15px) !important;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4) !important;
    }

    /* Estilos para los modales personalizados */
    .modal-ejercicios {
        position: fixed;
        top: 0;
        left: 0;
        right: 0; 
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 45px;
        display: none;
    }

    .modal-content {
        background: rgba(25, 25, 46, 0.25) !important;
        backdrop-filter: blur(15px) !important;
        border-radius: 16px;
        padding: 25px;
        width: 620px;
        max-width: 90vw;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.12);
        position: relative;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4) !important;
        margin-left: 280px;
    }

    /* Para diferenciar los modales de bootstrap */
    .bootstrap-modal {
        background: white !important;
        backdrop-filter: none !important;
        border: none !important;
        box-shadow: none !important;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
        line-height: 1;
        color: #fff;
    }

    .btn-ejercicio {
        background: #111a22;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
        transition: border 0.2s, box-shadow 0.2s, background 0.2s;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 10px rgba(250, 248, 45, 0.4) !important;
        width: 20%;
        padding: 12px;
        margin-top: 10px;

    }

    .btn-grupo {
        margin-left: 15px;
        background: #111a22;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
        transition: border 0.2s, box-shadow 0.2s, background 0.2s;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 10px rgba(250, 248, 45, 0.4) !important;
        width: 20%;
        padding: 12px;
        margin-top: 10px;
    }

    .add-selected-btn {
        background: #111a22;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
        transition: border 0.2s, box-shadow 0.2s, background 0.2s;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 10px rgba(250, 248, 45, 0.4) !important;
        width: 100%;
        padding: 12px;
        margin-top: 10px;
    }

    /* Estilos para los elementos del formulario */
    .modal-title {
        color: #fff;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group.last {
        margin-bottom: 25px;
    }

    .form-label {
        color: #fff;
        display: block;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        background: rgba(25, 25, 46, 0.25);
        border: 2px solid #FFCE40;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4);
        color: #fff;
    }

    .form-help-text {
        color: #ccc;
        display: block;
        margin-top: 5px;
    }

    .image-preview {
        margin-top: 10px;
        text-align: center;
        display: none;
    }

    .preview-img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
    }

    .option-text {
        color: #222;
    }
    
</style>

<script>
    function abrirModalEjercicio() {
        document.getElementById('modal-ejercicio').style.display = 'flex';
    }

    function cerrarModalEjercicio() {
        document.getElementById('modal-ejercicio').style.display = 'none';
    }

    function abrirModalGrupoMuscular() {
        document.getElementById('modal-grupo-muscular').style.display = 'flex';
    }

    function cerrarModalGrupoMuscular() {
        document.getElementById('modal-grupo-muscular').style.display = 'none';
    }

    // Cerrar los modales si se hace clic fuera del contenido
    window.onclick = function(event) {
        const modalEjercicio = document.getElementById('modal-ejercicio');
        const modalGrupoMuscular = document.getElementById('modal-grupo-muscular');

        if (event.target === modalEjercicio) {
            cerrarModalEjercicio();
        }

        if (event.target === modalGrupoMuscular) {
            cerrarModalGrupoMuscular();
        }
    }

    // Vista previa de la imagen de ejercicio
    document.getElementById('fileImagen').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('image-preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    // Vista previa de la imagen de grupo muscular
    document.getElementById('fileImagenGrupo').addEventListener('change', function(e) {
        const preview = document.getElementById('preview-grupo');
        const imagePreview = document.getElementById('image-preview-grupo');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
</script>
