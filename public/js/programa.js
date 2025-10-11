// Funcionalidad para programas
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar búsqueda
    initSearch();
    
    // Inicializar modales
    initModals();
});

// Función para inicializar la búsqueda
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
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let visible = false;
        const td = tr[i].getElementsByTagName('td');
        
        for (let j = 0; j < td.length - 1; j++) {
            const cell = td[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = visible ? '' : 'none';
    }
}

// Funciones para manejar modales
function initModals() {
    // Agregar event listeners a todos los botones que abren modales
    const modalTriggers = document.querySelectorAll('[data-modal]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });

    // Inicializar todos los botones de cierre
    const closeButtons = document.querySelectorAll('.btn-close, .btn-cancelar, .btn-secondary');
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
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            openModal(modalId);
        });
    });

    // Agregar event listeners a todos los botones que cierran modales
    const closeButtons = document.querySelectorAll('.btn-close, .btn-secondary');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target);
        }
    });
}

// Función para abrir un modal
function openModal(modalId) {
    const modal = document.querySelector(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevenir scroll
    }
}

// Función para cerrar un modal
function closeModal(modal) {
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = ''; // Restaurar scroll
    }
}