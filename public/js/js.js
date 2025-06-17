        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: [
                    {
                        title: 'Reunión con el equipo',
                        start: '2025-06-06',
                        description: 'Planificación del sprint.'
                    },
                    {
                        title: 'Entrega de informe',
                        start: '2025-06-10',
                        description: 'Enviar informe trimestral.'
                    },
                    {
                        title: 'Capacitación interna',
                        start: '2025-06-15',
                        description: 'Curso sobre nuevas herramientas.'
                    },
                    {
                        title: 'Ejemplo practico',
                        start: '2025-07-15',
                        description: 'Ejemplo a ver si funciona'
                    }
                ],
                dateClick: function (info) {
                    const events = calendar.getEvents().filter(event => event.startStr === info.dateStr);
                    if (events.length > 0) {
                        let contenido = '';
                        events.forEach(e => {
                            contenido += `<strong>${e.title}</strong><br>${e.extendedProps.description}<hr>`;
                        });
                        document.getElementById('modalContent').innerHTML = contenido;
                    } else {
                        document.getElementById('modalContent').innerHTML = `No hay eventos para el día <strong>${info.dateStr}</strong>.`;
                    }
                    new bootstrap.Modal(document.getElementById('eventModal')).show();
                }
            });

            calendar.render();

            // Botones de navegación
            document.getElementById('prevMonth').addEventListener('click', () => calendar.prev());
            document.getElementById('nextMonth').addEventListener('click', () => calendar.next());
        });