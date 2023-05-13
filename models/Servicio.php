<?php
namespace Model;

class Servicio extends ActiveRecord {
    protected static $tabla = "servicios";
    protected static $columnasDB = ["id", "nombre", "precio"];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->precio = $args["precio"] ?? "";
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas["error"][] = "Debes agregar el nombre del servicio";
        } else if (strlen($this->nombre) < 5) {
            self::$alertas["error"][] = "El nombre debe ser mayor a 5 caracteres";
        }

        if(!$this->precio) {
            self::$alertas["error"][] = "Debes agregar el precio del servicio";
        }else if(!is_numeric($this->precio)) {
            self::$alertas["error"][] = "El precio no es valido";
        }

        return self::$alertas;
    }
}