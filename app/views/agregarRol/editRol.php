<div class="data-container">
    <form action="/rol/update" method="post">
        <div class="form-group">
            <label for="txtIdRole">Id</label>
            <input type="text" value="<?php echo $infoReal->id_group; ?>" name="txtIdRole" id="txtIdRole" readonly>
        </div>
        <div class="form-group">
            <label for="txtName">Nombre</label>
            <input type="text" value="<?php echo $infoReal->token_number; ?>" name="txtName" id="txtName">
        </div>
        <div class="form-group">
            <button type="submit">Editar</button>
        </div>
    </form>
</div>