<?php
namespace App\Controller;
use App\Models\AgregarUsuarioModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarUsuarioModel.php";

class agregarUsuarioController extends BaseController 
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'usuario_layout';

        # Iniciar sesión sino está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $agregarUsuarioObj = new AgregarUsuarioModel();

        # Obtener los usuarios 
        $usuarios = $agregarUsuarioObj->getAllUsers();

        # Obtener roles
        $roles = $agregarUsuarioObj->getRoles();

        # Pasar los datos a la vista
        $data = [
            'title' => 'Lista de Usuarios',
            'usuarios' => $usuarios,
            'roles' => $roles,
        ];
        # Renderizar la vista con los datos
        $this->render('usuario/usuario.php', $data);
    }

    # Guardar los datos del formulario 
    public function create()
    {
        $name = $_POST['txtNombre'] ?? null;
        $document_type = $_POST['txtTipoDocumento'] ?? null;
        $document = $_POST['txtDocumento'] ?? null;
        $birthdate = $_POST['txtFechaNacimiento'] ?? null;
        $email = $_POST['txtEmail'] ?? null;
        $gender = $_POST['txtGenero'] ?? null;
        $status = $_POST['txtEstado'] ?? null;
        $phone = $_POST['txtTelefono'] ?? null;
        $eps = $_POST['txtEps'] ?? null;
        $blood_type = $_POST['txtTipoSangre'] ?? null;
        $weight = $_POST['txtPeso'] ?? null;
        $stature = $_POST['txtEstatura'] ?? null;
        $emergency_phone = $_POST['txtTelefonoEmergencia'] ?? null;
        $password = $_POST['txtPassword'] ?? null;
        $observations = $_POST['txtObservaciones'] ?? null;
        $id_role = $_POST['txtFKidRol'] ?? null;
        $id_group = $_POST['txtFKidGrupo'] ?? null;
        $id_trainingcenter = $_POST['txtFKidCentroFormacion'] ?? null;

        if ($name) {
            $objAprendiz = new AgregarUsuarioModel(null, $name, $document_type, $document, $birthdate, $email, $gender, $status, $phone, $eps, $blood_type, $weight, $stature, $emergency_phone, $password, $observations, $id_role, $id_group, $id_trainingcenter);
            $resp = $objAprendiz->save();
            if ($resp) {
                # Éxito al guardar
                header('Location:/usuario');
                exit();
            } else {
                echo "Error al guardar el usuario. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/usuario');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header("Refresh: 3; URL=/usuario");
            exit();
        }
    }

    public function view($id_user)
    {
        $objUsuario = new AgregarUsuarioModel($id_user);
        $userInfo = $objUsuario->getUser();

        if (!empty($userInfo)) {
            $data = [
                'id_user' => $userInfo[0]->id_user,
                'name' => $userInfo[0]->name,
                'document_type' => $userInfo[0]->document_type,
                'document' => $userInfo[0]->document,
                'birthdate' => $userInfo[0]->birthdate,
                'email' => $userInfo[0]->email,
                'gender' => $userInfo[0]->gender, 
                'status' => $userInfo[0]->status, 
                'phone' => $userInfo[0]->phone, 
                'eps' => $userInfo[0]->eps,
                'blood_type' => $userInfo[0]->blood_type,
                'weight' => $userInfo[0]->weight, 
                'stature' => $userInfo[0]->stature,
                'emergency_phone' => $userInfo[0]->emergency_phone,
                'password' => $userInfo[0]->password, 
                'observations' => $userInfo[0]->observations,
                'id_role' => $userInfo[0]->id_role,
                'id_group' => $userInfo[0]->id_group,
                'id_trainingcenter' => $userInfo[0]->id_trainingcenter
            ];
            $this->render("usuario/viewOneUsuario.php", $data);
        } else {
            echo "Usuario no encontrado.";
            header('Refresh: 3; URL=/usuario');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editUsuario($id_user)
    {
        $objUsuario = new AgregarUsuarioModel($id_user);
        $userInfo = $objUsuario->getUser();
        if (!empty($userInfo)) {
            # Obtener roles, grupos y centros de formación
            $roles = $objUsuario->getRoles();
            $grupos = $objUsuario->getGrupos();
            $centrosFormacion = $objUsuario->getCentrosFormacion();
            
            $data = [
                'infoReal' => $userInfo[0],
                'roles' => $roles,
                'grupos' => $grupos,
                'centrosFormacion' => $centrosFormacion
            ];
            $this->render("usuario/editUsuario.php", $data);
        } else {
            echo "Usuario no encontrado.";
            header('Refresh: 3; URL=/usuario');
            exit();
        }
    }

    # Se edita como tal en la Base de Datos
    public function updateUsuario()
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
            $peso = $_POST['txtPeso'] ?? null;
            $estatura = $_POST['txtEstatura'] ?? null;
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;
            $fkIdGrupo = $_POST['txtFKidGrupo'] ?? null;
            $fkIdCentroFormacion = $_POST['txtFKidCentroFormacion'] ?? null;
            
            $usuarioObjEdit = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $usuarioObjEdit->editUser();
            
            if ($res) {
                header("Location:/usuario");
                exit();
            } else {
                echo "Error al actualizar el usuario. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/usuario');
                exit();
            }
        } else {
            echo "ID de usuario no proporcionado.";
            header('Refresh: 3; URL=/usuario');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar
    public function deleteUsuario($id_user)
    {
        $objUsuario = new AgregarUsuarioModel($id_user);
        $userInfo = $objUsuario->getUser();
        if (!empty($userInfo)) {
            $data = [
                'infoReal' => $userInfo[0],
            ];
            $this->render("usuario/deleteUsuario.php", $data);
        } else {
            echo "Usuario no encontrado.";
            header('Refresh: 3; URL=/usuario');
            exit();
        }
    }

    # Se elimina de la Base de Datos
    public function borrarUsuario()
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
            $peso = $_POST['txtPeso'] ?? null;
            $estatura = $_POST['txtEstatura'] ?? null;
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;
            $fkIdGrupo = $_POST['txtFKidGrupo'] ?? null;
            $fkIdCentroFormacion = $_POST['txtFKidCentroFormacion'] ?? null;
            
            $usuarioObjDelete = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $usuarioObjDelete->deleteUser();
            
            if ($res) {
                echo "Error al eliminar el usuario. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/usuario');
                exit();
            } 
        } else {
            echo "ID de usuario no proporcionado.";
            header('Refresh: 3; URL=/usuario');
            exit();
        }
    }
}
?>