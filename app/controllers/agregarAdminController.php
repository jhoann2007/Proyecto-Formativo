<?php
namespace App\Controller;
use App\Models\AgregarUsuarioModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarUsuarioModel.php";

class agregarAdminController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'agregarAdmin_layout';

        # Iniciar sesiín si no está inciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        # Crear una instancia del modelo 
        $agregarAdminObj = new AgregarUsuarioModel();

        # Obtener solo los administradores (rol 1) desde el modelo
        $admins = $agregarAdminObj->getAdminsOnly();

        # Obtener roles
        $roles = $agregarAdminObj->getRoles();

        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Administradores',
            'admins' => $admins,
            'roles' => $roles
        ];

        # Renderizar la vista a través del método de BaseController
        $this->render('agregarAdmin/agregarAdmin.php', $data);
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
        $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
        $password = $_POST['txtPassword'] ?? null;
        $observaciones = $_POST['txtObservaciones'] ?? null;
        $fkIdRol = $_POST['txtFKidRol'] ?? null;

        if($nombre) {
            $objAdmin = new AgregarUsuarioModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null,  $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $objAdmin->save();

            if($respuesta) {
                # Si hay observaciones inciales, guardalas en la sesión 
                if(!empty($observaciones)) {
                    # Obtener el ID del admin recién creado
                    $nuevoId = $objAdmin->getLastInsertId();
                    if ($nuevoId) {
                        # Inicializar el array para este ID si no existe
                        if (!isset($_SESSION['observaciones_admin'][$nuevoId])) {
                            $_SESSION['observaciones_admin'][$nuevoId] = [];
                        }

                        # Agregar la observación inicial
                        $_SESSION['observaciones_admin'][$nuevoId][] = [
                            'texto' => $observaciones,
                            'fecha' => date('Y-m-d H:i:s')
                        ];
                    }
                }

                # Éxito al guardar
                header('Location:/agregarAdmin');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el administrador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAdmin');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    public function view($id_user)
    {
        $objAdmin = new AgregarUsuarioModel($id_user);
        $adminInfo = $objAdmin->getUser();
        if(!empty($adminInfo)) {
            $data = [
                'id_user' => $adminInfo[0]->id_user,
                'name' => $adminInfo[0]->name,
                'document_type' => $adminInfo[0]->document_type,
                'document' => $adminInfo[0]->document,
                'birthdate' => $adminInfo[0]->birthdate,
                'email' => $adminInfo[0]->email,
                'gender' => $adminInfo[0]->gender, 
                'status' => $adminInfo[0]->status, 
                'phone' => $adminInfo[0]->phone, 
                'eps' => $adminInfo[0]->eps,
                'blood_type' => $adminInfo[0]->blood_type,
                'emergency_phone' => $adminInfo[0]->emergency_phone,
                'password' => $adminInfo[0]->password, 
                'observations' => $adminInfo[0]->observations,
                'id_role' => $adminInfo[0]->id_role
            ];
            $this->render("agregarAdmin/viewOneAdmin.php", $data);
        } else {
            echo "Administrador no encontrado.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario 
    public function editAdmin($id_user)
    {
        $objAdmin = new AgregarUsuarioModel($id_user);
        $adminInfo = $objAdmin->getUser();
        if (!empty($adminInfo)) {
            # Obtener roles
            $roles = $objAdmin->getRoles();

            $data = [
                'infoReal' => $adminInfo[0],
                'roles' => $roles
            ];
            $this->render("agregarAdmin/editAdmin.php", $data);
        } else {
            echo "Administrador no encontrado.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Se edita como tal en la Base de Datos 
    public function updateAdmin()
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
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;

            # Si hay observaciones nuevas, agregarlas a la sesión 
            if (!empty($observaciones)) {
                # Inicializar el array para este Id si no existe
                if (!isset($_SESSION['observaciones_admin'][$id])) {
                    $_SESSION['observaciones_admin'][$id] = [];
                }

                # Agregar la nueva observación 
                $_SESSION['observaciones_admin'][$id][] = [
                    'texto' => $observaciones,
                    'fecha' => date('Y-m-d H:i:s')
                ];
            }

            $adminObjEdit = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $adminObjEdit->editUser();

            if ($respuesta) {
                header("Location:/agregarAdmin");
                exit();
            } else {
                echo "Error al actualizar el administrador. Por favor. Inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAdmin');
                exit();
            }
        } else {
            echo "ID de administrador no proporcionado";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar 
    public function deleteAdmin($id_user)
    {
        $objAdmin = new AgregarUsuarioModel($id_user);
        $adminInfo = $objAdmin->getUser();
        if (!empty($adminInfo)) {
            $data = [
                'infoReal' => $adminInfo[0],
            ];
            $this->render("agregarAdmin/deleteAdmin.php", $data);
        } else {
            echo "Administrador no encontrado.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Se elimina de la Base de Datos
    public function borrarAdmin()
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
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;

            $adminObjDelete = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $adminObjDelete->deleteUser();

            if ($respuesta) {
                # Eliminar las observaciones de la sesión para este administrador
                if (isset($_SESSION['observaciones_admin'][$id])) {
                    unset($_SESSION['observaciones_admin'][$id]);
                }

                header("Location:/agregarAdmin");
                exit();
            } else {
                echo "Error al eliminar el administrador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAdmin');
                exit();
            }
        } else {
            echo "ID de administrador no proporcionado.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Método para agregar observaciones (usando sesiones)

    public function agregarObservacion()
    {
        if (isset($_POST['txtId']) && isset($_POST['nuevaObservacion'])) {
            $id = $_POST['txtId'] ?? null;
            $nuevaObservacion = trim($_POST['nuevaObservacion']) ?? '';
            
            if ($id && $nuevaObservacion) {
                // Inicializar el array para este ID si no existe
                if (!isset($_SESSION['observaciones_admin'][$id])) {
                    $_SESSION['observaciones_admin'][$id] = [];
                }
                
                // Agregar la nueva observación con fecha
                $_SESSION['observaciones_admin'][$id][] = [
                    'texto' => $nuevaObservacion,
                    'fecha' => date('Y-m-d H:i:s')
                ];
                
                // Redirigir de vuelta a la lista
                header("Location:/agregarAdmin");
                exit();
            } else {
                echo "Datos incompletos para agregar observación.";
                header('Refresh: 3; URL=/agregarAdmin');
                exit();
            }
        } else {
            echo "Datos incompletos para agregar observación.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }
}


?>