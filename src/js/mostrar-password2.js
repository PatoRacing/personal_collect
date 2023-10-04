function mostrarCaracteres2(input) {
    var delay = 500; // Tiempo en milisegundos para ocultar los caracteres
    var campoPassword = document.getElementById("password2");
    
    campoPassword.type = "text"; // Cambiar el tipo a texto para mostrar los caracteres
    
    clearTimeout(campoPassword.timeoutID); // Limpiar el temporizador anterior
    
    campoPassword.timeoutID = setTimeout(function() {
        campoPassword.type = "password"; // Cambiar de nuevo a contraseña después del tiempo establecido
    }, delay);
}