<?php
namespace App\Controller;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/calendarioModel.php";

use App\Models\CalendarioModel;

class CalendarioController extends BaseController
{
    public function __construct()
    {
        $this->layout = 'calendario_layout';
    }

    public function index()
    {
        $calendarioObj = new CalendarioModel();
        $calendario = $calendarioObj->getAll();

        $data = [
            'title' => 'Calendario',
            'Calendarios' => $calendario
        ];

        $this->render('calendario/calendario.php', $data);
    }

    public function guardarEvento()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $_POST;

            $evento = new CalendarioModel(
                null,
                $data["nombre"] ?? '',
                $data["horasDisponibles"] ?? '',
                $data["entrenadoresAsignados"] ?? '',
                $data["eventos"] ?? '',
                $data["fechaCreacion"] ?? ''
            );

            $success = $evento->save();

            echo json_encode([
                "status" => $success ? "ok" : "error",
                "message" => $success ? "Evento guardado con éxito" : "No se pudo guardar el evento"
            ]);
        }
    }

    public function obtenerEvento()
    {
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
    }
}
?>