<?php
namespace Model;
use Model\ActiveRecord;

class Clientes extends ActiveRecord {
    protected static $tabla = 'clientes';
    protected static $columnasDB = ['id', 'nombre', 'domicilio', 'codigoPostal', 'localidad', 'provincia', 'contacto', 'telefono', 'email', 'usuarios_id', 'ultModificacion'];

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->domicilio = $args['domicilio'] ?? '';
        $this->codigoPostal = $args['codigoPostal'] ?? '';
        $this->localidad = $args['localidad'] ?? '';
        $this->provincia = $args['provincia'] ?? '';
        $this->contacto = $args['contacto'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->usuarios_id = $args['usuarios_id'] ?? '';
        $this->ultModificacion = date ('Y/m/d');
    }

    public function validarCrearCliente() {
        if(!$this->nombre){
            self::$alertas ['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->domicilio){
            self::$alertas ['error'][] = 'El domicilio es obligatorio';
        }
        if(!$this->codigoPostal){
            self::$alertas ['error'][] = 'El código postal es obligatorio';
        }
        if(!$this->localidad){
            self::$alertas ['error'][] = 'La localidad es obligatoria';
        }
        if(!$this->provincia){
            self::$alertas ['error'][] = 'La provincia es obligatoria';
        }
        if(!$this->contacto){
            self::$alertas ['error'][] = 'El contacto es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas ['error'][] = 'El teléfono es obligatorio';
        }
        if(!$this->email){
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }
    
}