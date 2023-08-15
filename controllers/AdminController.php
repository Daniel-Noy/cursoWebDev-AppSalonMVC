<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        isAuth(true);
        $fecha = $_GET["fecha"] ?? date("Y-m-d");
        $fechaGet = explode("-", $fecha);

        if( !checkdate($fechaGet[1], $fechaGet[2], $fechaGet[0]) ) {
            header("Location: /404");
        }


        // Consultar DB
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render("admin/index", [
            "usuario" => $_SESSION,
            "citas" => $citas,
            "idCita" => 0,
            "fecha" => $fecha
        ]);
    }
}