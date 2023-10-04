(function () {
    //Buscador 
    document.addEventListener('DOMContentLoaded', function() {
        const buscador = document.querySelector('#buscador');
        const tablaUsuarios = document.querySelector('#tabla-usuarios');
    
        buscador.addEventListener('input', function() {
            const valorBusqueda = buscador.value.trim().toLowerCase();
            const filas = tablaUsuarios.querySelectorAll('.table__tr');
    
            filas.forEach(fila => {
                const nombreApellido = fila.querySelector('.table__td--nombre a').textContent.toLowerCase();
    
                if (nombreApellido.includes(valorBusqueda)) {
                    fila.style.display = 'table-row'; // Muestra la fila si coincide con la búsqueda
                } else {
                    fila.style.display = 'none'; // Oculta la fila si no coincide con la búsqueda
                }
            });
        });
    });

    //Borrar notificaciones luego de 3 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const notificacion = document.getElementById('notificacion');
    
        if (notificacion) {
            // Ocultar la notificación después de 5 segundos
            setTimeout(function() {
                notificacion.style.display = 'none';
            }, 3000); // 5000 milisegundos = 5 segundos
        }
    });

    //Activar la clase inactivo cuando el valor del estado es inactivo
    document.addEventListener('DOMContentLoaded', function() {
        const filas = document.querySelectorAll('.table__tr'); // Selecciona todas las filas
    
        filas.forEach(fila => {
            const tablaEstado = fila.querySelector('#tabla-estado'); // Encuentra el campo de estado en cada fila
            const estado = tablaEstado.textContent.trim();
    
            if (estado === 'Inactivo') {
                fila.classList.add('inactivo'); // Agrega la clase 'inactivo' a la fila
            }
        });
    });
})();