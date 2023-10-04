(function() {
    // ...

    document.addEventListener('DOMContentLoaded', function() {
        const buscador = document.querySelector('#buscador2');
        const tablaUsuarios = document.querySelector('#tabla-usuarios');

        buscador.addEventListener('input', function() {
            const valorBusqueda = buscador.value.trim().toLowerCase();
            const filas = tablaUsuarios.querySelectorAll('.table__tr');

            filas.forEach(fila => {
                const nombre = fila.querySelector('.table__td--nombre').textContent.toLowerCase();
                const dni = fila.querySelector('.table__td--dni').textContent.toLowerCase();
                const operacion = fila.querySelector('.table__td--operacion').textContent.toLowerCase();

                if (nombre.includes(valorBusqueda) || dni.includes(valorBusqueda) || operacion.includes(valorBusqueda)) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const notificacion = document.getElementById('notificacion');
    
        if (notificacion) {
            // Ocultar la notificación después de 5 segundos
            setTimeout(function() {
                notificacion.style.display = 'none';
            }, 3000); // 5000 milisegundos = 5 segundos
        }
    });
})();
