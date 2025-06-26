<div class="data-container">

    <div class="button">
        <a href="/rutina/new" class="add-button">Crear Rutina</a>
    </div>

    <div class="card-grid">
        <?php foreach ($rutinas as $rutina): ?>
            <div class="form-card">
                <div class="card-content">
                    <img src="/public/assets/img/rutina.jpg" alt="<?php echo $rutina->nombre; ?>" class="card-image">
                    <h3 class="card-title"><?php echo $rutina->nombre; ?></h3>
                    <p class="card-description"><?php echo $rutina->calentamiento; ?></p>
                </div>
                <div class="card-footer">
                    <a href="/rutina/verEjercicios/<?php echo $rutina->id; ?>" class="ver-btn">Ver Ejercicios</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
