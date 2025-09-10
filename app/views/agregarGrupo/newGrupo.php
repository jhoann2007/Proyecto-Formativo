<div class="data-container">
    <form action="/grupo/create" method="post">
        <div class="form-group">
            <label for="txtIdGroup">Id</label>
            <input type="text" value="<?php echo $infoReal->id_group; ?>" name="txtIdGroup" id="txtIdGroup" readonly>
        </div>
        <div class="form-group">
            <label for="txtTokenNumber">Ficha</label>
            <input type="text" value="<?php echo $infoReal->token_number; ?>" name="txtTokenNumber" id="txtTokenNumber">
        </div>
        <div class="form-group">
            <label for="txtAprenttices">Cantidad de Aprendices</label>
            <input type="text" value="<?php echo $infoReal->number_aprenttices; ?>" name="txtAprenttices" id="txtAprenttices">
        </div>
        <div class="form-group">
            <label for="txtStatus">Estado</label>
            <input type="text" value="<?php echo $infoReal->status; ?>" name="txtStatus" id="txtStatus">
        </div>
        <div class="form-group">
            <label for="txtStarDate">Inicio Etapa Lectiva</label>
            <input type="date" value="<?php echo $infoReal->star_date; ?>" name="txtStarDate" id="txtStarDate">
        </div>
        <div class="form-group">
            <label for="txtEndDate">Fin Etapa Lectiva</label>
            <input type="date" value="<?php echo $infoReal->end_date; ?>" name="txtEndDate" id="txtEndDate">
        </div>
        <div class="form-group">
            <label for="txtTrainingProgram">Programa de Formación</label>
            <input type="text" value="<?php echo $infoReal->id_trainingprogram; ?>" name="txtTrainingProgram" id="txtTrainingProgram">
        </div>
        <div class="form-group">
            <button type="submit">Crear</button>
        </div>
    </form>
</div>
</div>