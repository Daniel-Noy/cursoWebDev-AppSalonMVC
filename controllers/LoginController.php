<?php
declare(strict_types=1);

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $auth = new Usuario();
        $alertas = [];
        
        auth();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            
            if(empty($alertas)) {
                $usuario = Usuario::where("email", $auth->email);

                if($usuario) {
                    $comprobar = $usuario->comprobarLogin($auth->password);

                    if($comprobar) {
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;
                        $_SESSION["admin"] = $usuario->admin;

                        if($_SESSION["admin"]) {
                            header("Location: /admin");
                        } else {
                            header("Location: /citas/agendar");
                        }
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/login", [
            "auth" => $auth,
            "alertas" => $alertas
        ]);
    }

    public static function logout() {
        $_SESSION = [];
        header("Location: /");
    }

    public static function crear(Router $router) {
        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)) {
                $res = $usuario->existeUsuario();
                
                if(!$res->num_rows) {
                    // hashear password
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    $res = $usuario->guardar();

                    if($res) {
                        header("Location: /cuenta/confirmar/enviado");
                    }

                } else {
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render("auth/crear-cuenta", [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render("auth/correo-enviado");
    }

    public static function confirmado(Router $router) {
        $alertas = [];

        $token = $_GET["token"];
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)) {
            Usuario::setAlerta("error", "Token invalido");
        } else {
            $usuario->confirmado = "1";
            $usuario->token = NULL;
            $usuario->guardar();
            
            Usuario::setAlerta("exito", "Usuario confirmado correctamente"); 
        }

        $alertas = Usuario::getAlertas();

        $router->render("/auth/correo-confirmado", [
            "alertas" => $alertas 
        ]);
    }

    public static function olvide(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where("email", $auth->email);
                if($usuario && $usuario->confirmado === "1") {

                    $usuario->crearToken();
                    $usuario->guardar();
                    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarRecuperacion();

                    Usuario::setAlerta("exito", "Revisa tu correo");

                } else {
                    Usuario::setAlerta("error", "Usuario no existe o no esta confirmado");
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/olvide-password", [
            "alertas" => $alertas
        ]);
    }

    public static function resetPass(Router $router) {
        $token = $_GET["token"];
        $alertas = [];
        $error = false;

        $usuario = Usuario::where("token", $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta("error", "Token no válido");
            $error = true;
        }
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Usuario($_POST);
            $auth-> validarPassRecovery();            
            $alertas = Usuario::getAlertas();

            if(empty($alertas)){
                $usuario->password = $auth->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $res = $usuario->guardar();

                if($res) {
                    header("Location: /");
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/reset-password", [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }
}