document.addEventListener('DOMContentLoaded', function () {
    console.log('Calendario iniciado');
    console.log('Rol:', window.userRole, '| Usuario:', window.userName);

    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error('No se encontró el elemento #calendar');
        return;
    }

    const FullCalendar = window.FullCalendar;
    const bootstrap = window.bootstrap;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        height: 'auto',
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        slotDuration: '00:30:00',
        allDaySlot: true,

        events: function (fetchInfo, successCallback) {
            fetch('/calendario/obtenerEventos', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(res => res.json())
            .then(data => {
                console.log('Eventos:', data);
                successCallback(data);
            })
            .catch(err => {
                console.error('Error al cargar eventos:', err);
                successCallback([]);
            });
        },

        dateClick: function (info) {
            if (window.userRole === 'aprendiz') {
                mostrarModalAprendiz(info.dateStr);
            } else {
                mostrarModalEvento(info.dateStr);
            }
        },

        eventClick: function (info) {
            mostrarInfoEvento(info.event);
        },

        eventDisplay: 'block',
        dayMaxEvents: false,
        moreLinkClick: 'popover'
    });

    calendar.render();

    /* ========= FUNCIONES ========= */

    function mostrarModalEvento(fecha) {
        document.getElementById('modalTitle').textContent = 'Registrar Horario del Gimnasio';
        document.getElementById('fechaSeleccionada').value = fecha;
        document.getElementById('eventoId').value = '';
        document.getElementById('formEvento').reset();
        document.getElementById('btnEliminar').style.display = 'none';
        document.getElementById('aprendicesSection').style.display = 'none';

        new bootstrap.Modal(document.getElementById('eventoModal')).show();
    }

    function mostrarModalAprendiz(fecha) {
        fetch('/calendario/obtenerRegistrosAprendiz', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `fecha=${fecha}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.data) {
                return showAlert('info', 'Ya tienes un registro para este día');
            }

            const eventosDelDia = calendar.getEvents().filter(ev => {
                return ev.start.toISOString().split('T')[0] === fecha && ev.extendedProps.estado === 'activo';
            });

            if (!eventosDelDia.length) {
                return showAlert('warning', 'No hay horarios disponibles para este día');
            }

            const evento = eventosDelDia[0];
            document.getElementById('fechaAprendiz').value = fecha;
            document.getElementById('calendarioIdAprendiz').value = evento.id;
            document.getElementById('horarioDisponible').innerHTML = `
                <div class="alert alert-success">
                    <strong>Horario Disponible:</strong><br>
                    ${evento.title}<br>
                    Horario: ${evento.extendedProps.hora_inicio} - ${evento.extendedProps.hora_cierre}<br>
                    Encargado: ${evento.extendedProps.encargado}
                </div>
            `;
            document.getElementById('hora_entrada').value = '';
            document.getElementById('hora_salida').value = '';

            new bootstrap.Modal(document.getElementById('aprendizModal')).show();
        })
        .catch(err => {
            console.error('Error:', err);
            showAlert('error', 'Error al verificar registros');
        });
    }

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
        `;

        if ((window.userRole === 'admin' || window.userRole === 'entrenador') && evento.extendedProps.aprendices) {
            if (evento.extendedProps.aprendices.length) {
                content += `<hr><h6><i class="fas fa-users"></i> Aprendices Registrados (${evento.extendedProps.aprendices.length})</h6>`;
                evento.extendedProps.aprendices.forEach(aprendiz => {
                    content += `
                        <div class="estilo-aprendices">
                            <span><strong>${aprendiz.nombre_aprendiz}</strong></span>
                            <span class="color-hora-aprendices">${aprendiz.hora_entrada} - ${aprendiz.hora_salida}</span>
                        </div>
                    `;
                });
            } else {
                content += `<hr><p class="texto-muted"><i class="fas fa-info-circle"></i> No hay aprendices registrados</p>`;
            }
        }

        content += `</div>`;
        document.getElementById('infoContent').innerHTML = content;

        if (window.userRole === 'admin' || window.userRole === 'entrenador') {
            document.getElementById('btnEditar').onclick = function () {
                bootstrap.Modal.getInstance(document.getElementById('infoModal')).hide();
                const fechaEvento = evento.start.toISOString().split('T')[0];
                editarEvento(evento.id, fechaEvento);
            };
        }

        new bootstrap.Modal(document.getElementById('infoModal')).show();
    }

    function editarEvento(eventoId, fecha) {
        fetch('/calendario/obtenerEvento', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `fecha=${fecha}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                const ev = data.data;
                document.getElementById('modalTitle').textContent = 'Editar Horario del Gimnasio';
                document.getElementById('fechaSeleccionada').value = ev.fecha;
                document.getElementById('eventoId').value = ev.id_calendario;
                document.getElementById('hora_inicio').value = ev.hora_inicio;
                document.getElementById('hora_cierre').value = ev.hora_cierre;
                document.getElementById('id_encargado').value = ev.id_encargado;
                document.getElementById('capacidad_max').value = ev.capacidad_max;
                document.getElementById('estado').value = ev.estado;
                document.getElementById('btnEliminar').style.display = 'inline-block';

                if (ev.aprendices?.length) {
                    let html = '';
                    ev.aprendices.forEach(a => {
                        html += `
                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                                <span><strong>${a.nombre_aprendiz}</strong></span>
                                <span class="badge bg-primary">${a.hora_entrada} - ${a.hora_salida}</span>
                            </div>
                        `;
                    });
                    document.getElementById('listaAprendices').innerHTML = html;
                    document.getElementById('aprendicesSection').style.display = 'block';
                } else {
                    document.getElementById('aprendicesSection').style.display = 'none';
                }

                new bootstrap.Modal(document.getElementById('eventoModal')).show();
            } else {
                showAlert('error', 'No se pudo cargar el evento');
            }
        })
        .catch(() => showAlert('error', 'Error al cargar el evento'));
    }

    /* ========= ENVÍO FORMULARIOS ========= */

    if (document.getElementById('formEvento')) {
        document.getElementById('formEvento').addEventListener('submit', function (e) {
            e.preventDefault();
            fetch('/calendario/guardarEvento', { method: 'POST', body: new FormData(this) })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'ok') {
                    bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
                    calendar.refetchEvents();
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(() => showAlert('error', 'Error al guardar el evento'));
        });
    }

    if (document.getElementById('formAprendiz')) {
        document.getElementById('formAprendiz').addEventListener('submit', function (e) {
            e.preventDefault();

            const horaEntrada = document.getElementById('hora_entrada').value;
            const horaSalida = document.getElementById('hora_salida').value;

            if (horaEntrada >= horaSalida) {
                return showAlert('error', 'La hora de entrada debe ser menor que la de salida');
            }

            const diff = (new Date(`2000-01-01T${horaSalida}`) - new Date(`2000-01-01T${horaEntrada}`)) / (1000 * 60 * 60);
            if (diff > 2) {
                return showAlert('error', 'Solo puedes registrar máximo 2 horas');
            }

            fetch('/calendario/registrarAprendiz', { method: 'POST', body: new FormData(this) })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'ok') {
                    bootstrap.Modal.getInstance(document.getElementById('aprendizModal')).hide();
                    calendar.refetchEvents();
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(() => showAlert('error', 'Error al registrar asistencia'));
        });
    }

    if (document.getElementById('btnEliminar')) {
        document.getElementById('btnEliminar').addEventListener('click', function () {
            if (!confirm('¿Seguro que deseas eliminar este horario?')) return;
            const formData = new FormData();
            formData.append('id', document.getElementById('eventoId').value);

            fetch('/calendario/eliminarEvento', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'ok') {
                    bootstrap.Modal.getInstance(document.getElementById('eventoModal')).hide();
                    calendar.refetchEvents();
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(() => showAlert('error', 'Error al eliminar el evento'));
        });
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'error' ? 'alert-danger' :
                          type === 'warning' ? 'alert-warning' : 'alert-info';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        setTimeout(() => document.querySelector('.alert')?.remove(), 5000);
    }

    window.calendar = calendar;
    window.showAlert = showAlert;
});
