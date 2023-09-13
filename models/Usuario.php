<?php 
namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "apellido", "email", "password", "telefono", "admin", "confirmado", "token"];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->admin = $args["admin"] ?? "0";
        $this->confirmado = $args["confirmado"] ?? "0";
        $this->token = $args["token"] ?? "";
    }

    // Validacion para crear una cuenta
    public function validarNuevaCuenta() {

        if(!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->apellido) {
            self::$alertas["error"][] = "El apellido es obligatorio";
        }
        if(!$this->telefono) {
            self::$alertas["error"][] = "El telefono es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        } else if(strlen($this->password) < 8) {
            self::$alertas["error"][] = "La contraseña debe tener 8 caracteres como minimo";
        }

        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }

        return self::$alertas;
    }

    public function validarPassRecovery() {

        if(!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        } else if(strlen($this->password) < 8) {
            self::$alertas["error"][] = "La contraseña debe tener 8 caracteres como minimo";
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }

        return self::$alertas;
    }

    public function existeUsuario() {
        $query = "SELECT email FROM " . self::$tabla . " WHERE email = '{$this->email}' LIMIT 1";

        $res = self::$db->query($query);

        if($res->num_rows) {
            self::$alertas["error"][] = "El usuario ya existe";
        }

        return $res;
    }

    public function comprobarLogin(string $password) {
        $res = password_verify($password, $this->password);
        
        if(!$res) {
            self::$alertas['error'][] = "Contraseña incorrecta";
        } else {
            //? Confirmación deshabilitada para la demostración
            // if(!$this->confirmado) {
            //     self::$alertas['error'][] = "Tu cuenta aun no ha sido confirmada";
            // } else {
            //     return true;
            // }
            return true;
        }
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }
}