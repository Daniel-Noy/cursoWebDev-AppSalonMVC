<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        isAuth(true);

        $router->render("admin/index", [
            "usuario" => $_SESSION,
        ]);
    }
}