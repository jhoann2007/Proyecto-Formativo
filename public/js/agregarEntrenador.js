document.addEventListener('DOMContentLoaded', function() {
            // Búsqueda en tabla
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    filterTable(searchTerm);
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
                    noResultsRow.innerHTML = '<td colspan="7" class="text-center">No se encontraron entrenadores con los criterios de búsqueda</td>';
                    tbody.appendChild(noResultsRow);
                }
            }
        });