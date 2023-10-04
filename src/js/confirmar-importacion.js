// confirmar-importacion.js

document.addEventListener("DOMContentLoaded", function () {
    // Esta variable debe estar definida en tu vista y ser igual a true si se cumplen las condiciones
    if (typeof $confirmarImportacion !== 'undefined' && $confirmarImportacion === true) {
        Swal.fire({
            title: "Confirmar importación",
            text: "¿Estás seguro de que deseas importar el archivo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, importar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Envía el formulario manualmente
                document.querySelector(".formulario").submit();
            }
        });
    }
});
