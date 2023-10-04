<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query, $params = []) {
        // Preparar la consulta
        $stmt = self::$db->prepare($query);
    
        // Verificar si la preparación fue exitosa
        if ($stmt === false) {
            // Manejo de error
            return false;
        }
    
        // Si hay parámetros, vincularlos
        if (!empty($params)) {
            $types = str_repeat("s", count($params)); // Suponemos que son todos strings
            $stmt->bind_param($types, ...$params);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener los resultados
        $resultado = $stmt->get_result();
    
        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
    
        // Cerrar el statement
        $stmt->close();
    
        // Retornar los resultados
        return $array;
    }
    

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }
    

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id ${orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function seleccionarColumnas($orden = 'DESC') {
        $query = "SELECT id, nro_doc FROM " . static::$tabla . " ORDER BY id ${orden}";
        $resultado = self::consultarSQL($query);
        
        return $resultado;
    }    
    

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${limite} " ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Paginar los registros
    public static function paginar($por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset} " ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = ?";
        
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $valor);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $registro = $resultado->fetch_assoc();
            $stmt->close();
        
            if ($registro) {
                return static::crearObjeto($registro);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    

    //Retornar los registros por un orden

    public static function ordenar($columna, $orden) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${columna}  ${orden}";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    // Busqueda Where con Múltiples Columna 
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " ${key} = '${value}'";
            } else {
                $query .= " ${key} = '${value}' AND ";
            }
        }

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Traer un total de registros

    public static function total ($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($columna) {
            $query .=  " WHERE ${columna} = ${valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado ->fetch_array();
        return array_shift($total);
    }

    public static function obtenerPropuestasConDeudores($columna = '', $valor = '') {
        $query = "SELECT G.*, O.*, D.* FROM `Gestiones_operacion` AS G
                  JOIN `Operaciones` AS O ON G.operacion_id = O.id
                  JOIN `Deudores` AS D ON O.deudor_id = D.id";
        if ($columna && $valor) {
            $query .= " WHERE G.`${columna}` = '${valor}'";
        }
        $resultado = self::$db->query($query);
        
        if ($resultado) {
            $propuestasConDeudores = array();
            while ($fila = $resultado->fetch_assoc()) {
                $propuesta = new \stdClass(); // Crear un objeto vacío para almacenar los datos
                $propuesta->gestion = $fila; // Almacenar los datos de Gestiones_operacion
                $propuesta->operacion = array(
                    'id' => $fila['id'],
                    'deudor_id' => $fila['deudor_id']
                    // Agrega más campos de la tabla 'Operaciones' según sea necesario
                );
                $propuesta->deudor = array(
                    'id' => $fila['deudor_id']
                    // Agrega más campos de la tabla 'Deudores' según sea necesario
                );
                $propuestasConDeudores[] = $propuesta;
            }
            return $propuestasConDeudores;
        } else {
            // Manejo de error en caso de consulta fallida
            return array(); // Devolver un array vacío u otro valor predeterminado
        }
    }
    
    
    
    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Construir la consulta preparada
        $columnas = implode(', ', array_keys($atributos));
        $valoresMarcadores = implode(', ', array_fill(0, count($atributos), '?'));
    
        $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valoresMarcadores)";
    
        // Preparar la consulta
        $stmt = self::$db->prepare($query);
        
    
        // Enlazar los valores a los marcadores
        $tipos = str_repeat('s', count($atributos)); // Supongamos que todos son strings
        $valores = array_values($atributos);
        $stmt->bind_param($tipos, ...$valores);
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }
    
    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Preparar las partes de la consulta SQL
        $valores = [];
        $set = [];
        foreach ($atributos as $key => $value) {
            $set[] = "{$key} = ?";
            $valores[] = $value;
        }
        $valores[] = $this->id;
    
        // Consulta SQL preparada
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $set);
        $query .= " WHERE id = ? LIMIT 1";
    
        // Preparar y ejecutar la consulta preparada
        $stmt = self::$db->prepare($query);
        $types = str_repeat("s", count($valores));
        $stmt->bind_param($types, ...$valores);
        $resultado = $stmt->execute();
        $stmt->close();
    
        return $resultado;
    }

    public function crearGestion() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Verificar el valor de tipo_negociacion
        if ($this->tipo_negociacion === 'Financiacion') {
            // Si es Financiacion, establece los campos porcentaje_quita y monto_quita como vacíos
            $atributos['porcentaje_quita'] = '';
            $atributos['monto_quita'] = '';
            $atributos['monto_total_a_pagar'] = '';
        } elseif ($this->tipo_negociacion === 'Quita') {
            // Si es Quita, establece los campos cant_cuotas y monto_cuotas como vacíos
            $atributos['cant_cuotas'] = '';
            $atributos['monto_cuotas'] = '';
        }
    
        // Construir la consulta preparada
        $columnas = implode(', ', array_keys($atributos));
        $valoresMarcadores = implode(', ', array_fill(0, count($atributos), '?'));
        
    
        $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valoresMarcadores)";
    
        // Preparar la consulta
        $stmt = self::$db->prepare($query);
    
        // Enlazar los valores a los marcadores
        $tipos = ''; // Cadena para los tipos de datos
        $valores = array_values($atributos);
        foreach ($valores as $valor) {
            if (is_int($valor)) {
                $tipos .= 'i'; // Entero
            } elseif (is_float($valor)) {
                $tipos .= 'd'; // Punto flotante
            } else {
                $tipos .= 's'; // Cadena (por defecto)
            }
        }
        $stmt->bind_param($tipos, ...$valores);
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
        if (!$resultado) {
            die('Error SQL: ' . $stmt->error);
        }
    
        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }
    
    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function eliminarTodos() {
        $query = "DELETE FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        return $resultado;
    }
    

    public static function getByClienteId($clienteId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cliente_id = ?";
        
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $clienteId); // Suponemos que el cliente_id es un entero
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $operaciones = [];

            while ($registro = $resultado->fetch_assoc()) {
                $operaciones[] = static::crearObjeto($registro);
            }

            $stmt->close();

            return $operaciones;
        } else {
            return [];
        }
    }

    public static function getByDeudorId($deudorId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE deudor_id = ?";
        
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $deudorId); // Suponemos que el cliente_id es un entero
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $operaciones = [];

            while ($registro = $resultado->fetch_assoc()) {
                $operaciones[] = static::crearObjeto($registro);
            }

            $stmt->close();

            return $operaciones;
        } else {
            return [];
        }
    }

    public static function getByOperacionesId($operacion_id) {
        // Construye la consulta SQL para obtener las gestiones de operaciones
        $query = "SELECT * FROM " . static::$tabla . " WHERE operacion_id IN (" . implode(',', $operacion_id) . ")";
    
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $gestionesOperacion = [];
    
            while ($registro = $resultado->fetch_assoc()) {
                $gestionesOperacion[] = static::crearObjeto($registro);
            }
    
            $stmt->close();
    
            return $gestionesOperacion;
        } else {
            return [];
        }
    }
    

    public static function getByUsuarioId($usuario_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuario_id = ?";
        
        $stmt = self::$db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $usuario_id); // Suponemos que el cliente_id es un entero
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $operaciones = [];

            while ($registro = $resultado->fetch_assoc()) {
                $operaciones[] = static::crearObjeto($registro);
            }

            $stmt->close();

            return $operaciones;
        } else {
            return [];
        }
    }
    
    public static function allTemp($columnas, $orden = 'DESC') {
        // Verificar que $columnas sea un array
        if (!is_array($columnas)) {
            throw new \InvalidArgumentException('$columnas debe ser un array de nombres de columnas');
        }
    
        // Construir la lista de columnas como una cadena
        $columnasStr = implode(', ', $columnas);
    
        // Construir la consulta SQL
        $query = "SELECT {$columnasStr} FROM " . static::$tabla . " ORDER BY id ${orden}";
    
        // Ejecutar la consulta y devolver el resultado
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}

