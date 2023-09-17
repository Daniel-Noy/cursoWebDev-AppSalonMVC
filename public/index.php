<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar sesion
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);

$router->get("/cuenta/logout", [LoginController::class, "logout"]);

// Recuperar contraseña //? Confirmación deshabilitada para la demostración
$router->get("/cuenta/password/olvide", [LoginController::class, "olvide"]);
// $router->post("/cuenta/password/olvide", [LoginController::class, "olvide"]);

// $router->get("/cuenta/password/reset", [LoginController::class, "resetPass"]);
// $router->post("/cuenta/password/reset", [LoginController::class, "resetPass"]);

// Crear cuenta
$router->get("/cuenta/crear", [LoginController::class, "crear"]);
$router->post("/cuenta/crear", [LoginController::class, "crear"]);

$router->get("/cuenta/confirmar/enviado", [LoginController::class, "mensaje"]);
$router->get("/cuenta/confirmar", [LoginController::class, "confirmado"]);

// Clientes (Privado: Debe tener cuenta para ingresar)
$router->get("/citas/agendar", [CitaController::class, "index"]);


// Admin (Privado: Solo admins)
$router->get("/admin", [AdminController::class, "index"]);
// Crud Servicios (Privado: Solo admins)
$router->get("/admin/servicios", [ServicioController::class, "index"]);

$router->get("/admin/servicios/crear", [ServicioController::class, "crear"]);
$router->post("/admin/servicios/crear", [ServicioController::class, "crear"]);

$router->get("/admin/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router->post("/admin/servicios/actualizar", [ServicioController::class, "actualizar"]);

$router->post("/admin/servicios/eliminar", [ServicioController::class, "eliminar"]);

// API Citas
$router->get("/api/servicios", [ApiController::class, "obtenerServicios"]);
$router->post("/api/citas", [ApiController::class, "obtenerCitas"]);
$router->post("/api/citas/guardar", [ApiController::class, "guardarCita"]);
$router->post("/api/citas/eliminar", [ApiController::class, "eliminarCita"]);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();