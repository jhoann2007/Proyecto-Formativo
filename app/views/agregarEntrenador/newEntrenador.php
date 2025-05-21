<div class="container">
    <h2 class="mb-4">Agregar Nuevo Entrenador</h2>
    <form action="/agregarEntrenador/create" method="post">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="txtNombre" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo de Documento</label>
                <select class="form-select" name="txtTipoDocumento" required>
                    <option value="">Seleccionar</option>
                    <option value="CC">Cédula de ciudadanía</option>
                    <option value="CE">Cédula de Extranjería</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="PEP">Permiso especial de permanencia</option>
                    <option value="PPT">Permiso por Protección Temporal</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Número de Documento</label>
                <input type="text" class="form-control" name="txtDocumento" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha Nacimiento</label>
                <input type="date" class="form-control" name="txtFechaNacimiento" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="txtEmail" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Género</label>
                <select class="form-select" name="txtGenero" required>
                    <option value="">Seleccionar</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select class="form-select" name="txtEstado" required>
                    <option value="">Seleccionar</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="txtTelefono" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">EPS</label>
                <input type="text" class="form-control" name="txtEps">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo Sangre</label>
                <select class="form-select" name="txtTipoSangre" required>
                    <option value="">Seleccionar Tipo de Sangre</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Teléfono Emergencia</label>
                <input type="text" class="form-control" name="txtTelefonoEmergencia">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="txtPassword" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" name="txtObservaciones"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="/agregarEntrenador" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>