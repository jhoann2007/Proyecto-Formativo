document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM cargado, inicializando calendario...')

    const calendarEl = document.getElementById('calendar')
    if (!calendarEl) {
        console.error('No se encontró el elemento calendar')
    return
    }

    let calendar

    // Inicializar calendario
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: 'auto',
        events: function (fetchInfo, successCallback, failureCallback) {
            console.log('Cargando eventos...')

        fetch('/calendario/obtenerEventos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => {
            console.log('Respuesta recibida:', response)
            if (!response.ok) {
                throw new Error(
                    'Error en la respuesta del servidor: ' + response.status
                )
            }
            return response.json()
        })
        .then(data => {
            console.log('Eventos cargados:', data)
            successCallback(data)
        })
        .catch(error => {
            console.error('Error al cargar eventos:', error)
            successCallback([]) // Cargar calendario vacío si hay error
        })
    },
    dateClick: function (info) {
        console.log('Fecha clickeada:', info.dateStr)

        // Limpiar formulario
        document.getElementById('modalTitle').textContent =
            'Registrar Horario del Gimnasio'
        document.getElementById('fechaSeleccionada').value = info.dateStr
        document.getElementById('eventoId').value = ''
        document.getElementById('formEvento').reset()
        document.getElementById('btnEliminar').style.display = 'none'

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('eventoModal'))
        modal.show()

        console.log('Modal mostrado')
    },
    eventClick: function (info) {
        console.log('Evento clickeado:', info.event)

        const evento = info.event
        const content = `
            <div class="event-info">
                <h6><strong>${evento.title}</strong></h6>
                <div class="mt-3">
                    ${evento.extendedProps.description || 'Sin descripción'}
                </div>
            </div>
        `

        document.getElementById('infoContent').innerHTML = content

        // Configurar botón editar
        document.getElementById('btnEditar').onclick = function () {
            bootstrap.Modal.getInstance(document.getElementById('infoModal')).hide()
            editarEvento(evento.id, evento.startStr)
        }

        const infoModal = new bootstrap.Modal(
            document.getElementById('infoModal')
        )
        infoModal.show()
    }
})

calendar.render()
console.log('Calendario renderizado')

// Función para editar evento
function editarEvento (eventoId, fecha) {
    console.log('Editando evento:', eventoId, fecha)

    fetch('/calendario/obtenerEvento', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `fecha=${fecha}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor')
        }
        return response.json()
    })
    .then(data => {
        if (data.status === 'ok') {
            const evento = data.data

            document.getElementById('modalTitle').textContent =
                'Editar Horario del Gimnasio'
            document.getElementById('fechaSeleccionada').value = evento.fecha
            document.getElementById('eventoId').value = evento.id_calendario
            document.getElementById('hora_inicio').value = evento.hora_inicio
            document.getElementById('hora_cierre').value = evento.hora_cierre
            document.getElementById('id_encargado').value = evento.id_encargado
            document.getElementById('capacidad_max').value = evento.capacidad_max
            document.getElementById('estado').value = evento.estado
            document.getElementById('btnEliminar').style.display = 'inline-block'

            const modal = new bootstrap.Modal(
                document.getElementById('eventoModal')
            )
            modal.show()
        } else {
            showAlert('error', 'No se pudo cargar el evento')
        }
    })
    .catch(error => {
        console.error('Error:', error)
        showAlert('error', 'Error al cargar el evento')
    })
}

// Manejar envío del formulario
document
    .getElementById('formEvento')
    .addEventListener('submit', function (e) {
        e.preventDefault()
        console.log('Enviando formulario...')

    const formData = new FormData(this)

    // Debug: mostrar datos del formulario
    for (let [key, value] of formData.entries()) {
        console.log(key, value)
    }

    fetch('/calendario/guardarEvento', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor')
        }
        return response.json()
    })
    .then(data => {
        console.log('Respuesta del servidor:', data)

        if (data.status === 'ok') {
            bootstrap.Modal.getInstance(
            document.getElementById('eventoModal')
            ).hide()
            calendar.refetchEvents()
            showAlert('success', data.message)
        } else {
            showAlert('error', data.message)
        }
    })
    .catch(error => {
        console.error('Error:', error)
        showAlert('error', 'Error al guardar el evento')
    })
})

// Manejar eliminación de evento
document.getElementById('btnEliminar').addEventListener('click', function () {
    if (confirm('¿Estás seguro de que deseas eliminar este horario?')) {
    const eventoId = document.getElementById('eventoId').value

    const formData = new FormData()
    formData.append('id', eventoId)

    fetch('/calendario/eliminarEvento', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor')
        }
        return response.json()
    })
    .then(data => {
        if (data.status === 'ok') {
            bootstrap.Modal.getInstance(
            document.getElementById('eventoModal')
            ).hide()
            calendar.refetchEvents()
            showAlert('success', data.message)
        } else {
            showAlert('error', data.message)
        }
    })
    .catch(error => {
        console.error('Error:', error)
        showAlert('error', 'Error al eliminar el evento')
    })
}
})

// Función para mostrar alertas
function showAlert (type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger'
    const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                        style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `

document.body.insertAdjacentHTML('beforeend', alertHtml)

// Auto-remover después de 5 segundos
setTimeout(() => {
    const alert = document.querySelector('.alert')
    if (alert) {
        alert.remove()
    }
}, 5000)
}

// Exponer funciones globalmente para debugging
window.calendar = calendar
window.showAlert = showAlert
})
