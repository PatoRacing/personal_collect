<?php
namespace Model;
use Model\ActiveRecord;

class Gestiones_deudor extends ActiveRecord {
    protected static $tabla = 'gestiones_deudor';
    protected static $columnasDB = ['id', 'deudor_id', 'usuario_id', 'accion', 'resultado', 'fecha', 'observaciones', 'campaña_mail'];

    public function __construct ($args= []) {
        $this->id = $args['id'] ?? null;
        $this->deudor_id = $args['deudor_id'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->accion = $args['accion'] ?? '';
        $this->resultado = $args['resultado'] ?? '';
        $this->fecha = date ('Y/m/d');
        $this->observaciones = $args['observaciones'] ?? '';
        $this->campaña_mail = $args['campaña_mail'] ?? '';
    }

    //Validar nueva gestion deudor
    public function validarGestionDeudor() {
        if(!$this->accion){
            self::$alertas ['error'][] = 'Debes indicar la acción realizada';
        }
        if(!$this->resultado){
            self::$alertas ['error'][] = 'Debes indicar el resultado de la gestión';
        }
        if(!$this->campaña_mail){
            self::$alertas ['error'][] = 'Debes indicar si deseas activar una campaña de mail';
        }
        if(!$this->observaciones){
            self::$alertas ['error'][] = 'Debes agregar un comentario sobre la gestión';
        } elseif (strlen($this->observaciones) >150 ) {
            self::$alertas['error'][] = 'Las observaciones no pueden superar los 150 caracteres.';
        }
        return self::$alertas;
    }
}