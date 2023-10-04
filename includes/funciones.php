<?php
define('CARPETA_EXCEL', $_SERVER['DOCUMENT_ROOT'] . 'excel');

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function pagina_actual($path) : bool {
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

function validarORedireccionar (string $url) {
    $id= $_GET['id'];
    $id= filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: ${url}");
    }
    return $id;
}

function mostrarNotificacion($codigo){
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = "Creado correctamente";
        break;
        case 2:
            $mensaje = "Actualizado correctamente";
        break;
        case 3:
            $mensaje = "Eliminado correctamente";
        break;
        case 4:
            $mensaje = "Cartera importada correctamente";
        break;
        case 5:
            $mensaje = "Se produjo un error en la importacion. Vuelve a intentarlo";
        break;
        case 6:
            $mensaje = "Nueva gestión generada";
        break;
        default:
        $mensaje = false;
        break;
    }
    return $mensaje;
}

function formatearFecha($fecha) {
    return date('d-m-Y', strtotime($fecha));
}

function formatearNumero($numero) {
    // Formatea el número con separador de miles y coma decimal
    return number_format($numero, 2, ',', '.');
}

function formatearDNI($numero) {
    // Formatea el número solo con separador de miles
    return number_format($numero, 0, '', '.');
}

function obtenerClaseSituacion($situacion) {
    switch ($situacion) {
        case 'Sin Gestión':
            return 'fondo-indigo';
        case 'En proceso':
            return 'fondo-indigo';
        case 'Incobrable':
            return 'fondo-rojo';
        case 'Negociación':
            return 'fondo-cyan';
        case 'Propuesta de Pago':
            return 'fondo-azul';
        case 'Ubicado':
            return 'fondo-verde';
        case 'Fallecido':
            return 'fondo-rojo';
        case 'Convenio':
            return 'fondo-verde';
        default:
            return ''; // Si no se encuentra ninguna coincidencia, no se aplica ninguna clase adicional
    }
}

function calcularTiempoConectado() {
    if (isset($_SESSION['inicio_sesion'])) {
        $inicioSesion = $_SESSION['inicio_sesion'];
        $tiempoActual = time();
        $tiempoTranscurrido = $tiempoActual - $inicioSesion;
        
        // Formatear el tiempo transcurrido en horas, minutos y segundos
        $horas = floor($tiempoTranscurrido / 3600);
        $minutos = floor(($tiempoTranscurrido % 3600) / 60);
        $segundos = $tiempoTranscurrido % 60;
        
        return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
    } else {
        return "No se ha iniciado la sesión.";
    }
}

// Al iniciar sesión, establece la hora de inicio de la sesión
if (!isset($_SESSION['inicio_sesion'])) {
    $_SESSION['inicio_sesion'] = time();
}

