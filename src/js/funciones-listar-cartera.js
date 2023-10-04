(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const filtroInput = document.querySelector('#search');
        const tablaUsuarios = document.querySelector('#tabla-search');
        const filas = tablaUsuarios.querySelectorAll('tbody tr');

        filtroInput.addEventListener('input', function () {
            const filtro = filtroInput.value.trim().toLowerCase();

            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();

                if (textoFila.includes(filtro)) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });
})();
