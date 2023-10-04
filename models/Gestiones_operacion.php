<?php
namespace Model;

use Model\ActiveRecord;
date_default_timezone_set('America/Argentina/Buenos_Aires');

class Gestiones_operacion extends ActiveRecord {
    protected static $tabla = 'gestiones_operacion';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'accion', 'tipo_negociacion', 'monto_negociado',
    'honorarios', 'cant_cuotas', 'monto_cuotas', 'porcentaje_quita', 'monto_quita', 'monto_total_a_pagar',  
    'fecha_sugerida', 'resultado', 'observaciones', 'operacion_id', 'usuario_id'];

    public function __construct ($args= []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = date ('Y/m/d');
        $this->hora = date('H:i:s');
        $this->accion = $args['accion'] ?? '';
        $this->tipo_negociacion = $args['tipo_negociacion'] ?? '';
        $this->monto_negociado = $args['monto_negociado'] ?? '';        
        $this->honorarios = $args['honorarios'] ?? 0;
        $this->cant_cuotas = $args['cant_cuotas'] ?? '';
        $this->monto_cuotas = $args['monto_cuotas'] ?? '';
        $this->porcentaje_quita = $args['porcentaje_quita'] ?? '';
        $this->monto_quita = $args['monto_quita'] ?? '';
        $this->monto_total_a_pagar = $args['monto_total_a_pagar'] ?? '';
        $this->fecha_sugerida = date('Y/m/d', strtotime($this->fecha . ' + 7 days'));
        $this->resultado = $args['resultado'] ?? '';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->operacion_id = $args['operacion_id'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
    }

    public static function buscarPorOperacionGestiones($operacion_id) {
        $query = "SELECT * FROM gestiones_operacion WHERE operacion_id = ?";
        $params = [$operacion_id];
    
        $resultado = self::consultarSQL($query, $params);
        return $resultado;
    }

    public function validarPrimerPaso() {
        if(!$this->monto_negociado || $this->monto_negociado === 0){
            self::$alertas ['error'][] = 'Debes indicar el monto negociado y no puede ser 0';
        }

        if(!$this->cant_cuotas || $this->cant_cuotas === 0){
            self::$alertas ['error'][] = 'Debes indicar el número de cuotas a ofrecer y no puede ser 0';
        }

        if(!$this->porcentaje_quita || $this->porcentaje_quita === 0){
            self::$alertas ['error'][] = 'Debes indicar el % de quita a ofrecer y no puede ser 0';
        }
        
        return self::$alertas;
    }

    public function validarSegundoPaso() {
        if(!$this->accion){
            self::$alertas ['error'][] = 'Debes indicar la acción realizada';
        }

        if(!$this->tipo_negociacion){
            self::$alertas ['error'][] = 'Debes indicar cual fue la opción de negociación';
        }

        if(!$this->resultado){
            self::$alertas ['error'][] = 'Debes indicar el resultado obtenido';
        }
        if(!$this->observaciones){
            self::$alertas ['error'][] = 'Debes agregar un comentario sobre la gestión';
        } elseif (strlen($this->observaciones) >150 ) {
            self::$alertas['error'][] = 'Las observaciones no pueden superar los 150 caracteres.';
        }
        
        return self::$alertas;
    }

    
}