<?php
namespace App\Controller;
use App\Models\AgregarCentroModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarCentroModel.php";

class AgregarCentroController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'centro_layout';
    }

    public function index()
    {
        # Crear una instancia del modelo
        $centerObj = new AgregarCentroModel();

        # Obtener los centros
        $centers = $centerObj->getAllCenters();

        $data = [
            'title' => 'Centros de Formación',
            'centers' => $centers
        ];
        # Renderizar la vista a traves del metodo de BaseController
        $this->render("agregarCentro/agregarCentro.php", $data);
    }

    public function create()
    {
        $name = $_POST['txtName'] ?? null;

        if ($name) {
            $centerObj = new AgregarCentroModel(null, $name);
            $response = $centerObj->save();

            if ($response) {
                # Éxito al guardar
                header('Location:/centro');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el centro. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/centro');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }

    public function view($id_trainingcenter)
    {
        $objCenter = new AgregarCentroModel($id_trainingcenter);
        $centerInfo = $objCenter->getAllCenters();
        if (!empty($centerInfo)) {
            $data = [
                'id_trainingcenter' => $centerInfo[0]->id_trainingcenter,
                'name' => $centerInfo[0]->name
            ];
            $this->render("agregarCentro/viewOneCentro.php", $data);
        } else {
            echo "Centro de formación no encontrado.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editCenter($id_trainingcenter)
    {
        $objCenter = new AgregarCentroModel($id_trainingcenter);
        $centerInfo = $objCenter->getAllCenters();
        if (!empty($centerInfo)) {
            $data = [
                'infoReal' => $centerInfo[0]
            ];
            $this->render("agregarCentro/editCentro.php", $data);
        } else {
            echo "Centro de formación no encontrado.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }

    # Se edita como tal en la DB
    public function updateCenter()
    {
        if (isset($_POST['txtIdTrainingCenter'])) {
            $id_trainingcenter = $_POST['txtIdTrainingCenter'] ?? null;
            $name = $_POST['txtName'] ?? null;

            $objCenter = new AgregarCentroModel($id_trainingcenter, $name);
            $response = $objCenter->editCenter();

            if ($response) {
                header("Location:/centro");
                exit();
            } else {
                echo "Error al actualizar el centro de formación. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/centro');
                exit();
            }
        } else {
            echo "ID de centro de formacíon no proporcionado.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar

    public function deleteCenter($id_trainingcenter)
    {
        $objCenter = new AgregarCentroModel($id_trainingcenter);
        $centerInfo = $objCenter->getAllCenters();
        if (!empty($centerInfo)) {
            $data = [
                'infoReal' => $centerInfo[0]
            ];
            $this->render("agregarCentro/deleteCentro.php", $data);
        } else {
            echo "Centro de formación no encontrado.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }

    # Se elimina de la DB
    public function borrarCenter()
    {
        if (isset($_POST['txtIdTrainingCenter'])) {
            $id_trainingcenter = $_POST['txtIdTrainingCenter'] ?? null;
            $name = $_POST['txtName'] ?? null;

            $objCenter = new AgregarCentroModel($id_trainingcenter, $name);
            $response = $objCenter->deleteCenter();

            if ($response) {
                header("Location:/centro");
                exit();
            } else {
                echo "Error al eliminar el centro de formación. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/centro');
                exit();
            }
        } else {
            echo "ID de centro de formacíon no proporcionado.";
            header('Refresh: 3; URL=/centro');
            exit();
        }
    }
}

?>