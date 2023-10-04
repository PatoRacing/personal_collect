<?php
namespace Controllers;

use MVC\Router;

class AgendaController {
    public static function index (Router $router) {
        session_start();

        $router->render('agenda/index', [
            'titulo'=> 'Agenda'
        ]);
    }
}