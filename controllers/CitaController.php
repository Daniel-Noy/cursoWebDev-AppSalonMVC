<?php 
namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router) {
        isAuth();

        $usuario = $_SESSION ?? null;

        $router->render("cita/index", [
            "usuario" => $usuario
        ]);
    }
}