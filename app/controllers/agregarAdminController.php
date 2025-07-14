<?php
namespace App\Controller;
use App\Models\AgregarAdminModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarAdminModel.php";

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

        # Inicializar el array de observaciones en la sesión si no existe
        if (!isset($_SESSION['observaciones_admin'])) {
            $_SESSION['observaciones_admin'] = [];
        }
    }

    public function index()
    {
        # Crear una instancia del modelo 
        $agregarAdminObj = new AgregarAdminModel();

        # Obtener solo los administradores (rol 1) desde el modelo
        $admins = $agregarAdminObj->getAdminOnly();

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
            $objAdmin = new AgregarAdminModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
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

    public function view($id)
    {
        $objAdmin = new AgregarAdminModel($id);
        $adminInfo = $objAdmin->getAdmin();
        if(!empty($adminInfo)) {
            $data = [
                'id' => $adminInfo[0]->id,
                'nombre' => $adminInfo[0]->nombre,
                'tipoDocumento' => $adminInfo[0]->tipoDocumento,
                'documento' => $adminInfo[0]->documento,
                'fechaNacimiento' => $adminInfo[0]->fechaNacimiento,
                'email' => $adminInfo[0]->email,
                'genero' => $adminInfo[0]->genero, 
                'estado' => $adminInfo[0]->estado, 
                'telefono' => $adminInfo[0]->telefono, 
                'eps' => $adminInfo[0]->eps,
                'tipoSangre' => $adminInfo[0]->tipoSangre,
                'telefonoEmerjencia' => $adminInfo[0]->telefonoEmerjencia,
                'password' => $adminInfo[0]->password, 
                'observaciones' => $adminInfo[0]->observaciones,
                'fkIdRol' => $adminInfo[0]->fkIdRol
            ];
            $this->render("agregarAdmin/viewOneAdmin.php", $data);
        } else {
            echo "Administrador no encontrado.";
            header('Refresh: 3; URL=/agregarAdmin');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario 
    public function editAdmin($id)
    {
        $objAdmin = new AgregarAdminModel($id);
        $adminInfo = $objAdmin->getAdmin();
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

            $adminObjEdit = new AgregarAdminModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $adminObjEdit->editAdmin();

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
    public function deleteAdmin($id)
    {
        $objAdmin = new AgregarAdminModel($id);
        $adminInfo = $objAdmin->getAdmin();
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

            $adminObjDelete = new AgregarAdminModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $adminObjDelete->deleteAdmin();

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