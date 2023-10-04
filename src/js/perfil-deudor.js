(function() {
    // ...
    document.addEventListener('DOMContentLoaded', function() {
        const notificacion = document.getElementById('notificacion');

        if (notificacion) {
            // Ocultar la notificación después de 5 segundos
            setTimeout(function() {
                notificacion.style.display = 'none';
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    });
})();
