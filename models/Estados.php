<?php 
namespace Model;
use Model\ActiveRecord;

class Estados extends ActiveRecord {
    protected static $tabla = 'estados';
    protected static $columnasDB = ['id', 'estado'];

    public function __construct ($args=[]) {
        $this->id = $args['id'] ?? null;
        $this->estado = $args['estado'] ?? '';
    }
}