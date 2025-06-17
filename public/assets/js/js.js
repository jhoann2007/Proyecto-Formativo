// Cargar FullCalendar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendarBody');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        dateClick: function (info) {
            document.getElementById('modalContent').innerText = `Seleccionaste el día: ${info.dateStr}`;
            new bootstrap.Modal(document.getElementById('eventModal')).show();
        }
    });

    calendar.render();

    // Navegación de mes
    document.getElementById('prevMonth').addEventListener('click', function () {
        calendar.prev();
    });

    document.getElementById('nextMonth').addEventListener('click', function () {
        calendar.next();
    });
});
