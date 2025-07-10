<div class="dashboard-ejercicios">

    <?php foreach ($ejercicios as $ej): ?>
        <div class="ejercicio-card">
            <div class="ejercicio-img">
                <?php if (!empty($ej->video)): ?>
                    <img src="<?= htmlspecialchars($ej->video) ?>" alt="<?= htmlspecialchars($ej->nombre) ?>">
                <?php else: ?>
                    <img src="/assets/img/default-ejercicio.png" alt="Sin imagen">
                <?php endif; ?>
            </div>
            <div class="ejercicio-info">
                <h4><?= htmlspecialchars($ej->nombre) ?></h4>
                <!-- Oculta el grupo muscular por defecto -->
                <p class="grupo-muscular" style="display:none;">
                    Grupo muscular: <?= htmlspecialchars($ej->grupo_muscular ?? 'No definido') ?>
                </p>
                <p>Series: <?= htmlspecialchars($ej->series) ?></p>
                <p>Repeticiones: <?= htmlspecialchars($ej->repeticiones) ?></p>
                <p>Peso: <?= htmlspecialchars($ej->peso) ?> kg</p>
                <input type="hidden" name="ejercicios[<?= $ej->id ?>][peso]" value="<?= $ej->peso ?>">
                <button type="button" class="ver-btn" onclick="mostrarGrupoMuscular(this)">Ver grupo muscular</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="button-back">
    <a href="/rutina" class="btn-back">Volver a Rutinas</a>
</div>
</div>

<style>
    .dashboard-ejercicios {
        margin-left: 300px;
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
        justify-content: flex-start;
        margin-top: 32px;
    }

    .ejercicio-card {
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
        width: 260px;
        padding: 15px 16px 16px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: rgba(25, 25, 46, 0.25) !important;
        /* Fondo semi-transparente */
        backdrop-filter: blur(15px) !important;
        /* Fondo blanco por defecto */
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4) !important;
    }

    .ejercicio-img img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        margin-bottom: 16px;
        border: 2px solid #FFCE40 !important;
        box-shadow: 0 5px 18px rgba(250, 248, 45, 0.4) !important;
    }

    .ejercicio-info h4 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        text-align: center;
    }

    h4{
        color: #FFCE40 !important;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }


    .ejercicio-info p {
        font-size: 0.95rem;
        color: #fff;
        margin-bottom: 6px;
        text-align: center;
    }

    .ver-btn {
        background: #222;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 32px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
        display: block;
        text-align: center;
        margin-top: 10px;
        width: 100%;
    }

    .ver-btn:hover {
        background: #0056b3;
    }

    .ejercicio-item {
        
    }
</style>

<script>
    function mostrarGrupoMuscular(btn) {
        const grupo = btn.parentElement.querySelector('.grupo-muscular');
        if (grupo.style.display === 'none') {
            grupo.style.display = 'block';
            btn.textContent = 'Ocultar grupo muscular';
        } else {
            grupo.style.display = 'none';
            btn.textContent = 'Ver grupo muscular';
        }
    }
</script>