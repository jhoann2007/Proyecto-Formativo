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
    if (!table) return;
    
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
    // Inicializar todos los botones que abren modales
    const modalButtons = document.querySelectorAll('[data-modal]');
    modalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });

    // Inicializar todos los botones de cierre
    const closeButtons = document.querySelectorAll('.btn-close, .btn-cancelar');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
    
    // Obtener referencias a los elementos del modal principal
    const modal = document.getElementById('modalAprendiz');
    if (!modal) return;
    
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