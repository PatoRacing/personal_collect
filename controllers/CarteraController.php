<?php

namespace Controllers;

use MVC\Router;
use Model\Estados;
use Model\Usuario;
use Model\Clientes;
use Model\Deudores;
use Model\Operaciones;
use Model\Gestiones_deudor;
use Model\Gestiones_operacion;

class CarteraController {
    
    public static function index(Router $router) {
        session_start();
        isAuth();
        $carteras = Operaciones::all();
        $deudores = Deudores::all();
        $estados = Estados::all();
        $clientes = Clientes::all();

        $totalCasos = 0;
        foreach ($carteras as $cartera) {
            if ($cartera->estados_id === 1) {
                $totalCasos++;
            }
        }

        $dniUnicos = [];
        foreach ($carteras as $cartera) {
            $dni = $cartera->nro_doc;
            if (!in_array($dni, $dniUnicos)) {
                $dniUnicos[] = $dni; // Agrega el DNI a la lista de DNI únicos
            }
        }
        $cantidadDniUnicos = count($dniUnicos);

        $deudaActivaTotal = 0;
        foreach ($carteras as $cartera) {
            // Obtén el estado directamente de la tabla Cartera
            $estado = $cartera->estados_id;
            // Verifica si el estado es "activo" (1) antes de sumar la deuda
            if ($estado === 1) {
                // Elimina los puntos de los miles y reemplaza la coma decimal por un punto
                $deuda = str_replace('.', '', $cartera->deuda_total);
                $deuda = str_replace(',', '.', $deuda);
                // Convierte la deuda en un número
                $deuda = floatval($deuda);
                // Suma la deuda activa
                $deudaActivaTotal += $deuda;
            }
        }
        
        $router->render('cartera/cartera', [
            'titulo'=> 'Cartera',
            'carteras'=> $carteras,
            'deudores'=> $deudores,
            'estados'=> $estados,
            'clientes'=> $clientes,
            'totalCasos'=> $totalCasos,
            'cantidadDniUnicos'=> $cantidadDniUnicos,
            'deudaActivaTotal'=> $deudaActivaTotal
        ]);
    }

    public static function deudor (Router $router) {
        session_start();
        isAuth();
        $deudorId = $_GET['id'];
        $resultado = $_GET['resultado'] ?? null;
        if (!filter_var($deudorId, FILTER_VALIDATE_INT)) {
            header('Location: /cartera');
            exit();
        }
        $alertas = [];

        $deudor = Deudores::find($deudorId);
        $usuarios = Usuario::all();
        $clientes = Clientes::all();
        $gestionesDeudor = Gestiones_deudor::getByDeudorId($deudorId);
        $cartera = Operaciones::getByDeudorId($deudorId);
        $operacion_id = [];
        foreach ($cartera as $cartera_operacion_id) {
            $operacion_id[] = $cartera_operacion_id->id;
        }
        $gestionesOperacion = Gestiones_operacion::getByOperacionesId($operacion_id);
        $ultimosRegistros = [];
        foreach ($gestionesOperacion as $gestionOperacion) {
            $operacion_id = $gestionOperacion->operacion_id;
            $fechaHoraActual = strtotime($gestionOperacion->fecha . ' ' . $gestionOperacion->hora);
            if(!isset($ultimosRegistros[$operacion_id])||
                $fechaHoraActual > strtotime($ultimosRegistros[$operacion_id]->fecha
                . ' ' . $ultimosRegistros[$operacion_id]->hora)) {
                $ultimosRegistros[$operacion_id] = $gestionOperacion;
                }
            }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $operacionId = $_POST["operacion_id"];
            $nuevaSituacion = $_POST["situacion"];
            $operacion = Operaciones::find($operacionId);
            if ($operacion) {
                $operacion->situacion = $nuevaSituacion;
                $operacion->guardar();
                header("Location: /perfil-deudor?id=$deudorId");
            } 
        }

