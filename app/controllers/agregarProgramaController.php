<?php
namespace App\Controller;
use App\Models\AgregarProgramaModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarProgramaModel.php";

class AgregarProgramaController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'programa_layout';
    }

    public function index()
    {
        $objProgram = new AgregarProgramaModel();

        # Programas de formación
        $programs = $objProgram->getAllPrograms();

        # Centros de formación
        $centers = $objProgram->getCenters();

        $data = [
            'title' => 'Programas de formacion',
            'programs' => $programs,
            'centers' => $centers
        ];
        # Se renderiza la vista a traves del metodo de base controller
        $this->render("programa/programa.php", $data);
    }

    public function create()
    {
        $token_number = $_POST['txtTokenNumber'] ?? null;
        $name = $_POST['txtName'] ?? null;
        $id_trainingcenter = $_POST['txtIdTrainingCenter'] ?? null;

        if ($token_number) {
            $objProgram = new AgregarProgramaModel(null, $token_number, $name, $id_trainingcenter);
            $response = $objProgram->save();

            if ($response) {
                # Éxito al guardar
                header('Location:/programa');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el programa. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/programa');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }

    public function view($id_trainingprogram)
    {
        $objProgram = new AgregarProgramaModel($id_trainingprogram);
        $programInfo = $objProgram->getAllPrograms();
        if (!empty($programInfo)) {
            $data = [
                'id_trainingprogram' => $programInfo[0]->id_trainingprogram,
                'token_number' => $programInfo[0]->token_number,
                'name' => $programInfo[0]->name,
                'id_trainingcenter' => $programInfo[0]->id_trainingcenter
            ];
            $this->render("programa/viewOnePrograma.php", $data);
        } else {
            echo "Programa no encontrado.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editProgram($id_trainingprogram)
    {
        $objProgram = new AgregarProgramaModel($id_trainingprogram);
        $programInfo = $objProgram->getAllPrograms();
        if (!empty($programInfo)) {
            $data = [
                'infoReal' => $programInfo[0],
            ];
            $this->render("programa/editPrograma.php", $data);
        } else {
            echo "Programa no encontrado.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }

    # Se edita como tal en la DB
    public function updateProgram()
    {
        if (isset($_POST['txtIdTrainingProgram'])) {
            $id_trainingprogram = $_POST['txtIdTrainingProgram'] ?? null;
            $token_number = $_POST['txtTokenNumber'] ?? null;
            $name = $_POST['txtName'] ?? null;
            $id_trainingcenter = $_POST['txtIdTrainingCenter'] ?? null;

            $programObjEdit = new AgregarProgramaModel($id_trainingprogram, $token_number, $name, $id_trainingcenter);
            $response = $programObjEdit->editProgram();

            if ($response) {
                header('Location:/programa');
                exit();
            } else {
                echo "Error al actualizar el programa. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/programa');
                exit();
            }
        } else {
            echo "ID de programa no proporcionado.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }

    # Mostrar lo que se quiere eliminar
    public function deleteProgram($id_trainingprogram)
    {
        $objProgram = new AgregarProgramaModel($id_trainingprogram);
        $programInfo = $objProgram->getAllPrograms();
        if (!empty($programInfo)) {
            $data = [
                'infoReal' => $programInfo[0],
            ];
            $this->render("programa/deletePrograma.php", $data);
        } else {
            echo "Programa no encontrado.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }

    # Se elimina de la DB
    public function borrarProgram()
    {
        if (isset($_POST['txtIdTrainingProgram'])) {
            $id_trainingprogram = $_POST['txtIdTrainingProgram'] ?? null;
            $token_number = $_POST['txtTokenNumber'] ?? null;
            $name = $_POST['txtName'] ?? null;
            $id_trainingcenter = $_POST['txtIdTrainingCenter'] ?? null;

            $programObjEdit = new AgregarProgramaModel($id_trainingprogram, $token_number, $name, $id_trainingcenter);
            $response = $programObjEdit->deleteProgram();

            if ($response) {
                header('Location:/programa');
                exit();
            } else {
                echo "Error al eliminar el programa. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/programa');
                exit();
            }
        } else {
            echo "ID de programa no proporcionado.";
            header('Refresh: 3; URL=/programa');
            exit();
        }
    }
}
?>