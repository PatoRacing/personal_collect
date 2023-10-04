<?php
namespace Controllers;

use MVC\Router;
use Model\Roles;
use Model\Estados;
use Model\Usuario;
use Model\Gestiones_operacion;
use Model\Gestiones_deudor;

class UsuariosController {
    public static function index (Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $resultado = $_GET['resultado'] ?? null;
        $usuarios = Usuario::all();
        $roles = Roles::all();
        $estados = Estados::all();        

        $router->render('usuarios/usuarios', [
            'titulo'=> 'Usuarios',
            'alertas' => $alertas,
            'resultado'=> $resultado,
            'usuarios'=> $usuarios,
            'roles'=> $roles,
            'estados'=> $estados
        ]);
    }

    public static function crear(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $usuario = new Usuario;
        $roles = Roles::all();
        $estados = Estados::all(); 
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCrearUsuario();
            $existeUsuario = Usuario::where('email', $usuario->email);
            if(empty($alertas)) {
                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hash al password
                    $usuario->hashPassword();
                    //Eliminar el segundo Password
                    unset($usuario->password2);
                    //Crear un nuevo usuario
                    $resultado= $usuario->guardar();
                    

                    if($resultado) {
                        header ('Location: /usuarios?resultado=1'); 
                    }
                }
            }
        }
        
        $router->render('usuarios/crear-usuario', [
            'titulo'=> 'Crear Usuario',
            'alertas' => $alertas,
            'usuario'=> $usuario,
            'roles'=> $roles,
            'estados'=>$estados
        ]);
    }

    public static function editar(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $id=$_GET['id'];
        filter_var($id, FILTER_VALIDATE_INT);
        
        if(!$id) {
            header('Location: /usuarios');
        }
        $usuario = Usuario::find($id);
        $roles = Roles::all();
        $estados = Estados::all(); 
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarEditarUsuario();
            if(!$alertas) {
                $resultado=$usuario->guardar();
                if ($resultado) {
                    // Redireccionar al usuario NUNCA ANTES DEL HTML
                    header('Location: /usuarios?resultado=2');
                }
            }
        }

        $router->render('usuarios/editar-usuario', [
            'titulo'=> 'Editar Usuario',
            'usuario'=> $usuario,
            'roles'=> $roles,
            'alertas'=> $alertas,
            'estados'=>$estados
        ]);
    }

    public static function perfil (Router $router) {
        session_start();
        isAuth();
        $id=$_GET['id'];
        filter_var($id, FILTER_VALIDATE_INT);
        
        if(!$id) {
            header('Location: /usuarios');
        }
        $usuario = Usuario::find($id);
        $fechaIngreso = $usuario->fechaIngreso;
        $roles = Roles::all();
        $fechaFormateada = date('d/m/Y', strtotime($fechaIngreso));
        $gestionesOperaciones = Gestiones_operacion::getByUsuarioId($id);
        $gestionesDeudores = Gestiones_deudor::getByUsuarioId($id);

        $router->render('usuarios/perfil-usuario', [
            'titulo'=> 'Perfil del Usuario',
            'usuario'=>$usuario,
            'roles'=>$roles,
            'gestionesOperaciones'=>$gestionesOperaciones,
            'gestionesDeudores'=>$gestionesDeudores,
            'fechaFormateada'=>$fechaFormateada 
        ]);
    }
}