        $router->render('cartera/perfil-deudor', [
            'titulo'=> 'Perfil del Deudor',
            'deudor'=> $deudor,
            'alertas'=> $alertas,
            'cartera'=> $cartera,
            'clientes'=> $clientes,
            'ultimosRegistros'=> $ultimosRegistros,
            'gestionesDeudor'=> $gestionesDeudor,
            'usuarios'=> $usuarios,
            'resultado'=> $resultado
        ]);
    }

    public static function gestionDeudor (Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $id=$_GET['id'];
        $deudor = Deudores::find($id);
        $usuarioId=$_SESSION['id'];
        $gestionDeudor = New Gestiones_deudor;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['deudor_id'] = $id;
            $_POST['usuario_id'] = $_SESSION['id'];
            $gestionDeudor->sincronizar($_POST);
            $alertas = $gestionDeudor->validarGestionDeudor();
            if(!$alertas) {
                $resultado=$gestionDeudor->guardar();
                if ($resultado) {
                    // Redireccionar al usuario NUNCA ANTES DEL HTML
                    header("Location: /perfil-deudor?id=$id&resultado=2");
                }
            }
        }
        

        $router->render('cartera/gestion-deudor', [
            'titulo'=> 'Gestión sobre deudor',
            'alertas'=> $alertas,
            'deudor'=> $deudor,
            'usuarioId'=> $usuarioId,
            'gestionDeudor'=> $gestionDeudor
        ]);
    }

    public static function gestionOperacion (Router $router) {
        session_start();
        isAuth();
        $resultado = $_GET['resultado'] ?? null;
        $id=$_GET['id'];
        $operacion = Operaciones::find($id);
        $deudorId = $operacion->deudor_id;
        $deudor = Deudores::find($deudorId);
        $clientes = Clientes::all();
        $gestionesOperacion = Gestiones_operacion::buscarPorOperacionGestiones($id);
        $usuarios = Usuario::all();

        $router->render('cartera/gestion-operacion', [
            'titulo'=> 'Gestión sobre operación',
            'operacion'=> $operacion,
            'gestionesOperacion'=> $gestionesOperacion,
            'clientes'=> $clientes,
            'usuarios'=> $usuarios,
            'resultado'=> $resultado,
            'deudor'=> $deudor
        ]);
    }

    public static function nuevaGestionOperacion (Router $router) {
        session_start();
        isAuth();
        $id=$_GET['id'];
        $operacion = Operaciones::find($id);
        $nuevaGestion = New Gestiones_operacion;
        $alertas = [];
        $datos_paso1 = [];
        $porcentajeHonorarios = 0;
        if ($operacion->producto === 'Mutuales c/cod dcto' ||
            $operacion->producto === 'Mutuales s/cod dcto') {
            $porcentajeHonorarios = 25.69;
        } else {
            $porcentajeHonorarios = 23.25;
        }
        $monto_negociado = '';
        $cant_cuotas = '';
        $porcentaje_quita = '';
        $honorarios = '';
        $monto_total = '';
        $monto_cuotas = '';
        $monto_quita = '';
        $monto_total_a_pagar = '';
        

        if($_SERVER['REQUEST_METHOD']=== 'POST') {
            if(isset($_POST['submit_siguiente'])) {
                $monto_negociado = $_POST ['monto_negociado'];
                $cant_cuotas = $_POST ['cant_cuotas'];
                $porcentaje_quita = $_POST ['porcentaje_quita'];
                $nuevaGestion->sincronizar($_POST);
                $alertas = $nuevaGestion->validarPrimerPaso();
                
                if(!$alertas) {
                    $monto_negociado = floatval($_POST['monto_negociado'] ?? 0);
                    $cant_cuotas = intval($_POST['cant_cuotas']);
                    $porcentaje_quita = floatval($_POST['porcentaje_quita'] ?? 0);
                    $honorarios = ($monto_negociado * $porcentajeHonorarios) / 100;
                    $monto_total = floatval(str_replace(',', '', number_format($monto_negociado + $honorarios, 2)));
                    $monto_cuotas = $monto_total / $cant_cuotas;
                    $monto_quita = $monto_total * ($porcentaje_quita / 100);
                    $monto_total_a_pagar = $monto_total - $monto_quita;
                    
                    $datos_paso1 = [
                        'monto_negociado' => $monto_negociado,
                        'cant_cuotas' => $cant_cuotas,                    
                        'porcentaje_quita' => $porcentaje_quita,
                        'honorarios' => $honorarios,
                        'monto_total' => $monto_total,
                        'monto_cuotas' => $monto_cuotas,
                        'monto_quita' => $monto_quita,
                        'monto_total_a_pagar' => $monto_total_a_pagar
                    ];
                    $_SESSION['datos_paso1'] = $datos_paso1;
                }
            } elseif(isset($_POST['submit_nueva_gestion'])) {
                $datos_paso1 = $_SESSION['datos_paso1'];
                $monto_negociado = $datos_paso1['monto_negociado'];
                $cant_cuotas = $datos_paso1['cant_cuotas'];
                $porcentaje_quita = $datos_paso1['porcentaje_quita'];
                $honorarios = $datos_paso1['honorarios'];
                $monto_total = $datos_paso1['monto_total'];
                $monto_cuotas = $datos_paso1['monto_cuotas'];
                $monto_quita = $datos_paso1['monto_quita'];
                $monto_total_a_pagar = $datos_paso1['monto_total_a_pagar'];
                $nuevaGestion->sincronizar($_POST);
                $alertas = $nuevaGestion->validarSegundoPaso();
                if(!$alertas) {
                    $resultado = $nuevaGestion->crearGestion();
                    if ($resultado) {
                        // Redireccionar al usuario NUNCA ANTES DEL HTML
                        header("Location: /gestion-operacion?id=$id&resultado=6");
                    }
                }
            }
        }
        
        $router->render('cartera/nueva-gestion-operacion', [
            'titulo'=> 'Nueva Gestión sobre la operación',
            'id'=> $id,
            'operacion'=> $operacion,
            'nuevaGestion'=> $nuevaGestion,
            'alertas'=> $alertas,
            'datos_paso1'=> $datos_paso1,
            'porcentajeHonorarios'=> $porcentajeHonorarios,
            'monto_negociado'=> $monto_negociado,
            'cant_cuotas'=> $cant_cuotas,
            'porcentaje_quita'=> $porcentaje_quita,
            'honorarios'=> $honorarios,
            'monto_total'=> $monto_total,
            'monto_cuotas'=> $monto_cuotas,
            'monto_quita'=> $monto_quita,
            'monto_total_a_pagar'=> $monto_total_a_pagar 
        ]);
    }

    public static function actualizar (Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $id=$_GET['id'];
        $deudor = Deudores::find($id);

        if($_SERVER['REQUEST_METHOD']=== 'POST') {
            $deudor->sincronizar($_POST);
            $alertas = $deudor->validarActualizarDeudor();
            if(!$alertas) {
                $resultado=$deudor->guardar();
                if ($resultado) {
                    // Redireccionar al usuario NUNCA ANTES DEL HTML
                    header("Location: /perfil-deudor?id=$id&resultado=2");
                }
            }
        }

        $router->render('cartera/actualizar-deudor', [
            'titulo'=> 'Actualizar Deudor',
            'alertas'=> $alertas,
            'deudor'=> $deudor
        ]);
    }
}
