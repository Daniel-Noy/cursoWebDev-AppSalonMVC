<?php
namespace Controllers;

use Model\AdminCita;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class ApiController {
    public static function obtenerServicios()
    {
        $servicios = Servicio::all();

        $json = json_encode($servicios);
        echo $json;
    }

    public static function obtenerCitas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = $_POST['fecha'];

            $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
            $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
            $consulta .= " FROM citas  ";
            $consulta .= " LEFT JOIN usuarios ";
            $consulta .= " ON citas.usuarioId=usuarios.id  ";
            $consulta .= " LEFT JOIN citasservicios ";
            $consulta .= " ON citasservicios.citaId=citas.id ";
            $consulta .= " LEFT JOIN servicios ";
            $consulta .= " ON servicios.id=citasservicios.servicioId ";
            $consulta .= " WHERE fecha = '{$fecha}' ";

            $registros = AdminCita::SQL($consulta);
            $citas = [
            ];

            foreach ($registros as $registro) {
                if(!enRegistro($citas, $registro->id)) {
                    $citas[] = [
                        'id' => $registro->id,
                        'hora' => $registro->hora,
                        'cliente' => $registro->cliente,
                        'email' => $registro->email,
                        'telefono' => $registro->telefono,
                        'servicios' => [
                            [
                                'nombre' => $registro->servicio,
                                'precio' => (int) $registro->precio
                            ]
                        ]
                    ];
                } else {
                    $citas = array_map(function($cita) use($registro) {
                        if($cita['id'] === $registro->id) {
                            $cita['servicios'][] = [
                                'nombre' => $registro->servicio,
                                'precio' => (int) $registro->precio
                            ];
                            return $cita;
                        }
                        return $cita;
                    }, $citas);
                }
            }

            echo json_encode([
                'res' => true,
                'body' => $citas
            ]); 
            return;
        }
    }

    public static function guardarCita()
    {
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los Servicios con el ID de la Cita
        $idServicios = explode(",", $_POST['servicios']);
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminarCita()
    {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            
            $cita = Cita::find($id);
            $res = $cita->eliminar();

            if ($res) {
                echo json_encode(['res' => true]); 
                return;
            } else {
                echo json_encode(['res' => false]);
                return;
            }

        }
    }
}