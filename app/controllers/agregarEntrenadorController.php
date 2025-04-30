<?php
namespace App\Controller;
use App\Models\AgregarEntrenadorModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarEntrenadorModel.php";

class AgregarEntrenadorController extends BaseController
{
    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'agregarEntrenador_layout';
    }

    public function index()
    {
        # Crear una instancia del modelo
        $agregarEntrenadorObj = new AgregarEntrenadorModel();
        
        # Obtener todos los entrenadores desde el modelo 
        $entrenadores = $agregarEntrenadorObj->getAll();
        
        # Obtener roles, grupos y centros de formación
        $roles = $agregarEntrenadorObj->getRoles();
        
        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Entrenadores',
            'entrenadores' => $entrenadores,
            'roles' => $roles
        ];
        
        # Renderizar la vista a traves del metodo de BaseController
        $this->render('agregarEntrenador/agregarEntrenador.php', $data);
    }

    # Guarda los datos del formulario
    public function create()
    {
        $nombre = $_POST['txtNombre'] ?? null;
        $tipoDocumento = $_POST['txtTipoDocumento'] ?? null;
        $documento = $_POST['txtDocumento'] ?? null;
        $fechaNacimiento = $_POST['txtFechaNacimiento'] ?? null;
        $email = $_POST['txtEmail'] ?? null;
        $genero = $_POST['txtGenero'] ?? null;
        $estado = $_POST['txtEstado'] ?? null;
        $telefono = $_POST['txtTelefono'] ?? null;
        $eps = $_POST['txtEps'] ?? null;
        $tipoSangre = $_POST['txtTipoSangre'] ?? null;
        $telefonoEmergencia = $_POST['txtTelefonoEmergencia'] ?? null;
        $password = $_POST['txtPassword'] ?? null;
        $observaciones = $_POST['txtObservaciones'] ?? null;
        $fkIdRol = $_POST['txtFKidRol'] ?? null;
        
        if ($nombre) {
            $objEntrenador = new AgregarEntrenadorModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones, $fkIdRol);
            $resp = $objEntrenador->save();
            
            if ($resp) {
                // Éxito al guardar
                header('Location:/agregarEntrenador');
                exit();
            } else {
                // Error al guardar
                echo "Error al guardar el entrnador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            // Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    public function view($id)
    {
        $objEntrenador = new AgregarEntrenadorModel($id);
        $entrenadorInfo = $objEntrenador->getEntrenador();

        if (!empty($entrenadorInfo)) {
            $data = [
                'id' => $entrenadorInfo[0]->id,
                'nombre' => $entrenadorInfo[0]->nombre,
                'tipoDocumento' => $entrenadorInfo[0]->tipoDocumento,
                'documento' => $entrenadorInfo[0]->documento,
                'fechaNacimiento' => $entrenadorInfo[0]->fechaNacimiento,
                'email' => $entrenadorInfo[0]->email,
                'genero' => $entrenadorInfo[0]->genero, 
                'estado' => $entrenadorInfo[0]->estado, 
                'telefono' => $entrenadorInfo[0]->telefono, 
                'eps' => $entrenadorInfo[0]->eps,
                'tipoSangre' => $entrenadorInfo[0]->tipoSangre,
                'telefonoEmergencia' => $entrenadorInfo[0]->telefonoEmerjencia,
                'password' => $entrenadorInfo[0]->password, 
                'observaciones' => $entrenadorInfo[0]->observaciones,
                'fkIdRol' => $entrenadorInfo[0]->fkIdRol
            ];
            $this->render("agregarEntrenador/viewOneEntrenador.php", $data);
        } else {
            echo "Entrenador no encontrado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editEntrenador($id)
    {
        $objEntrenador = new AgregarEntrenadorModel($id);
        $entrenadorInfo = $objEntrenador->getEntrenador();

        if (!empty($entrenadorInfo)) {
            # Obtener roles, grupos y centros de formación
            $roles = $objEntrenador->getRoles();
            
            $data = [
                'infoReal' => $entrenadorInfo[0],
                'roles' => $roles
            ];
            $this->render("agregarEntrenador/editEntrenador.php", $data);
        } else {
            echo "Entrenador no encontrado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Se edita como tal en la Base de Datos
    public function updateEntrenador()
    {
        if (isset($_POST['txtId'])) {
            $id = $_POST['txtId'] ?? null;
            $nombre = $_POST['txtNombre'] ?? null;
            $tipoDocumento = $_POST['txtTipoDocumento'] ?? null;
            $documento = $_POST['txtDocumento'] ?? null;
            $fechaNacimiento = $_POST['txtFechaNacimiento'] ?? null;
            $email = $_POST['txtEmail'] ?? null;
            $genero = $_POST['txtGenero'] ?? null;
            $estado = $_POST['txtEstado'] ?? null;
            $telefono = $_POST['txtTelefono'] ?? null;
            $eps = $_POST['txtEps'] ?? null;
            $tipoSangre = $_POST['txtTipoSangre'] ?? null;
            $telefonoEmergencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;
            
            $entrenadorObjEdit = new AgregarEntrenadorModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones, $fkIdRol);
            $res = $entrenadorObjEdit->editEntrenador();
            
            if ($res) {
                header("Location:/agregarEntrenador");
                exit();
            } else {
                echo "Error al actualizar el entrenador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            echo "ID de entrenador no proporcionado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar
    public function deleteEntrenador($id)
    {
        $objEntrenador = new AgregarEntrenadorModel($id);
        $entrenadorInfo = $objEntrenador->getEntrenador();

        if (!empty($entrenadorInfo)) {
            $data = [
                'infoReal' => $entrenadorInfo[0],
            ];
            $this->render("agregarEntrenador/deleteEntrenador.php", $data);
        } else {
            echo "Entrenador no encontrado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Se elimina de la Base de Datos
    public function borrarEntrenador()
    {
        if (isset($_POST['txtId'])) {
            $id = $_POST['txtId'] ?? null;
            $nombre = $_POST['txtNombre'] ?? null;
            $tipoDocumento = $_POST['txtTipoDocumento'] ?? null;
            $documento = $_POST['txtDocumento'] ?? null;
            $fechaNacimiento = $_POST['txtFechaNacimiento'] ?? null;
            $email = $_POST['txtEmail'] ?? null;
            $genero = $_POST['txtGenero'] ?? null;
            $estado = $_POST['txtEstado'] ?? null;
            $telefono = $_POST['txtTelefono'] ?? null;
            $eps = $_POST['txtEps'] ?? null;
            $tipoSangre = $_POST['txtTipoSangre'] ?? null;
            $telefonoEmergencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;
            
            $entrenadorObjDelete = new AgregarEntrenadorModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones, $fkIdRol);
            $res = $entrenadorObjDelete->deleteEntrenador();
            
            if ($res) {
                header("Location:/agregarEntrenador");
                exit();
            } else {
                echo "Error al eliminar el entrenador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            echo "ID de entrenador no proporcionado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }
}
?>