<div class="data-container">
    <form action="/agregarEntrenador/create" method="post">
        <div class="form-group">
            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" id="txtNombre" required>
        </div>
        <div class="form-group">
            <label for="txtTipoDocumento">Tipo Documento</label>
            <select name="txtTipoDocumento" id="txtTipoDocumento" required>
                <option value="">Seleccionar</option>
                <option value="CC">Cédula de ciudadanía</option>
                <option value="TI">Tarjeta de identidad</option>
            </select>
        </div>
        <div class="form-group">
            <label for="txtDocumento">Documento</label>
            <input type="text" name="txtDocumento" id="txtDocumento" required>
        </div>
        <div class="form-group">
            <label for="txtFechaNacimiento">Fecha Nacimiento</label>
            <input type="date" name="txtFechaNacimiento" id="txtFechaNacimiento" required>
        </div>
        <div class="form-group">
            <label for="txtEmail">Email</label>
            <input type="email" name="txtEmail" id="txtEmail" required>
        </div>
        <div class="form-group">
            <label for="txtGenero">Genero</label>
            <select name="txtGenero" id="txtGenero" required>
                <option value="">Seleccionar</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
            </select>
        </div>
        <div class="form-group">
            <label for="txtEstado">Estado</label>
            <input type="text" name="txtEstado" id="txtEstado" required>
        </div>
        <div class="form-group">
            <label for="txtTelefono">Telefono</label>
            <input type="text" name="txtTelefono" id="txtTelefono" required>
        </div>
        <div class="form-group">
            <label for="txtEps">Eps</label>
            <input type="text" name="txtEps" id="txtEps">
        </div>
        <div class="form-group">
            <label for="txtTipoSangre">Tipo Sangre</label>
            <input type="text" name="txtTipoSangre" id="txtTipoSangre" required>
        </div>
        <div class="form-group">
            <label for="txtTelefonoEmergencia">Telefono de Emergencia</label>
            <input type="text" name="txtTelefonoEmergencia" id="txtTelefonoEmergencia">
        </div>
        <div class="form-group">
            <label for="txtPassword">Contraseña</label>
            <input type="password" name="txtPassword" id="txtPassword" required>
        </div>
        <div class="form-group">
            <label for="txtObservaciones">Observaciones</label>
            <textarea name="txtObservaciones" id="txtObservaciones"></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Crear</button>
        </div>
    </form>
</div>