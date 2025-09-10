<div class="data-container">
    <form action="/programa/borrar" method="post">
        <div class="form-group">
            <label for="txtIdGroup">Id</label>
            <input type="text" value="<?php echo $infoReal->id_trainingprogram; ?>" name="txtIdTrainingProgram" id="txtIdTrainingProgram" readonly>
        </div>
        <div class="form-group">
            <label for="txtTokenNumber">Ficha</label>
            <input type="text" value="<?php echo $infoReal->token_number; ?>" name="txtTokenNumber" id="txtTokenNumber">
        </div>
        <div class="form-group">
            <label for="txtAprenttices">Nombre</label>
            <input type="text" value="<?php echo $infoReal->name; ?>" name="txtName" id="txtName">
        </div>
        <div class="form-group">
            <label for="txtTrainingProgram">Centro de formación</label>
            <input type="text" value="<?php echo $infoReal->id_trainingcenter; ?>" name="txtIdTrainingCenter" id="txtIdTrainingCenter">
        </div>
        <div class="form-group">
            <button type="submit">Eliminar</button>
        </div>
    </form>
</div>