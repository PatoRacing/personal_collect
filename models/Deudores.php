<?php
namespace Model;
use Model\ActiveRecord;

class Deudores extends ActiveRecord {
    protected static $tabla = 'deudores';
    protected static $columnasDB = ['id', 'nombre', 'tipo_doc', 'nro_doc', 'domicilio', 'localidad', 'codigo_postal', 'telefono', 'email', ];

    public function __construct ($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->tipo_doc = $args['tipo_doc'] ?? '';
        $this->nro_doc = $args['nro_doc'] ?? '';
        $this->domicilio = $args['domicilio'] ?? '';
        $this->localidad = $args['localidad'] ?? '';
        $this->codigo_postal = $args['codigo_postal'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
    }

    public static function existePorNroDoc($nro_doc) {
        global $db; // Asumiendo que $db es tu conexión a la base de datos
    
        // Consulta SQL para verificar si el número de documento existe en la tabla Deudores
        $query = "SELECT COUNT(*) AS total FROM Deudores WHERE nro_doc = '" . $db->escape_string($nro_doc) . "'";
    
        // Ejecutar la consulta
        $result = $db->query($query);
    
        // Verificar si existe algún registro con el número de documento dado
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'] > 0;
        }
    
        return false;
    }

    //Validar actualizar deudor
    public function validarActualizarDeudor() {
        if(!$this->nombre){
            self::$alertas ['error'][] = 'El nombre es obligatorio';
        }
        
        if(!$this->tipo_doc){
            self::$alertas ['error'][] = 'Debes indicar el Tipo de Documento';
        }

        if(!$this->nro_doc){
            self::$alertas ['error'][] = 'El DNI es obligatorio';
        }

        if(!$this->domicilio){
            self::$alertas ['error'][] = 'Debes indicar el domicilio del deudor';
        }

        if(!$this->localidad){
            self::$alertas ['error'][] = 'Debes indicar la localidad del deudor';
        }

        if(!$this->codigo_postal){
            self::$alertas ['error'][] = 'Debes indicar el código postal';
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
