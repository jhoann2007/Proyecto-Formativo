document.addEventListener('DOMContentLoaded', function () {
  function generarCalendario(mes, año) {
      const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

      const primerDia = new Date(año, mes - 1, 1);
      const ultimoDia = new Date(año, mes, 0);

      const cardBody = document.getElementById('calendarBody');
      cardBody.innerHTML = '';

      // Crear encabezado con los días de la semana
      const headerRow = document.createElement('div');
      headerRow.className = 'row mb-2';

      diasSemana.forEach(dia => {
          const col = document.createElement('div');
          col.className = 'col text-center fw-bold';
          col.innerText = dia;
          headerRow.appendChild(col);
      });

      cardBody.appendChild(headerRow);

      // Comenzar desde el primer día del calendario (puede ser del mes anterior)
      let fechaInicio = new Date(primerDia);
      fechaInicio.setDate(fechaInicio.getDate() - fechaInicio.getDay());

      // Dibujar semanas hasta completar el mes
      while (fechaInicio <= ultimoDia || fechaInicio.getDay() !== 0) {
          const semanaRow = document.createElement('div');
          semanaRow.className = 'row mb-2';

          for (let i = 0; i < 7; i++) {
              const col = document.createElement('div');
              col.className = 'col text-center border p-2';

              if (fechaInicio.getMonth() === mes - 1) {
                  col.textContent = fechaInicio.getDate();
              } else {
                  col.innerHTML = '<span class="text-muted">' + fechaInicio.getDate() + '</span>';
              }

              semanaRow.appendChild(col);
              fechaInicio.setDate(fechaInicio.getDate() + 1);
          }

          cardBody.appendChild(semanaRow);
      }

      const nombresMeses = [
          "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
          "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
      ];

      document.querySelector('.card-header h5').textContent =
          `Calendario - ${nombresMeses[mes - 1]} ${año}`;
  }

  const ahora = new Date();
  let mesActual = ahora.getMonth() + 1;
  let añoActual = ahora.getFullYear();

  generarCalendario(mesActual, añoActual);

  document.getElementById('prevMonth').addEventListener('click', function () {
      mesActual--;
      if (mesActual < 1) {
          mesActual = 12;
          añoActual--;
      }
      generarCalendario(mesActual, añoActual);
  });

  document.getElementById('nextMonth').addEventListener('click', function () {
      mesActual++;
      if (mesActual > 12) {
          mesActual = 1;
          añoActual++;
      }
      generarCalendario(mesActual, añoActual);
  });
});
