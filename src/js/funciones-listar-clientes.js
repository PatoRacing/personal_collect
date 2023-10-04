(function(){
//Borrar las alertas de exito luego de 3 segundos
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