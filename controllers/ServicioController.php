<?php
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {
    public static function index(Router $router)
    {
        isAuth(true);
        $servicios = Servicio::all();

        $router->render("/servicios/index", [
            "usuario" => $_SESSION,
            "servicios" => $servicios
        ]);
    }

    public static function crear(Router $router)
    {
        isAuth(true);
        $servicio = new Servicio;
        $alertas = Servicio::getAlertas();
        
        if( $_SERVER["REQUEST_METHOD"] === "POST") {
            $servicio -> sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $res = $servicio->guardar();
                
                if($res) {
                    header("Location: /admin/servicios");
                }
            }
        }

        $router->render("/servicios/crear", [
            "usuario" => $_SESSION,
            "servicio" => $servicio,
            "alertas" => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        isAuth(true);
        $id = $_GET["id"];
        if(!is_numeric($id)) return;

        $servicio = Servicio::find($id);
        $alertas = [];
        
        if( $_SERVER["REQUEST_METHOD"] === "POST") {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if( empty($alertas) ) {
                $res = $servicio->guardar();

                if($res) {
                    header("Location: /admin/servicios");
                }
            }
        }

        $router->render("/servicios/actualizar", [
            "usuario" => $_SESSION,
            "servicio" => $servicio,
            "alertas" => $alertas
        ]);
    }

    public static function eliminar(Router $router)
    {
        isAuth(true);
        if( $_SERVER["REQUEST_METHOD"] === "POST") {
            $servicio = Servicio::find($_POST["id"]);
            $res = $servicio->eliminar();

            if($res) {
                header("Location: /admin/servicios");
            }
        }

        $router->render("/servicios/eliminar", [
            "usuario" => $_SESSION
        ]);
    }
}