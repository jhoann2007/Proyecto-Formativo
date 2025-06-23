<?php
namespace App\Controller;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/calendarioModel.php";

use App\Models\CalendarioModel;
use PDO;
use PDOException;

class CalendarioController extends BaseController
{
    public function __construct()
    {
        $this->layout = 'calendario_layout';
    }

    public function index()
    {
        try {
            $calendarioObj = new CalendarioModel();
            $eventos = $calendarioObj->getEventosCalendario();
            $entrenadores = $calendarioObj->getEntrenadores();

            $data = [
                'title' => 'Calendario',
                'eventos' => $eventos,
                'entrenadores' => $entrenadores
            ];

            $this->render('calendario/calendario.php', $data);
        } catch (PDOException $e) {
            error_log("Error en calendario index: " . $e->getMessage());
            echo "Error al cargar el calendario: " . $e->getMessage();
        }
    }

    public function obtenerEventos()
    {
        // Debug
        error_log("obtenerEventos llamado - Método: " . $_SERVER['REQUEST_METHOD']);
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET');
        header('Access-Control-Allow-Headers: Content-Type');
        
        try {
            $model = new CalendarioModel();
            $eventos = $model->getEventosCalendario();
            
            error_log("Eventos encontrados: " . count($eventos));
            
            // Formatear eventos para FullCalendar
            $eventosFormateados = [];
            foreach ($eventos as $evento) {
                $eventosFormateados[] = [
                    'id' => $evento['id_calendario'],
                    'title' => "Gimnasio - " . $evento['nombre_entrenador'],
                    'start' => $evento['fecha'],
                    'description' => "Horario: {$evento['hora_inicio']} - {$evento['hora_cierre']}<br>
                                    Encargado: {$evento['nombre_entrenador']}<br>
                                    Capacidad: {$evento['capacidad_max']} personas<br>
                                    Estado: " . ucfirst($evento['estado']),
                    'backgroundColor' => $evento['estado'] === 'activo' ? '#28a745' : '#dc3545',
                    'borderColor' => $evento['estado'] === 'activo' ? '#28a745' : '#dc3545',
                    'className' => 'evento-' . $evento['estado']
                ];
            }
            
            echo json_encode($eventosFormateados);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerEventos: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    public function guardarEvento()
    {
        error_log("guardarEvento llamado - Método: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . print_r($_POST, true));
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $_POST;

            // Validar datos requeridos
            if (empty($data["fecha"]) || empty($data["hora_inicio"]) || empty($data["hora_cierre"]) || 
                empty($data["id_encargado"]) || empty($data["capacidad_max"]) || empty($data["estado"])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Todos los campos son requeridos"
                ]);
                exit;
            }

            // Validar que la hora de inicio sea menor que la hora de cierre
            if ($data["hora_inicio"] >= $data["hora_cierre"]) {
                echo json_encode([
                    "status" => "error",
                    "message" => "La hora de inicio debe ser menor que la hora de cierre"
                ]);
                exit;
            }

            try {
                $evento = new CalendarioModel(
                    null,
                    $data["fecha"],
                    $data["hora_inicio"],
                    $data["hora_cierre"],
                    (int)$data["id_encargado"],
                    (int)$data["capacidad_max"],
                    $data["estado"]
                );

                $success = $evento->save();

                echo json_encode([
                    "status" => $success ? "ok" : "error",
                    "message" => $success ? "Horario guardado con éxito" : "No se pudo guardar el horario"
                ]);
                
            } catch (PDOException $e) {
                error_log("Error al guardar evento: " . $e->getMessage());
                echo json_encode([
                    "status" => "error",
                    "message" => "Error interno: " . $e->getMessage()
                ]);
            }
        }
        exit;
    }

    public function obtenerEvento()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha = $_POST["fecha"] ?? '';
            $model = new CalendarioModel();
            $evento = $model->findByDate($fecha);

            if ($evento) {
                echo json_encode(["status" => "ok", "data" => $evento]);
            } else {
                echo json_encode(["status" => "empty"]);
            }
        }
        exit;
    }

    public function eliminarEvento()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? '';
            $model = new CalendarioModel();
            $success = $model->deleteById($id);

            echo json_encode([
                "status" => $success ? "ok" : "error",
                "message" => $success ? "Horario eliminado con éxito" : "No se pudo eliminar el horario"
            ]);
        }
        exit;
    }
}
?>