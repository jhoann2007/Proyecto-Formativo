<?php
namespace App\Controller;
use App\Models\AgregarRolModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarRolModel.php";

class AgregarRolController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'rol_layout';
    }

    public function index()
    {
        # Crear una instancia del modelo
        $rolesObj = new AgregarRolModel();

        # Obtener los centros
        $roles = $rolesObj->getAllRoles();

        $data = [
            'title' => 'Roles',
            'roles' => $roles
        ];
        # Renderizar la vista a traves del metodo de BaseController
        $this->render("agregarRol/agregarRol.php", $data);
    }

    public function create()
    {
        $name = $_POST['txtName'] ?? null;

        if ($name) {
            $rolesObj = new AgregarRolModel(null, $name);
            $response = $rolesObj->save();

            if ($response) {
                # Éxito al guardar
                header('Location:/rol');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el rol. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/rol');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }

    public function view($id_role)
    {
        $rolesObj = new AgregarRolModel($id_role);
        $roleInfo = $rolesObj->getAllRoles();
        if (!empty($roleInfo)) {
            $data = [
                'id_role' => $roleInfo[0]->id_rike,
                'name' => $roleInfo[0]->name
            ];
            $this->render("agregarRol/viewOneRol.php", $data);
        } else {
            echo "Rol no encontrado.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editRole($id_role)
    {
        $rolesObj = new AgregarRolModel($id_role);
        $roleInfo = $rolesObj->getAllRoles();
        if (!empty($roleInfo)) {
            $data = [
                'infoReal' => $roleInfo[0]
            ];
            $this->render("agregarRol/editRol.php", $data);
        } else {
            echo "Rol no encontrado.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }

    # Se edita como tal en la DB
    public function updateRole()
    {
        if (isset($_POST['txtIdRole'])) {
            $id_role = $_POST['txtIdRole'] ?? null;
            $name = $_POST['txtName'] ?? null;

            $objRole = new AgregarRolModel($id_role, $name);
            $response = $objRole->editRole();

            if ($response) {
                header("Location:/rol");
                exit();
            } else {
                echo "Error al actualizar el rol. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/rol');
                exit();
            }
        } else {
            echo "ID de rol no proporcionado.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar

    public function deleteRole($id_role)
    {
        $objRole = new AgregarRolModel($id_role);
        $roleInfo = $objRole->getAllRoles();
        if (!empty($roleInfo)) {
            $data = [
                'infoReal' => $roleInfo[0]
            ];
            $this->render("agregarRol/deleteRol.php", $data);
        } else {
            echo "Rol no encontrado.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }

    # Se elimina de la DB
    public function borrarRole()
    {
        if (isset($_POST['txtIdRole'])) {
            $id_role = $_POST['txtIdRole'] ?? null;
            $name = $_POST['txtName'] ?? null;

            $objRole = new AgregarRolModel($id_role, $name);
            $response = $objRole->deleteRole();

            if ($response) {
                header("Location:/rol");
                exit();
            } else {
                echo "Error al eliminar el rol. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/rol');
                exit();
            }
        } else {
            echo "ID de rol no proporcionado.";
            header('Refresh: 3; URL=/rol');
            exit();
        }
    }
}

?>