<div class="container">
    <h2 class="mb-4">Editar Entrenador</h2>
    <form action="/agregarEntrenador/update" method="post">
        <input type="hidden" name="txtId" value="<?php echo $infoReal->id; ?>">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="txtNombre" value="<?php echo $infoReal->nombre; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo Documento</label>
                <select class="form-select" name="txtTipoDocumento" required>
                    <option value="CC" <?php echo ($infoReal->tipoDocumento == 'CC') ? 'selected' : ''; ?>>Cédula de ciudadanía</option>
                    <option value="CE" <?php echo ($infoReal->tipoDocumento == 'CE') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                    <option value="TI" <?php echo ($infoReal->tipoDocumento == 'TI') ? 'selected' : ''; ?>>Tarjeta de identidad</option>
                    <option value="PEP" <?php echo ($infoReal->tipoDocumento == 'PEP') ? 'selected' : ''; ?>>Permiso especial de permanencia</option>
                    <option value="PPT" <?php echo ($infoReal->tipoDocumento == 'PPT') ? 'selected' : ''; ?>>Permiso por Protección Temporal</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Documento</label>
                <input type="text" class="form-control" name="txtDocumento" value="<?php echo $infoReal->documento; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha Nacimiento</label>
                <input type="date" class="form-control" name="txtFechaNacimiento" value="<?php echo $infoReal->fechaNacimiento; ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="txtEmail" value="<?php echo $infoReal->email; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Género</label>
                <select class="form-select" name="txtGenero" required>
                    <option value="M" <?php echo ($infoReal->genero == 'M') ? 'selected' : ''; ?>>Masculino</option>
                    <option value="F" <?php echo ($infoReal->genero == 'F') ? 'selected' : ''; ?>>Femenino</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select class="form-select" name="txtEstado" required>
                    <option value="activo" <?php echo ($infoReal->estado == 'activo') ? 'selected' : ''; ?>>Activo</option>
                    <option value="inactivo" <?php echo ($infoReal->estado == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="txtTelefono" value="<?php echo $infoReal->telefono; ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">EPS</label>
                <input type="text" class="form-control" name="txtEps" value="<?php echo $infoReal->eps; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo Sangre</label>
                <select class="form-select" name="txtTipoSangre" required>
                    <option value="A+" <?php echo ($infoReal->tipoSangre == 'A+') ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo ($infoReal->tipoSangre == 'A-') ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo ($infoReal->tipoSangre == 'B+') ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo ($infoReal->tipoSangre == 'B-') ? 'selected' : ''; ?>>B-</option>
                    <option value="AB+" <?php echo ($infoReal->tipoSangre == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo ($infoReal->tipoSangre == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                    <option value="O+" <?php echo ($infoReal->tipoSangre == 'O+') ? 'selected' : ''; ?>>O+</option>
                    <option value="O-" <?php echo ($infoReal->tipoSangre == 'O-') ? 'selected' : ''; ?>>O-</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Teléfono Emergencia</label>
                <input type="text" class="form-control" name="txtTelefonoEmergencia" value="<?php echo $infoReal->telefonoEmergencia; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="txtPassword" placeholder="Dejar en blanco para mantener la actual">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" name="txtObservaciones"></textarea>
                <small class="text-muted">Deje este campo en blanco si no desea agregar una nueva observación.</small>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="/agregarEntrenador" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>