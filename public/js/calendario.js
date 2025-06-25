document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM cargado, inicializando calendario...')
    console.log('Rol del usuario:', window.userRole)
    console.log('Usuario:', window.userName)

    const calendarEl = document.getElementById('calendar')
    if (!calendarEl) {
        console.error('No se encontró el elemento calendar')
        return
    }

    let calendar
    const FullCalendar = window.FullCalendar; // Declare FullCalendar variable
    const bootstrap = window.bootstrap; // Declare bootstrap variable

    // Inicializar calendario
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        height: 'auto',
        // Configuración para mostrar horas correctamente
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        slotDuration: '00:30:00',
        allDaySlot: true,
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
                // Verificar que los eventos tengan el formato correcto
                data.forEach(evento => {
                    console.log('Evento:', evento.title, 'Start:', evento.start, 'End:', evento.end, 'AllDay:', evento.allDay)
                })
                successCallback(data)
            })
            .catch(error => {
                console.error('Error al cargar eventos:', error)
                successCallback([]) // Cargar calendario vacío si hay error
            })
        },
        dateClick: function (info) {
            console.log('Fecha clickeada:', info.dateStr)
            
            if (window.userRole === 'aprendiz') {
                mostrarModalAprendiz(info.dateStr)
            } else {
                mostrarModalEvento(info.dateStr)
            }
        },
        eventClick: function (info) {
            console.log('Evento clickeado:', info.event)
            mostrarInfoEvento(info.event)
        },
        // Configuración adicional para las vistas de tiempo
        eventDisplay: 'block',
        dayMaxEvents: false,
        moreLinkClick: 'popover'
    })

    calendar.render()
    console.log('Calendario renderizado')

    // Función para mostrar modal de evento (Admin/Entrenador)
    function mostrarModalEvento(fecha) {
        if (window.userRole === 'aprendiz') return

        // Limpiar formulario
        document.getElementById('modalTitle').textContent = 'Registrar Horario del Gimnasio'
        document.getElementById('fechaSeleccionada').value = fecha
        document.getElementById('eventoId').value = ''
        document.getElementById('formEvento').reset()
        document.getElementById('btnEliminar').style.display = 'none'
        document.getElementById('aprendicesSection').style.display = 'none'

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('eventoModal'))
        modal.show()
    }

    // Función para mostrar modal de aprendiz
    function mostrarModalAprendiz(fecha) {
        if (window.userRole !== 'aprendiz') return

        // Verificar si ya tiene registro para este día
        fetch('/calendario/obtenerRegistrosAprendiz', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `fecha=${fecha}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.data) {
                showAlert('info', 'Ya tienes un registro para este día')
                return
            }

            // Buscar eventos disponibles para esta fecha
            const eventosDelDia = calendar.getEvents().filter(event => {
                // Comparar solo la fecha, no la hora
                const eventDate = event.start.toISOString().split('T')[0]
                return eventDate === fecha && event.extendedProps.estado === 'activo'
            })

            if (eventosDelDia.length === 0) {
                showAlert('warning', 'No hay horarios disponibles para este día')
                return
            }

            const evento = eventosDelDia[0]
            
            // Llenar modal
            document.getElementById('fechaAprendiz').value = fecha
            document.getElementById('calendarioIdAprendiz').value = evento.id
            
            const horarioInfo = `
                <div class="alert alert-success">
                    <strong>Horario Disponible:</strong><br>
                    ${evento.title}<br>
                    Horario: ${evento.extendedProps.hora_inicio} - ${evento.extendedProps.hora_cierre}<br>
                    Encargado: ${evento.extendedProps.encargado}
                </div>
            `
            document.getElementById('horarioDisponible').innerHTML = horarioInfo

            // Limpiar campos de tiempo
            document.getElementById('hora_entrada').value = ''
            document.getElementById('hora_salida').value = ''

            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('aprendizModal'))
            modal.show()
        })
        .catch(error => {
            console.error('Error:', error)
            showAlert('error', 'Error al verificar registros')
        })
    }

    // Función para mostrar información del evento
    function mostrarInfoEvento(evento) {
        let content = `
            <div class="event-info">
                <h6><strong>${evento.title}</strong></h6>
                <div class="mt-3">
                    <p><strong>Horario:</strong> ${evento.extendedProps.hora_inicio} - ${evento.extendedProps.hora_cierre}</p>
                    <p><strong>Encargado:</strong> ${evento.extendedProps.encargado}</p>
                    <p><strong>Capacidad:</strong> ${evento.extendedProps.capacidad_max} personas</p>
                    <p><strong>Estado:</strong> ${evento.extendedProps.estado}</p>
                </div>
        `

        // Si es admin o entrenador, mostrar aprendices registrados
        if ((window.userRole === 'admin' || window.userRole === 'entrenador') && evento.extendedProps.aprendices) {
            if (evento.extendedProps.aprendices.length > 0) {
                content += `
                    <hr>
                    <h6><i class="fas fa-users"></i> Aprendices Registrados (${evento.extendedProps.aprendices.length})</h6>
                    <div class="mt-2">
                `
                evento.extendedProps.aprendices.forEach(aprendiz => {
                    content += `
                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                            <span><strong>${aprendiz.nombre_aprendiz}</strong></span>
                            <span class="badge bg-primary">${aprendiz.hora_entrada} - ${aprendiz.hora_salida}</span>
                        </div>
                    `
                })
                content += `</div>`
            } else {
                content += `
                    <hr>
                    <p class="text-muted"><i class="fas fa-info-circle"></i> No hay aprendices registrados para este horario</p>
                `
            }
        }

        content += `</div>`

        document.getElementById('infoContent').innerHTML = content

        // Configurar botón editar
        if (window.userRole === 'admin' || window.userRole === 'entrenador') {
            document.getElementById('btnEditar').onclick = function () {
                bootstrap.Modal.getInstance(document.getElementById('infoModal')).hide()
                // Obtener solo la fecha del evento
                const fechaEvento = evento.start.toISOString().split('T')[0]
                editarEvento(evento.id, fechaEvento)
            }
        }

        const infoModal = new bootstrap.Modal(document.getElementById('infoModal'))
        infoModal.show()
    }

    // Función para editar evento
    function editarEvento(eventoId, fecha) {
        if (window.userRole === 'aprendiz') return

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

                document.getElementById('modalTitle').textContent = 'Editar Horario del Gimnasio'
                document.getElementById('fechaSeleccionada').value = evento.fecha
                document.getElementById('eventoId').value = evento.id_calendario
                document.getElementById('hora_inicio').value = evento.hora_inicio
                document.getElementById('hora_cierre').value = evento.hora_cierre
                document.getElementById('id_encargado').value = evento.id_encargado
                document.getElementById('capacidad_max').value = evento.capacidad_max
                document.getElementById('estado').value = evento.estado
                document.getElementById('btnEliminar').style.display = 'inline-block'

                // Mostrar aprendices registrados si los hay
                if (evento.aprendices && evento.aprendices.length > 0) {
                    let aprendicesHtml = ''
                    evento.aprendices.forEach(aprendiz => {
                        aprendicesHtml += `
                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                                <span><strong>${aprendiz.nombre_aprendiz}</strong></span>
                                <span class="badge bg-primary">${aprendiz.hora_entrada} - ${aprendiz.hora_salida}</span>
                            </div>
                        `
                    })
                    document.getElementById('listaAprendices').innerHTML = aprendicesHtml
                    document.getElementById('aprendicesSection').style.display = 'block'
                } else {
                    document.getElementById('aprendicesSection').style.display = 'none'
                }

                const modal = new bootstrap.Modal(document.getElementById('eventoModal'))
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

    // Manejar envío del formulario de evento (Admin/Entrenador)
    if (document.getElementById('formEvento')) {
        document.getElementById('formEvento').addEventListener('submit', function (e) {
            e.preventDefault()
            console.log('Enviando formulario de evento...')

            const formData = new FormData(this)

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
                    bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide()
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
    }

    // Manejar envío del formulario de aprendiz
    if (document.getElementById('formAprendiz')) {
        document.getElementById('formAprendiz').addEventListener('submit', function (e) {
            e.preventDefault()
            console.log('Enviando formulario de aprendiz...')

            const formData = new FormData(this)

            // Validar horas en el cliente también
            const horaEntrada = document.getElementById('hora_entrada').value
            const horaSalida = document.getElementById('hora_salida').value

            if (horaEntrada >= horaSalida) {
                showAlert('error', 'La hora de entrada debe ser menor que la hora de salida')
                return
            }

            // Calcular diferencia de horas
            const entrada = new Date(`2000-01-01T${horaEntrada}`)
            const salida = new Date(`2000-01-01T${horaSalida}`)
            const diferencia = (salida - entrada) / (1000 * 60 * 60) // en horas

            if (diferencia > 2) {
                showAlert('error', 'Solo puedes registrar máximo 2 horas por día')
                return
            }

            fetch('/calendario/registrarAprendiz', {
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
                    bootstrap.Modal.getInstance(document.getElementById('aprendizModal')).hide()
                    calendar.refetchEvents()
                    showAlert('success', data.message)
                } else {
                    showAlert('error', data.message)
                }
            })
            .catch(error => {
                console.error('Error:', error)
                showAlert('error', 'Error al registrar asistencia')
            })
        })
    }

    // Manejar eliminación de evento
    if (document.getElementById('btnEliminar')) {
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
                        bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide()
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
    }

    // Función para mostrar alertas
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info'
        
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