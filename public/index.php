<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\AgendaController;
use Controllers\CarteraController;
use Controllers\CarteraController2;
use Controllers\ClientesController;
use Controllers\UsuariosController;
use Controllers\PropuestaController;


$router = new Router();

//Zona de acceso
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Reestablecer password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

//Zona Privada Dashboard - Agenda
$router->get('/agenda', [AgendaController::class, 'index']);

//Zona Privada Dashboard - Usuarios
$router->get('/usuarios', [UsuariosController::class, 'index']);
$router->get('/crear-usuario', [UsuariosController::class, 'crear']);
$router->post('/crear-usuario', [UsuariosController::class, 'crear']);
$router->get('/editar-usuario', [UsuariosController::class, 'editar']);
$router->post('/editar-usuario', [UsuariosController::class, 'editar']);
$router->get('/perfil-usuario', [UsuariosController::class, 'perfil']);

//Zona Privada Dashboard - Clientes
$router->get('/clientes', [ClientesController::class, 'index']);
$router->get('/crear-cliente', [ClientesController::class, 'crear']);
$router->post('/crear-cliente', [ClientesController::class, 'crear']);
$router->get('/editar-cliente', [ClientesController::class, 'editar']);
$router->post('/editar-cliente', [ClientesController::class, 'editar']);
$router->get('/perfil-cliente', [ClientesController::class, 'perfil']);
$router->get('/importar-operaciones-cliente', [ClientesController::class, 'importar']);
$router->post('/importar-operaciones-cliente', [ClientesController::class, 'importar']);

//Zona Privada Dashboard - Carteras
$router->get('/cartera', [CarteraController::class, 'index']);
$router->get('/perfil-deudor', [CarteraController::class, 'deudor']);
$router->get('/actualizar-deudor', [CarteraController::class, 'actualizar']);
$router->post('/actualizar-deudor', [CarteraController::class, 'actualizar']);
$router->get('/gestion-deudor', [CarteraController::class, 'gestionDeudor']);
$router->post('/gestion-deudor', [CarteraController::class, 'gestionDeudor']);
$router->get('/gestion-operacion', [CarteraController::class, 'gestionOperacion']);
$router->get('/nueva-gestion-operacion', [CarteraController::class, 'nuevaGestionOperacion']);
$router->post('/nueva-gestion-operacion', [CarteraController::class, 'nuevaGestionOperacion']);

//Zona Privada Dashboard - Carteras
$router->get('/propuestas', [PropuestaController::class, 'index']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();