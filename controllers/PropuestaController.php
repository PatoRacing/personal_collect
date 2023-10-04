<?php
namespace Controllers;

use MVC\Router;
use Model\Clientes;
use Model\Deudores;
use Model\Operaciones;
use Model\Gestiones_operacion;

class PropuestaController {
    public static function index (Router $router) {
        session_start();
        isAuth();
        $clientes = Clientes::all();
        $deudores = Deudores::all();
        $propuestas = Gestiones_operacion::obtenerPropuestasConDeudores('resultado', 'Propuesta de Pago');
        
        //debuguear($propuestas);
        
        $router->render('propuestas/propuestas', [
            'titulo'=> 'Propuestas de Pago',
            'propuestas' => $propuestas,
            'clientes' => $clientes,
            'deudores' => $deudores
        ]);
    }
}