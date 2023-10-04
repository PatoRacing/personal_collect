<?php
namespace Model;
use Model\ActiveRecord;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'dni', 'nombre', 'apellido', 'telefono', 'email', 'domicilio', 'localidad', 'codigoPostal', 'fechaIngreso', 'roles_id', 'estados_id', 'password', 'password', 'token'];

    public function __construct($args = []) 
    {
        $this->id = $args ['id'] ?? null;
        $this->dni = $args ['dni'] ?? '';
        $this->nombre = $args ['nombre'] ?? '';
        $this->apellido = $args ['apellido'] ?? '';
        $this->telefono = $args ['telefono'] ?? '';
        $this->email = $args ['email'] ?? '';
        $this->domicilio = $args ['domicilio'] ?? '';
        $this->localidad = $args ['localidad'] ?? '';
        $this->codigoPostal = $args ['codigoPostal'] ?? '';
        $this->fechaIngreso = $args ['fechaIngreso'] ?? '';
        $this->roles_id = $args ['roles_id'] ?? '';
        $this->estados_id = $args ['estados_id'] ?? '1';
        $this->password = $args ['password'] ?? '';
        $this->password2 = $args ['password2'] ?? '';
        $this->token = $args ['token'] ?? '';
    }

    //Validar el login de usuario
    public function validarLogin() {
        if(!$this->email){
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        
        if(!$this->password){
            self::$alertas ['error'][] = 'Debes agregar un password';
        }
        return self::$alertas;
    }

    //Crear un nuevo usuario
    public function validarCrearUsuario () {
        if(!$this->nombre){
            self::$alertas ['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas ['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->dni){
            self::$alertas ['error'][] = 'El DNI es obligatorio';
        }
        if(!$this->roles_id){
            self::$alertas ['error'][] = 'Debes seleccionar un rol';
        }
        if(!$this->telefono){
            self::$alertas ['error'][] = 'El telefono es obligatorio';
        }
        if(!$this->email){
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        if(!$this->domicilio){
            self::$alertas ['error'][] = 'El domicilio es obligatorio';
        }
        if(!$this->localidad){
            self::$alertas ['error'][] = 'La localidad es obligatoria';
        }
        if(!$this->codigoPostal){
            self::$alertas ['error'][] = 'El código Postal es obligatorio';
        }
        if(!$this->fechaIngreso){
            self::$alertas ['error'][] = 'Debes indicar la fecha de ingreso a Personal Collect';
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{6,}$/', $this->password)) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos una letra mayúscula y un carácter especial, y tener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }
        return self::$alertas;  
    }

    //Hasshear el Password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Crear token
    public function crearToken() {
        $this->token =uniqid();
    }

    //Validaciones editar usuario
    public function validarEditarUsuario () {
        if(!$this->nombre){
            self::$alertas ['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas ['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->dni){
            self::$alertas ['error'][] = 'El DNI es obligatorio';
        }
        if(!$this->roles_id){
            self::$alertas ['error'][] = 'El Rol es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas ['error'][] = 'El telefono es obligatorio';
        }
        if(!$this->email){
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        if(!$this->domicilio){
            self::$alertas ['error'][] = 'El domicilio es obligatorio';
        }
        if(!$this->localidad){
            self::$alertas ['error'][] = 'La localidad es obligatoria';
        }
        if(!$this->codigoPostal){
            self::$alertas ['error'][] = 'El código Postal es obligatorio';
        }
        return self::$alertas;  
    }

    //Validar email en olvide Password
    public function validarEmail() {
        if(!$this->email){
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    //Validar password  en reestablecer Password
    public function validarPassword() {
        if(!$this->password){
            self::$alertas ['error'][] = 'El password es obligatorio';
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{6,}$/', $this->password)) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos una letra mayúscula y un carácter especial, y tener al menos 6 caracteres';
        }
        return self::$alertas;
    }
}