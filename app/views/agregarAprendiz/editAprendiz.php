<div class="data-container">
    <form action="/usuario/update" method="post">
        <div class="form-group">
            <label for="txtId">Id</label>
            <input type="text" value="<?php echo $infoReal->id; ?>" name="txtId" id="txtId" readonly>
        </div>
        <div class="form-group">
            <label for="txtNombre">Nombre</label>
            <input type="text" value="<?php echo $infoReal->nombre; ?>" name="txtNombre" id="txtNombre">
        </div>
        <div class="form-group">
            <label for="txtTipoDocumento">Tipo Documento</label>
            <input type="text" value="<?php echo $infoReal->tipoDocumento; ?>" name="txtTipoDocumento" id="txtTipoDocumento">
        </div>
        <div class="form-group">
            <label for="txtDocumento">Documento</label>
            <input type="text" value="<?php echo $infoReal->documento; ?>" name="txtDocumento" id="txtDocumento">
        </div>
        <div class="form-group">
            <label for="txtFechaNacimiento">Fecha Nacimiento</label>
            <input type="date" value="<?php echo $infoReal->fechaNacimiento; ?>" name="txtFechaNacimiento" id="txtFechaNacimiento">
        </div>
        <div class="form-group">
            <label for="txtEmail">Email</label>
            <input type="text" value="<?php echo $infoReal->email; ?>" name="txtEmail" id="txtEmail">
        </div>
        <div class="form-group">
            <label for="txtGenero">Genero</label>
            <input type="text" value="<?php echo $infoReal->genero; ?>" name="txtGenero" id="txtGenero">
        </div>
        <div class="form-group">
            <label for="txtEstado">Estado</label>
            <input type="text" value="<?php echo $infoReal->estado; ?>" name="txtEstado" id="txtEstado">
        </div>
        <div class="form-group">
            <label for="txtTelefono">Telefono</label>
            <input type="text" value="<?php echo $infoReal->telefono; ?>" name="txtTelefono" id="txtTelefono">
        </div>
        <div class="form-group">
            <label for="txtEps">Eps</label>
            <input type="text" value="<?php echo $infoReal->eps; ?>" name="txtEps" id="txtEps">
        </div>
        <div class="form-group">
            <label for="txtTipoSangre">Tipo Sangre</label>
            <input type="text" value="<?php echo $infoReal->tipoSangre; ?>" name="txtTipoSangre" id="txtTipoSangre">
        </div>
        <div class="form-group">
            <label for="txtPeso">Peso</label>
            <input type="text" value="<?php echo $infoReal->peso; ?>" name="txtPeso" id="txtPeso">
        </div>
        <div class="form-group">
            <label for="txtEstatura">Estatura</label>
            <input type="text" value="<?php echo $infoReal->estatura; ?>" name="txtEstatura" id="txtEstatura">
        </div>
        <div class="form-group">
            <label for="txtTelefonoEmergencia">Telefono de Emergencia</label>
            <input type="text" value="<?php echo $infoReal->telefonoEmerjencia; ?>" name="txtTelefonoEmergencia" id="txtTelefonoEmergencia">
        </div>
        <div class="form-group">
            <label for="txtPassword">Contraseña</label>
            <input type="password" value="<?php echo $infoReal->password; ?>" name="txtPassword" id="txtPassword">
        </div>
        <div class="form-group">
            <label for="txtObservaciones">Observaciones</label>
            <input type="text" value="<?php echo $infoReal->observaciones; ?>" name="txtObservaciones" id="txtObservaciones">
        </div>
        <div class="form-group">
            <label for="txtFKidRol">Rol</label>
            <input type="number" value="<?php echo $infoReal->fkidRol; ?>" name="txtFKidRol" id="txtFKidRol">
        </div>
        <div class="form-group">
            <label for="txtFKidGrupo">Grupo</label>
            <input type="number" value="<?php echo $infoReal->fkidGrupo; ?>" name="txtFKidGrupo" id="txtFKidGrupo">
        </div>
        <div class="form-group">
            <label for="txtFKidCentroFormacion">Centro Formacion</label>
            <input type="number" value="<?php echo $infoReal->fkidCentroFormacion; ?>" name="txtFKidCentroFormacion" id="txtFKidCentroFormacion">
        </div>
        <div class="form-group">
            <button type="submit">Editar</button>
        </div>
    </form>
</div>