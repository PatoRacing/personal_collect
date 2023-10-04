function mostrarCaracteres(input) {
    var delay = 200; // Tiempo en milisegundos para ocultar los caracteres
    var campoPassword = document.getElementById("password");
    
    campoPassword.type = "text"; // Cambiar el tipo a texto para mostrar los caracteres
    
    clearTimeout(campoPassword.timeoutID); // Limpiar el temporizador anterior
    
    campoPassword.timeoutID = setTimeout(function() {
        campoPassword.type = "password"; // Cambiar de nuevo a contraseña después del tiempo establecido
    }, delay);
}

// Obtener referencia al campo de contraseña por su ID
var campoPassword = document.getElementById("password");

// Agregar un evento para el evento de tecla presionada
campoPassword.addEventListener("keydown", function(event) {
    mostrarCaracteres(event.target);
});
