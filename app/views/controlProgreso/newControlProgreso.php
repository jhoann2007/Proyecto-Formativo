<div class="data-container">
    <form action="/controlProgreso/create" method="post">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Fecha Realización</label>
                <input type="date" class="form-control" name="txtFechaRealizacion" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Peso</label>
                <input type="text" class="form-control" name="txtPeso" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Cintura</label>
                <input type="text" class="form-control" name="txtCintura" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cadera</label>
                <input type="text" class="form-control" name="txtCadera" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Muslo Derecho</label>
                <input type="text" class="form-control" name="txtMusloDerecho" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Muslo Izquierdo</label>
                <input type="text" class="form-control" name="txtMusloIzquierdo" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Brazo Derecho</label>
                <input type="text" class="form-control" name="txtBrazoDerecho" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Brazo Izquierdo</label>
                <input type="text" class="form-control" name="txtBrazoIzquierdo" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Antebrazo Derecho</label>
                <input type="text" class="form-control" name="txtAntebrazoDerecho" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Antebrazo Izquierdo</label>
                <input type="text" class="form-control" name="txtAntebrazoIzquierdo" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Pantorrilla Derecha</label>
                <input type="text" class="form-control" name="txtPantorrillaDerecha" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Pantorrilla Izquierda</label>
                <input type="text" class="form-control" name="txtPantorrillaIzquierda" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Examén Médico</label>
                <input type="text" class="form-control" name="txtExamenMedico" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha examén</label>
                <input type="date" class="form-control" name="txtFechaExamen" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" name="txtObservaciones"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Aprendiz</label>
                <select class="form-control" name="txtFKidUsuario">
                    <option value="">Seleccionar Aprendiz</option>
                    <?php
                    if (isset($aprendices) && is_array($aprendices)) {
                        foreach ($aprendices as $aprendiz) {
                            echo "<option value='{$aprendiz->id}'>{$aprendiz->nombre}</option>";
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