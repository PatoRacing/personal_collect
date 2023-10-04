<?php
namespace Model;

use Model\ActiveRecord;

class Operaciones extends ActiveRecord {

    protected static $tabla = 'operaciones';
    protected static $columnasDB = ['id', 'segmento', 'producto', 'operacion', 'nro_doc', 'fecha_apertura',
    'moneda', 'cant_cuotas', 'sucursal', 'fecha_atraso', 'fecha_castigo', 'deuda_total', 'monto_castigo',
    'deuda_capital', 'deuda_activa', 'fecha_ult_pago', 'estado', 'fecha_asignacion', 'ciclo', 'acuerdo',
    'reingreso_en_tramite', 'demanda_de_terceros', 'concurso', 'quiebra', 'demanda', 'importe_tasacion',
    'deudor_id', 'cliente_id', 'estados_id', 'operacion_cliente',];

    public function __construct ($args= []) {
        $this->id = $args['id'] ?? null;
        $this->segmento = $args['segmento'] ?? '';
        $this->producto = $args['producto'] ?? '';
        $this->operacion = $args['operacion'] ?? '';
        $this->nro_doc = $args['nro_doc'] ?? '';
        $this->fecha_apertura = $args['fecha_apertura'] ?? '';
        $this->moneda = $args['moneda'] ?? '';
        $this->cant_cuotas = $args['cant_cuotas'] ?? '';
        $this->sucursal = $args['sucursal'] ?? '';
        $this->fecha_atraso = $args['fecha_atraso'] ?? '';
        $this->fecha_castigo = $args['fecha_castigo'] ?? '';
        $this->deuda_total = $args['deuda_total'] ?? '';
        $this->monto_castigo = $args['monto_castigo'] ?? '';
        $this->deuda_capital = $args['deuda_capital'] ?? '';
        $this->deuda_activa = $args['deuda_activa'] ?? '';
        $this->fecha_ult_pago = $args['fecha_ult_pago'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->fecha_asignacion = $args['fecha_asignacion'] ?? '';
        $this->ciclo = $args['ciclo'] ?? '';
        $this->acuerdo = $args['acuerdo'] ?? '';
        $this->reingreso_en_tramite = $args['reingreso_en_tramite'] ?? '';
        $this->demanda_de_terceros = $args['demanda_de_terceros'] ?? '';
        $this->concurso = $args['concurso'] ?? '';
        $this->quiebra = $args['quiebra'] ?? '';
        $this->demanda = $args['demanda'] ?? '';
        $this->importe_tasacion = $args['importe_tasacion'] ?? '';
        $this->deudor_id = $args['deudor_id'] ?? '1';
        $this->cliente_id = $args['cliente_id'] ?? '';
        $this->estados_id = $args['estados_id'] ?? '1';
        $this->operacion_cliente = $args['operacion_cliente'] ?? '1';
    }

    public function validaractualizarEstado($nuevoEstado) {
        if(!$this->situacion){
            self::$alertas ['error'][] = 'Debes indicar el estado de la operacion';
            return self::$alertas;
        }
    }

    public static function buscarPorOperacionCliente($operacion_cliente) {
        $query = "SELECT * FROM operaciones WHERE operacion_cliente = ?";
        $params = [$operacion_cliente];
    
        $resultado = self::consultarSQL($query, $params);
    
        if ($resultado) {
            // Si se encontró una operación, retorna la primera instancia encontrada
            return $resultado[0];
        } else {
            // Si no se encontró ninguna operación, retorna null
            return null;
        }
    }

    public static function whereColumnaValor($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = ?";
        
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $valor);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $registros = [];
    
            while ($registro = $resultado->fetch_assoc()) {
                $registros[] = static::crearObjeto($registro);
            }
    
            $stmt->close();
    
            return $registros;
        } else {
            return null;
        }
    }

    public function actualizarEstado($nuevoEstado) {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Asegúrate de que $nuevoEstado sea seguro para evitar inyección SQL
        $nuevoEstado = self::$db->real_escape_string($nuevoEstado);
    
        // Consulta SQL preparada
        $query = "UPDATE " . static::$tabla . " SET situacion = ? WHERE id = ? LIMIT 1";
    
        // Preparar y ejecutar la consulta preparada
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("si", $nuevoEstado, $this->id);
        $resultado = $stmt->execute();
        $stmt->close();
    
        return $resultado;
    }
    
    
}
