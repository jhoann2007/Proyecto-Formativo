<?php
namespace App\Controller;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/calendarioModel.php";

use App\Models\CalendarioModel;
use PDOException;

class CalendarioController extends BaseController
{
    public function __construct()
    {
        $this->layout = 'calendario_layout';
    }

    private function getUserRole()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_rol_nombre'] ?? 'aprendiz';
    }

    private function getUserId()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_id'] ?? 1;
    }

    private function checkAuth()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        
        try {
            $calendarioObj = new CalendarioModel();
            $eventos = $calendarioObj->getEventosCalendario();
            $entrenadores = $calendarioObj->getEntrenadores();
            $userRole = $this->getUserRole();
            $userId = $this->getUserId();

            $data = [
                'title' => 'Calendario',
                'eventos' => $eventos,
                'entrenadores' => $entrenadores,
                'userRole' => $userRole,
                'userId' => $userId,
                'userName' => $_SESSION['user_nombre'] ?? 'Usuario'
            ];

            $this->render('calendario/calendario.php', $data);
        } catch (PDOException $e) {
            error_log("Error en calendario index: " . $e->getMessage());
            echo "Error al cargar el calendario: " . $e->getMessage();
        }
    }

    public function obtenerEventos()
    {
        $this->checkAuth();
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET');
        header('Access-Control-Allow-Headers: Content-Type');
        
        try {
            $model = new CalendarioModel();
            $eventos = $model->getEventosCalendario();
            $userRole = $this->getUserRole();
            $userId = $this->getUserId();
            
            $eventosFormateados = [];
            foreach ($eventos as $evento) {
                $fechaInicio = $evento['fecha'] . 'T' . $evento['hora_inicio'];
                $fechaFin = $evento['fecha'] . 'T' . $evento['hora_cierre'];
                
                $eventoFormateado = [
                    'id' => $evento['id_calendar'],
                    'title' => "Gimnasio - " . $evento['nombre_entrenador'],
                    'start' => $fechaInicio,
                    'end' => $fechaFin,
                    'allDay' => false,
                    'description' => "Horario: {$evento['hora_inicio']} - {$evento['hora_cierre']}<br>
                                    Encargado: {$evento['nombre_entrenador']}<br>
                                    Capacidad: {$evento['capacidad_max']} personas<br>
                                    Estado: " . ucfirst($evento['estado']),
                    'backgroundColor' => $evento['estado'] === 'activo' ? '#28a745' : '#dc3545',
                    'borderColor' => $evento['estado'] === 'activo' ? '#28a745' : '#dc3545',
                    'className' => 'evento-' . $evento['estado'],
                    'extendedProps' => [
                        'id_calendar' => $evento['id_calendar'],
                        'fecha' => $evento['fecha'],
                        'hora_inicio' => $evento['hora_inicio'],
                        'hora_cierre' => $evento['hora_cierre'],
                        'encargado' => $evento['nombre_entrenador'],
                        'capacidad_max' => $evento['capacidad_max'],
                        'estado' => $evento['estado'],
                        'userRole' => $userRole
                    ]
                ];

                // Si es admin o entrenador, traer registros de aprendices
                if ($userRole === 'admin' || $userRole === 'entrenador') {
                    $registrosAprendices = $model->getRegistrosAprendicesPorEvento($evento['id_calendar']);
                    $eventoFormateado['extendedProps']['aprendices'] = $registrosAprendices;
                }

                $eventosFormateados[] = $eventoFormateado;
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
        $this->checkAuth();
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $userRole = $this->getUserRole();
        
        if ($userRole === 'aprendiz') {
            echo json_encode([
                "status" => "error",
                "message" => "No tienes permisos para realizar esta acción"
            ]);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $_POST;

            if (empty($data["fecha"]) || empty($data["hora_inicio"]) || empty($data["hora_cierre"]) ||
                empty($data["id_encargado"]) || empty($data["capacidad_max"]) || empty($data["estado"])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Todos los campos son requeridos"
                ]);
                exit;
            }

            if ($data["hora_inicio"] >= $data["hora_cierre"]) {
                echo json_encode([
                    "status" => "error",
                    "message" => "La hora de inicio debe ser menor que la hora de cierre"
                ]);
                exit;
            }

            try {
                $model = new CalendarioModel();
                
                if (!empty($data["id_calendario"])) {
                    $success = $model->updateEvento(
                        (int)$data["id_calendario"],
                        $data["fecha"],
                        $data["hora_inicio"],
                        $data["hora_cierre"],
                        (int)$data["id_encargado"],
                        (int)$data["capacidad_max"],
                        $data["estado"]
                    );
                } else {
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
                }

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

    public function registrarAprendiz()
    {
        $this->checkAuth();
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $userRole = $this->getUserRole();
        $userId = $this->getUserId();
        
        // Solo aprendices pueden usar esta función
        if ($userRole !== 'aprendiz') {
            echo json_encode([
                "status" => "error",
                "message" => "Esta función es solo para aprendices"
            ]);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $_POST;

            // Validar datos requeridos
            if (empty($data["id_calendario"]) || empty($data["hora_entrada"]) || empty($data["hora_salida"]) || empty($data["fecha"])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Todos los campos son requeridos"
                ]);
                exit;
            }

            // Validar que la hora de entrada sea menor que la hora de salida
            if ($data["hora_entrada"] >= $data["hora_salida"]) {
                echo json_encode([
                    "status" => "error",
                    "message" => "La hora de entrada debe ser menor que la hora de salida"
                ]);
                exit;
            }

            // Validar máximo 2 horas
            try {
                $horaEntrada = new \DateTime($data["hora_entrada"]);
                $horaSalida = new \DateTime($data["hora_salida"]);
            } catch (\Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Formato de hora inválido"
                ]);
                exit;
            }

            $diferencia = $horaSalida->diff($horaEntrada);
            $horasTotales = $diferencia->h + ($diferencia->i / 60);

            if ($horasTotales > 2) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Solo puede registrar máximo 2 horas por día"
                ]);
                exit;
            }

            try {
                $model = new CalendarioModel();
                
                // Convertir a enteros
                $userIdInt = (int)$userId;
                $calendarioIdInt = (int)$data["id_calendar"];
                
                // Verificar que el usuario existe usando el método del modelo
                if (!$model->verificarUsuarioExiste($userIdInt)) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Usuario no encontrado o inactivo"
                    ]);
                    exit;
                }
                
                // Verificar que el calendario existe usando el método del modelo
                if (!$model->verificarCalendarioExiste($calendarioIdInt)) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "El horario seleccionado no existe o no está disponible"
                    ]);
                    exit;
                }
                
                // Verificar si ya tiene un registro para este día
                if ($model->verificarRegistroAprendizDia($userIdInt, $data["fecha"])) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Ya tienes un registro para este día"
                    ]);
                    exit;
                }

                // Verificar capacidad (modelo lo hace transaccionalmente cuando registra)
                if (!$model->verificarCapacidadDisponible($calendarioIdInt)) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "No hay cupos disponibles para este horario"
                    ]);
                    exit;
                }

                // Registrar (método transaccional en el modelo)
                $success = $model->registrarAprendiz(
                    $userIdInt,
                    $calendarioIdInt,
                    $data["hora_entrada"],
                    $data["hora_salida"],
                    $data["fecha"]
                );

                echo json_encode([
                    "status" => $success ? "ok" : "error",
                    "message" => $success ? "Registro guardado con éxito" : "No se pudo guardar el registro (posible cupos ocupados o duplicado)"
                ]);
                
            } catch (PDOException $e) {
                error_log("Error al registrar aprendiz (controller): " . $e->getMessage());
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
        $this->checkAuth();
        
        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha = $_POST["fecha"] ?? '';
            $model = new CalendarioModel();
            $evento = $model->findByDate($fecha);

            if ($evento) {
                $userRole = $this->getUserRole();
                if ($userRole === 'admin' || $userRole === 'entrenador') {
                    $evento['aprendices'] = $model->getRegistrosAprendicesPorEvento($evento['id_calendar']);
                }
                echo json_encode(["status" => "ok", "data" => $evento]);
            } else {
                echo json_encode(["status" => "empty"]);
            }
        }
        exit;
    }

    public function obtenerRegistrosAprendiz()
    {
        $this->checkAuth();
        
        header('Content-Type: application/json');
        
        $userId = $this->getUserId();
        $userRole = $this->getUserRole();
        
        if ($userRole !== 'aprendiz') {
            echo json_encode([
                "status" => "error",
                "message" => "Acceso denegado"
            ]);
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fecha = $_POST["fecha"] ?? '';
            $model = new CalendarioModel();
            $registro = $model->getRegistroAprendizPorFecha($userId, $fecha);

            echo json_encode([
                "status" => "ok",
                "data" => $registro
            ]);
        }
        exit;
    }

    public function eliminarEvento()
    {
        $this->checkAuth();
        
        header('Content-Type: application/json');
        
        $userRole = $this->getUserRole();
        
        if ($userRole === 'aprendiz') {
            echo json_encode([
                "status" => "error",
                "message" => "No tienes permisos para realizar esta acción"
            ]);
            exit;
        }
        
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
