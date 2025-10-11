<?php
namespace App\Controller;
use App\Models\AgregarGrupoModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarGrupoModel.php";

class AgregarGrupoController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'grupo_layout';

        # Iniciar sesión sino está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $grupoObj = new AgregarGrupoModel();

        # Obtener los grupos
        $grupos = $grupoObj->getAllGroups();

        # Obtener los programas de formacion
        $programas = $grupoObj->getProgramasFormacion();

        # Pasar los datos a la vista
        $data = [
            'title' => 'Lista de Grupos',
            'grupos' => $grupos,
            'programas' => $programas
        ];
        # Renderizar la vista a traves del método de BaseController
        $this->render("agregarGrupo/agregarGrupo.php", $data);
    }

    public function create()
    {
        $token_number = $_POST['txtTokenNumber'] ?? null;
        $number_aprenttices = $_POST['txtAprenttices'] ?? null;
        $status = $_POST['txtStatus'] ?? null;
        $star_date = $_POST['txtStarDate'] ?? null;
        $end_date = $_POST['txtEndDate'] ?? null;
        $id_trainingprogram = $_POST['txtTrainingProgram'] ?? null;

        if ($token_number) {
            $objGrupo = new AgregarGrupoModel(null, $token_number, $number_aprenttices, $status, $star_date, $end_date, $id_trainingprogram);
            $response = $objGrupo->save();

            if ($response) {
                # Éxito al guardar
                header('Location:/grupo');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el grupo. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/grupo');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }

    public function view($id_group)
    {
        $objGrupo = new AgregarGrupoModel($id_group);
        $groupInfo = $objGrupo->getAllGroups();
        if (!empty($groupInfo)) {
            $data = [
                'id_group' => $groupInfo[0]->id_group,
                'token_number' => $groupInfo[0]->token_number,
                'number_aprenttices' => $groupInfo[0]->number_aprenttices,
                'status' => $groupInfo[0]->status,
                'star_date' => $groupInfo[0]->star_date,
                'end_date' => $groupInfo[0]->end_date,
                'id_trainingprogram' => $groupInfo[0]->id_trainingprogram
            ];
            $this->render("agregarGrupo/viewOneGrupo.php", $data);
        } else {
            echo "Grupo no encontrado.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editGroup($id_group)
    {
        $objGroup = new AgregarGrupoModel($id_group);
        $groupInfo = $objGroup->getAllGroups();
        if (!empty($groupInfo)) {
            $data = [
                'infoReal' => $groupInfo[0]
            ];
            $this->render("agregarGrupo/editGrupo.php", $data);
        } else {
            echo "Grupo no encontrado.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }

    # Se edita como tal en la Base de Datos
    public function updateGroup()
    {
        if (isset($_POST['txtIdGroup'])) {
            $id_group = $_POST['txtIdGroup'] ?? null;
            $token_number = $_POST['txtTokenNumber'] ?? null;
            $number_aprenttices = $_POST['txtAprenttices'] ?? null;
            $status = $_POST['txtStatus'] ?? null;
            $star_date = $_POST['txtStarDate'] ?? null;
            $end_date = $_POST['txtEndDate'] ?? null;
            $id_trainingprogram = $_POST['txtTrainingProgram'] ?? null;

            $grupoObjEdit = new AgregarGrupoModel($id_group, $token_number, $number_aprenttices, $status, $star_date, $end_date, $id_trainingprogram);
            $response = $grupoObjEdit->editGroup();

            if ($response) {
                header("Location:/grupo");
                exit();
            } else {
                echo "Error al actualizar el grupo. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/grupo');
                exit();
            }
        } else {
            echo "ID de grupo no proporcionado.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar
    public function deleteGroup($id_group)
    {
        $objGrupo = new AgregarGrupoModel($id_group);
        $groupInfo = $objGrupo->getAllGroups();
        if (!empty($groupInfo)) {
            $data = [
                'infoReal' => $groupInfo[0]
            ];
            $this->render("agregarGrupo/deleteGrupo.php", $data);
        } else {
            echo "Grupo no encontrado.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }

    # Se elimina de la DB
    public function borrarGroup()
    {
        if (isset($_POST['txtIdGroup'])) {
            $id_group = $_POST['txtIdGroup'] ?? null;
            $token_number = $_POST['txtTokenNumber'] ?? null;
            $number_aprenttices = $_POST['txtAprenttices'] ?? null;
            $status = $_POST['txtStatus'] ?? null;
            $star_date = $_POST['txtStarDate'] ?? null;
            $end_date = $_POST['txtEndDate'] ?? null;
            $id_trainingprogram = $_POST['txtTrainingProgram'] ?? null;

            $groupObjDelete = new AgregarGrupoModel($id_group, $token_number, $number_aprenttices, $status, $star_date, $end_date, $id_trainingprogram);
            $response = $groupObjDelete->deleteGroup();

            if ($response) {
                header("Location:/grupo");
                exit();
            } else {
                echo "Error al eliminar el grupo. Por favor, intentelo de nuevo.";
                header('Refresh: 3; URL=/grupo');
                exit();
            }
        } else {
            echo "ID del grupo no proporcionado.";
            header('Refresh: 3; URL=/grupo');
            exit();
        }
    }
}
?>