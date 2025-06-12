<div class="container">
    <h2 class="mb-4">Eliminar Entrenador</h2>
    <div class="alert alert-danger">
        <p>¿Está seguro que desea eliminar al entrenador <strong><?php echo $infoReal->nombre; ?></strong>?</p>
        <p>Esta acción no se puede deshacer.</p>
    </div>
    <form action="/agregarEntrenador/borrar" method="post">
        <input type="hidden" name="txtId" value="<?php echo $infoReal->id; ?>">
        <input type="hidden" name="txtNombre" value="<?php echo $infoReal->nombre; ?>">
        <input type="hidden" name="txtTipoDocumento" value="<?php echo $infoReal->tipoDocumento; ?>">
        <input type="hidden" name="txtDocumento" value="<?php echo $infoReal->documento; ?>">
        <input type="hidden" name="txtFechaNacimiento" value="<?php echo $infoReal->fechaNacimiento; ?>">
        <input type="hidden" name="txtEmail" value="<?php echo $infoReal->email; ?>">
        <input type="hidden" name="txtGenero" value="<?php echo $infoReal->genero; ?>">
        <input type="hidden" name="txtEstado" value="<?php echo $infoReal->estado; ?>">
        <input type="hidden" name="txtTelefono" value="<?php echo $infoReal->telefono; ?>">
        <input type="hidden" name="txtEps" value="<?php echo $infoReal->eps; ?>">
        <input type="hidden" name="txtTipoSangre" value="<?php echo $infoReal->tipoSangre; ?>">
        <input type="hidden" name="txtTelefonoEmergencia" value="<?php echo $infoReal->telefonoEmergencia; ?>">
        <input type="hidden" name="txtPassword" value="<?php echo $infoReal->password; ?>">
        <input type="hidden" name="txtObservaciones" value="<?php echo $infoReal->observaciones; ?>">
        
        <div class="d-flex justify-content-between">
            <a href="/agregarEntrenador" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
    </form>
</div>