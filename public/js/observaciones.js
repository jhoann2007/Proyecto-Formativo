document.addEventListener('DOMContentLoaded', function() {
    // Función para formatear la fecha
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    // Función para agregar una nueva observación al DOM
    function addObservationToDOM(container, text, date) {
        const observationDiv = document.createElement('div');
        observationDiv.className = 'p-2 mb-2 bg-light rounded';
        
        const dateSpan = document.createElement('small');
        dateSpan.className = 'text-muted';
        dateSpan.textContent = formatDate(date);
        
        observationDiv.appendChild(dateSpan);
        observationDiv.appendChild(document.createElement('br'));
        observationDiv.appendChild(document.createTextNode(text));
        
        container.appendChild(observationDiv);
    }
    
    // Inicializar los formularios de observaciones
    const observationForms = document.querySelectorAll('form[action*="agregarObservacion"]');
    
    observationForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = form.querySelector('input[name="txtId"]').value;
            const observationText = form.querySelector('textarea[name="nuevaObservacion"]').value.trim();
            
            if (!observationText) {
                alert('Por favor, ingrese una observación');
                return;
            }
            
            // Enviar la observación al servidor
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'txtId': id,
                    'nuevaObservacion': observationText
                })
            })
            .then(response => {
                if (response.ok) {
                    // Agregar la observación al DOM
                    const container = form.closest('.modal-body').querySelector('.p-2.border.rounded.mb-3');
                    addObservationToDOM(container, observationText, new Date());
                    
                    // Limpiar el formulario
                    form.querySelector('textarea').value = '';
                    
                    // Mostrar mensaje de éxito
                    alert('Observación agregada correctamente');
                } else {
                    throw new Error('Error al agregar la observación');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al agregar la observación. Por favor, inténtelo de nuevo.');
            });
        });
    });
});