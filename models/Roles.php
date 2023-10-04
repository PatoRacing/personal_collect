<?php
namespace Model;

use Model\ActiveRecord;

class Roles extends ActiveRecord {
    protected static $tabla = 'roles';
    protected static $columnasDB = ['id', 'rol'];

    public function __construct ($args=[]) {
        $this->id = $args['id'] ?? null;
        $this->rol = $args['rol'] ?? '';
    }
}