<div class="data-container">
    <form action="/centro/create" method="post">
        <div class="form-group">
            <label for="txtIdTrainingCenter">Id</label>
            <input type="text" value="<?php echo $infoReal->id_group; ?>" name="txtIdTrainingCenter" id="txtIdTrainingCenter" readonly>
        </div>
        <div class="form-group">
            <label for="txtName">Nombre</label>
            <input type="text" value="<?php echo $infoReal->token_number; ?>" name="txtName" id="txtName">
        </div>
        <div class="form-group">
            <button type="submit">Crear</button>
        </div>
    </form>
</div>
</div>