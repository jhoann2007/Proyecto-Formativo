<div class="data-container">
    <h2>Crear Nueva Rutina</h2>
    <div class="form-container">
        <form action="/rutina/create" method="post" class="create-form">
            <div class="form-group">
                <label for="nombre">Nombre de la Rutina:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej: Aumento de masa muscular">
            </div>

            <div class="form-group">
                <label for="calentamiento">Calentamiento:</label>
                <textarea id="calentamiento" name="calentamiento" placeholder="Describe el calentamiento recomendado"></textarea>
            </div>

            <div class="form-group">
                <button type="button" class="add-exercise-btn" onclick="abrirModalEjercicios()">Agregar ejercicios</button>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">Crear Rutina</button>
                <a href="/agregarRutina" class="cancel-button">Cancelar</a>
            </div>

            <div id="ejercicios-seleccionados"></div>
        </form>
    </div>
</div>

<div id="modal-ejercicios" class="modal-ejercicios" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarModalEjercicios()">&times;</span>
        <input type="text" id="buscador-ejercicio" placeholder="Buscar ejercicio" onkeyup="filtrarEjercicios()">
        <div id="lista-ejercicios" class="lista-ejercicios">
            <?php foreach ($ejercicios as $ej): ?>
                <div class="ejercicio-item" id="ej-item-<?= $ej->id ?>" data-nombre="<?= htmlspecialchars($ej->nombre) ?>" onclick="toggleEjercicio(<?= $ej->id ?>, '<?= htmlspecialchars($ej->nombre) ?>')">
                    <img src="<?= htmlspecialchars($ej->video) ?>" alt="<?= htmlspecialchars($ej->nombre) ?>" class="ejercicio-img-modal">
                    <div>
                        <strong><?= htmlspecialchars($ej->nombre) ?></strong>
                        <div class="grupo-muscular"><?= strtoupper($ej->grupo_muscular ?? '') ?></div>
                    </div>
                    <div class="ejercicio-inputs" id="inputs-<?= $ej->id ?>">
                        <select name="series_<?= $ej->id ?>" class="input-mini"
                            onclick="event.stopPropagation()" onchange="event.stopPropagation()">
                            <option value="">Series</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="repeticiones_<?= $ej->id ?>" class="input-mini"
                            onclick="event.stopPropagation()" onchange="event.stopPropagation()">
                            <option value="">Reps</option>
                            <?php for ($i = 1; $i <= 30; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="number" name="peso_<?= $ej->id ?>" class="input-mini" placeholder="Peso" min="0"
                            onclick="event.stopPropagation()" onchange="event.stopPropagation()">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="add-selected-btn" id="btn-agregar-ejercicios" onclick="agregarSeleccionados()">
            Agregar 0 Ejercicios
        </button>
    </div>
</div>

<style>
    html,
    body {
        overflow-x: hidden;
        width: 100vw;
        max-width: 100vw;
    }

    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 5vh;
        /* Asegúrate de NO tener width fijo aquí */
    }

    .create-form {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
        padding: 32px 32px 24px 32px;
        width: 800px;
        min-width: 400px;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    .ejercicios-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 32px;
    }

    .ejercicio-select-block {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
        padding: 10px 0 10px 8px;
        border-bottom: 1px solid #eee;
    }

    .ejercicio-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .ejercicio-header label {
        font-weight: 600;
        margin: 0;
    }

    .ejercicio-select-block label {
        font-weight: 600;
        margin-left: 4px;
    }

    .ejercicio-select-block input[type="checkbox"] {
        margin-right: 6px;
    }

    .ejercicio-select-block input[type="number"] {
        width: 100%;
        padding: 6px;
        margin-bottom: 4px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    .modal-ejercicios {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 45px;
        padding-left: 0px;
        /* Ajusta el valor a tu gusto */
    }

    .modal-content {
        margin-left: 585px;
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        width: 610px;
        max-width: 90vw;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.12);
        position: relative;
    }

    .close {
        position: absolute;
        top: 32px;           /* Ajusta según el padding-top del buscador */
        right: 32px;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
        line-height: 1;
    }

    #buscador-ejercicio {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .lista-ejercicios {
        max-height: 350px;
        overflow-y: auto;
        margin: 24px 0;
    }

    .ejercicio-item {
        display: flex;
        align-items: center;
        gap: 18px;
        border-radius: 12px;
        background: #fff;
        /* Fondo blanco por defecto */
        padding: 12px 18px;
        margin-bottom: 12px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .ejercicio-img-modal {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .add-exercise-btn,
    .add-selected-btn {
        background: #111a22;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
    }

    .ejercicio-resumen {
        background: #f5f5f5;
        border-radius: 8px;
        padding: 6px 12px;
        margin: 4px 0;
        display: inline-block;
    }

    .seleccionado {
        background-color: #d1e7dd;
    }

    .ejercicio-item.seleccionado {
        border: 2.5px solid #0d6efd;
        /* Borde azul */
        background: #e3f1ff;
        /* Fondo azul solo cuando está seleccionado */
        box-shadow: 0 0 0 2px #b6d8ff;
    }

    .input-mini {
        width: 60px;
        padding: 4px 6px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .grupo-muscular {
        font-size: 0.85rem;
        color: #666;
        margin-top: 4px;
    }

    .ejercicio-inputs {
        display: flex;
        gap: 12px;
        margin-left: auto;
        align-items: center;
    }

    .ejercicio-inputs select,
    .ejercicio-inputs input[type="number"] {
        width: 80px;
        /* Más ancho para ver el texto completo */    
        font-size: 1rem;
        border-radius: 6px;
        border: 1px solid #ccc;
       
    }
</style>

<script>
    let ejerciciosSeleccionados = {};

    function abrirModalEjercicios() {
        document.getElementById('modal-ejercicios').style.display = 'block';
        actualizarBotonContador();
    }

    function cerrarModalEjercicios() {
        document.getElementById('modal-ejercicios').style.display = 'none';
    }

    function toggleEjercicio(id, nombre) {
        const item = document.getElementById('ej-item-' + id);
        if (ejerciciosSeleccionados[id]) {
            delete ejerciciosSeleccionados[id];
            item.classList.remove('seleccionado');
            // No ocultes los inputs
        } else {
            ejerciciosSeleccionados[id] = nombre;
            item.classList.add('seleccionado');
            // No muestres los inputs, ya están visibles
        }
        actualizarBotonContador();
    }

    function actualizarBotonContador() {
        const btn = document.getElementById('btn-agregar-ejercicios');
        const total = Object.keys(ejerciciosSeleccionados).length;
        btn.textContent = `Agregar ${total} Ejercicio${total !== 1 ? 's' : ''}`;
    }

    function agregarSeleccionados() {
        let contenedor = document.getElementById('ejercicios-seleccionados');
        contenedor.innerHTML = '';
        for (let id in ejerciciosSeleccionados) {
            let series = document.querySelector(`[name="series_${id}"]`)?.value || '';
            let repeticiones = document.querySelector(`[name="repeticiones_${id}"]`)?.value || '';
            let peso = document.querySelector(`[name="peso_${id}"]`)?.value || '';
            contenedor.innerHTML += `
    <input type="hidden" name="ejercicios[${id}][id]" value="${id}">
    <input type="hidden" name="ejercicios[${id}][series]" value="${series}">
    <input type="hidden" name="ejercicios[${id}][repeticiones]" value="${repeticiones}">
    <input type="hidden" name="ejercicios[${id}][peso]" value="${peso}">
`;
        }
        cerrarModalEjercicios();
    }

    function filtrarEjercicios() {
        let filtro = document.getElementById('buscador-ejercicio').value.toLowerCase();
        document.querySelectorAll('.ejercicio-item').forEach(item => {
            let nombre = item.getAttribute('data-nombre').toLowerCase();
            item.style.display = nombre.includes(filtro) ? '' : 'none';
        });
    }

    document.querySelector('.create-form').addEventListener('submit', function(e) {
        // Verifica si hay al menos un ejercicio seleccionado
        const ejercicios = document.querySelectorAll('input[name^="ejercicios["]');
        if (ejercicios.length === 0) {
            alert('Debes agregar al menos un ejercicio a la rutina.');
            e.preventDefault();
            return false;
        }
    });
</script>