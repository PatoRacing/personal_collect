<?php
namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {
    public static function login (Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            
           
            if(!$alertas) {
                //verificar el que usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if(!$usuario) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } elseif ($usuario->estados_id === 2) {
                    Usuario::setAlerta('error', 'No se permite el acceso para este usuario');
                }
                    else {
                    //El usuario existe
                    if(password_verify($_POST['password'], $usuario->password)) {
                        //Iniciar la sesion
                        session_start();
                        $_SESSION ['id'] = $usuario->id;
                        $_SESSION ['nombre'] = $usuario->nombre;
                        $_SESSION ['apellido'] = $usuario->apellido;
                        $_SESSION ['email'] = $usuario->email;
                        $_SESSION ['login'] = true;

                        //Redireccion
                        header('Location: /agenda');
                        
                    } else {
                        Usuario::setAlerta('error', 'Password incorrecto');
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/login', [
            'titulo'=> 'Iniciar Sesión',
            'alertas'=> $alertas
        ]);
    }

    public static function olvide (Router $router) {
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(!$alertas){
                $usuario = Usuario::where('email', $auth->email);
                if(!$usuario) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } else {
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email para reestablecer tu password');
                }
            }
        }

        $alertas= Usuario::getAlertas();
        $router->render('auth/olvide', [
            'titulo'=> 'Olvide mi password',
            'alertas'=> $alertas
        ]);
    }

    public static function mensaje(Router $router){
        
        $router->render('auth/mensaje', [
            'titulo'=> 'Instrucciones'
        ]);
    }

    public static function reestablecer (Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        //Buscar usuario por token

        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado= $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer', [
            'titulo'=> 'Reestablecer password',
            'alertas'=> $alertas,
            'error'=> $error
        ]);
    }

    public static function logout (Router $router) {
        session_start();
        $_SESSION=[];
        header('Location:/'); 
    }
}