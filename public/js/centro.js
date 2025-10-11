// Funciones para la vista de centros
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar búsqueda
    initSearch();
    
    // Inicializar modales
    initModals();
});

// Función para inicializar la búsqueda en la tabla
function initSearch() {
    const searchInput = document.getElementById('searchInput');
     if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTable();
        });
    }
}

// Función para filtrar la tabla
function filterTable() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toUpperCase();
    const table = document.querySelector('.table-vista');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        let found = false;
        const cells = rows[i].getElementsByTagName('td');
        
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const textValue = cell.textContent || cell.innerText;
                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}

// Función para inicializar los modales
function initModals() {
    // Obtener referencias a los elementos del modal
    const modal = document.getElementById('modalAprendiz');
    const btnAgregar = document.querySelector('.btn-agregar');
    const btnClose = modal.querySelector('.btn-close');
    const btnCancelar = modal.querySelector('.btn-cancelar');
    
    // Mostrar el modal al hacer clic en el botón de agregar
    if (btnAgregar) {
        btnAgregar.addEventListener('click', function() {
            modal.style.display = 'block';
        });
    }
    
    // Cerrar el modal al hacer clic en el botón de cerrar
    if (btnClose) {
        btnClose.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Cerrar el modal al hacer clic en el botón de cancelar
    if (btnCancelar) {
        btnCancelar.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Cerrar el modal al hacer clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}