document.addEventListener('DOMContentLoaded', function() {
    // Inicializar modales
    initModals();
    
    // Búsqueda en tabla
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            filterTable(searchTerm);
        });
    }
    
    // Filtrado por rol
    const rolLinks = document.querySelectorAll('.ficha-filter');
    const rolSeleccionadoText = document.getElementById('ficha-seleccionada');
    
    rolLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remover clase active de todos los links
            rolLinks.forEach(l => l.classList.remove('active'));
            // Agregar clase active al link actual
            this.classList.add('active');
            
            const rolId = this.getAttribute('data-ficha');
            const rolNombre = this.getAttribute('data-ficha-nombre');
            
            // Actualizar texto de rol seleccionado
            if (rolId === 'todas') {
                rolSeleccionadoText.textContent = '';
                filterByRol('todas');
            } else {
                rolSeleccionadoText.textContent = 'Rol: ' + rolNombre;
                filterByRol(rolId);
            }
        });
    });
    
    // Botón para agregar usuario
    const btnAgregarUsuario = document.getElementById('btnAgregarUsuario');
    if (btnAgregarUsuario) {
        btnAgregarUsuario.addEventListener('click', function() {
            openModal('modalAprendiz');
        });
    }
    
    // Inicializar botones de modales
    function initModals() {
        // Botones para abrir modales
        const modalButtons = document.querySelectorAll('[data-modal]');
        modalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                openModal(modalId);
            });
        });
        
        // Botones para cerrar modales
        const closeButtons = document.querySelectorAll('.btn-close, .modal .btn-secondary');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.modal');
                if (modal) {
                    closeModal(modal.id);
                }
            });
        });
        
        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        });
    }
    
    // Función para filtrar por búsqueda
    function filterTable(searchTerm) {
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (!row.classList.contains('no-data')) {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        checkNoResults();
    }
    
    // Función para filtrar por rol
    function filterByRol(rolId) {
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (!row.classList.contains('no-data')) {
                if (rolId === 'todas') {
                    row.style.display = '';
                } else {
                    // Buscar la celda de rol dentro de la fila
                    const rolCell = row.querySelector('td:nth-child(4)'); // La 4ta columna es el Rol
                    if (rolCell) {
                        const rolText = rolCell.textContent.trim().toLowerCase();
                        const rolNombre = getRolNombreById(rolId);
                        
                        if (rolNombre && rolText.includes(rolNombre.toLowerCase())) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
        
        checkNoResults();
    }
    
    // Función para obtener el nombre del rol por ID
    function getRolNombreById(rolId) {
        const rolLinks = document.querySelectorAll('.ficha-filter');
        let rolNombre = '';
        
        rolLinks.forEach(link => {
            if (link.getAttribute('data-ficha') === rolId) {
                rolNombre = link.getAttribute('data-ficha-nombre');
            }
        });
        
        return rolNombre;
    }
    
    // Función para abrir modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Evitar scroll en el fondo
        }
    }
    
    // Función para cerrar modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Restaurar scroll
        }
    }
    
    // Función combinada para búsqueda y filtro por rol
    function applyCombinedFilters() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const rolSeleccionado = rolSeleccionadoText.textContent.replace('Rol: ', '');
        
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (!row.classList.contains('no-data')) {
                let shouldShow = true;
                
                // Aplicar filtro por rol si hay uno seleccionado
                if (rolSeleccionado && rolSeleccionado !== '') {
                    const rolCell = row.querySelector('td:nth-child(4)');
                    if (rolCell) {
                        const rolText = rolCell.textContent.trim().toLowerCase();
                        if (!rolText.includes(rolSeleccionado.toLowerCase())) {
                            shouldShow = false;
                        }
                    } else {
                        shouldShow = false;
                    }
                }
                
                // Aplicar filtro por búsqueda si hay término
                if (shouldShow && searchTerm) {
                    const rowText = row.textContent.toLowerCase();
                    if (!rowText.includes(searchTerm)) {
                        shouldShow = false;
                    }
                }
                
                row.style.display = shouldShow ? '' : 'none';
            }
        });
        
        checkNoResults();
    }
    
    // Actualizar la función de búsqueda para usar filtros combinados
    if (searchInput) {
        searchInput.addEventListener('keyup', applyCombinedFilters);
    }
    
    // Actualizar la función de filtro por rol para usar filtros combinados
    rolLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const rolId = this.getAttribute('data-ficha');
            const rolNombre = this.getAttribute('data-ficha-nombre');
            
            // Actualizar texto de rol seleccionado
            if (rolId === 'todas') {
                rolSeleccionadoText.textContent = '';
            } else {
                rolSeleccionadoText.textContent = 'Rol: ' + rolNombre;
            }
            
            applyCombinedFilters();
        });
    });
    
    // Verificar si hay resultados visibles
    function checkNoResults() {
        const tableRows = document.querySelectorAll('tbody tr');
        const tbody = document.querySelector('tbody');
        let visibleRows = 0;
        
        tableRows.forEach(row => {
            if (row.style.display !== 'none' && !row.classList.contains('no-data')) {
                visibleRows++;
            }
        });
        
        // Eliminar mensaje de no resultados si existe
        const noResultsRow = document.querySelector('.no-results');
        if (noResultsRow) {
            noResultsRow.remove();
        }
        
        // Mostrar mensaje si no hay resultados
        if (visibleRows === 0) {
            const noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results';
            noResultsRow.innerHTML = '<td colspan="9" class="text-center">No se encontraron usuarios con los criterios de búsqueda</td>';
            tbody.appendChild(noResultsRow);
        }
    }
    
    // Inicializar filtros al cargar la página
    applyCombinedFilters();
});