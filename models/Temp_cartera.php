<?php
namespace Model;
use Model\ActiveRecord;

class Temp_cartera extends ActiveRecord {
    protected static $tabla = 'temp_cartera';
    protected static $columnasDB = ['id', 'segmento', 'producto', 'operacion', 'nombre', 'tipo_doc',
    'nro_doc', 'domicilio', 'localidad', 'codigo_postal', 'telefono', 'fecha_apertura', 'moneda', 'cant_cuotas',
    'sucursal', 'fecha_atraso', 'fecha_castigo', 'deuda_total', 'monto_castigo',
    'deuda_capital', 'deuda_activa', 'fecha_ult_pago', 'estado', 'fecha_asignacion', 'ciclo',
    'acuerdo', 'reingreso_en_tramite', 'demanda_de_terceros', 'concurso', 'quiebra', 'demanda',
    'importe_tasacion', 'cliente_id', 'estados_id', 'operacion_cliente'];

    public function __construct($args=[]) {
        $this->id = $args ['id'] ?? null;
        $this->segmento = $args ['segmento'] ?? '';
        $this->producto = $args ['producto'] ?? '';
        $this->operacion = $args ['operacion'] ?? '';
        $this->nombre = $args ['nombre'] ?? '';
        $this->tipo_doc = $args ['tipo_doc'] ?? '';
        $this->nro_doc = $args ['nro_doc'] ?? '';
        $this->domicilio = $args ['domicilio'] ?? '';
        $this->localidad = $args ['localidad'] ?? '';
        $this->codigo_postal = $args ['codigo_postal'] ?? '';
        $this->telefono = $args ['telefono'] ?? '';
        $this->fecha_apertura = $args ['fecha_apertura'] ?? '';
        $this->moneda = $args ['moneda'] ?? '';
        $this->cant_cuotas = $args ['cant_cuotas'] ?? '';
        $this->sucursal = $args ['sucursal'] ?? '';
        $this->fecha_atraso = $args ['fecha_atraso'] ?? '';
        $this->fecha_castigo = $args ['fecha_castigo'] ?? '';
        $this->deuda_total = $args ['deuda_total'] ?? '';
        $this->monto_castigo = $args ['monto_castigo'] ?? '';
        $this->deuda_capital = $args ['deuda_capital'] ?? '';
        $this->deuda_activa = $args ['deuda_activa'] ?? '';
        $this->fecha_ult_pago = $args ['fecha_ult_pago'] ?? '';
        $this->estado = $args ['estado'] ?? '';
        $this->fecha_asignacion = $args ['fecha_asignacion'] ?? '';
        $this->ciclo = $args ['ciclo'] ?? '';
        $this->acuerdo = $args ['acuerdo'] ?? '';
        $this->reingreso_en_tramite = $args ['reingreso_en_tramite'] ?? '';
        $this->demanda_de_terceros = $args ['demanda_de_terceros'] ?? '';
        $this->concurso = $args ['concurso'] ?? '';
        $this->quiebra = $args ['quiebra'] ?? '';
        $this->demanda = $args ['demanda'] ?? '';
        $this->importe_tasacion = $args ['importe_tasacion'] ?? '';
        $this->cliente_id = $args ['cliente_id'] ?? '';
        $this->estados_id = $args ['estados_id'] ?? '1';
        $this->operacion_cliente = $args ['operacion_cliente'] ?? '1';
    }

    public function sincronizarCartera($args = []) { 
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                // Convertir el valor en un número entero si es cliente_id, de lo contrario, mantenerlo tal como está
                $this->$key = ($key === 'cliente_id') ? intval($value) : $value;
            }
        }
    }
    
    public function validarImportacion() {
        if (!$this->cliente_id) {
            self::$alertas['error'][] = 'Debes seleccionar un cliente';
        }

        if (empty($_FILES['importar']['name'])) {
            self::$alertas['error'][] = 'Debes subir un archivo para importar';
        } else {
            $extensionArchivo = strtolower(pathinfo($_FILES['importar']['name'], PATHINFO_EXTENSION));
            $extensionPermitida = ['xls', 'xlsx'];
            
            if (!in_array($extensionArchivo, $extensionPermitida)) {
                self::$alertas['error'][] = 'Formato de archivo no válido. Solo se permiten archivos .xls y .xlsx';
            }
        }
        
        return self::$alertas;
    }
    
    public static function obtenerClienteIdPorOperacionCliente($operacion_cliente) {
        $query = "SELECT cliente_id FROM temp_cartera WHERE operacion_cliente = ?";
        $params = [$operacion_cliente];
    
        $resultado = self::consultarSQL($query, $params);
    
        if ($resultado && count($resultado) > 0) {
            return $resultado[0]->cliente_id;
        } else {
            return null;
        }
    }
}

