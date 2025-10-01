<?php

namespace App\Controller;

use App\Models\RutinaModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/rutinaModel.php";

class RutinaController extends BaseController
{

    private $rutinaModel;

    public function __construct()
    {
        $this->rutinaModel = new RutinaModel();
        $this->layout = 'rutina_layout';
    }

    public function new()
    {
        $this->layout = 'crearRutina_layout'; // Usa el layout con estilos y header
        $ejercicios = $this->rutinaModel->getAllEjercicios(); // Debes crear este método en el modelo
        $this->render('agregarRutina/crearRutina.php', [
            'ejercicios' => $ejercicios
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['ejercicios']) || !is_array($_POST['ejercicios']) || count($_POST['ejercicios']) === 0) {
                // Puedes redirigir o mostrar un mensaje de error
                header('Location: /agregarRutina');
                exit;
            }

            $nombre = $_POST['nombre'] ?? '';
            $calentamiento = $_POST['calentamiento'] ?? null;
            $rutinaId = $this->rutinaModel->createRutina($nombre, $calentamiento);

            // Guardar los ejercicios asociados
           

            if (isset($_POST['ejercicios']) && is_array($_POST['ejercicios'])) {
                foreach ($_POST['ejercicios'] as $ej) {
                    $idEjercicio = $ej['id'];
                    $series = $ej['series'];
                    $repeticiones = $ej['repeticiones'];
                    $peso = $ej['peso'];
                    $this->rutinaModel->agregarEjercicioARutina($rutinaId, $idEjercicio, $series, $repeticiones, $peso);
                }
            }
            header('Location: /agregarRutina');
            exit;
        }
    }

    public function index()
    {
        $rutinas = $this->rutinaModel->getRutinas();
        $this->render('agregarRutina/rutinaView.php', ['rutinas' => $rutinas]);
    }

    public function verEjercicios($rutinaId)
    {
        $ejercicios = $this->rutinaModel->getEjerciciosRutina($rutinaId);
        $this->render('agregarRutina/ejerciciosRutina.php', [
            'ejercicios' => $ejercicios
        ]);
    }
}

