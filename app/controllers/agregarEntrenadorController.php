<?php 
namespace App\Controller;
use App\Models\AgregarUsuarioModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarUsuarioModel.php";

class AgregarEntrenadorController extends BaseController 
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'agregarEntrenador_layout';

        # Iniciar sesiín si no está inciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        # Inicializar el array de observaciones en la sesión si no existe
        if (!isset($_SESSION['observaciones_entrenador'])) {
            $_SESSION['observaciones_entrenador'] = [];
        }
    }

    public function index()
    {
        # Crear una instancia del modelo 
        $agregarEntrenadorObj = new AgregarUsuarioModel();

        # Obtener solo los entrenadores (rol 2) desde el modelo
        $entrenadores = $agregarEntrenadorObj->getEntrenadoresOnly();

        # Obtener roles
        $roles = $agregarEntrenadorObj->getRoles();

        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Entrenadores',
            'entrenadores' => $entrenadores,
            'roles' => $roles
        ];

        # Renderizar la vista a través del método de BaseController
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
        $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
        $password = $_POST['txtPassword'] ?? null;
        $observaciones = $_POST['txtObservaciones'] ?? null;
        $fkIdRol = $_POST['txtFKidRol'] ?? null;

        if($nombre) {
            $objEntrenador = new AgregarUsuarioModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, null, null);
            $respuesta = $objEntrenador->save();

            if($respuesta) {
                # Si hay observaciones inciales, guardalas en la sesión 
                if(!empty($observaciones)) {
                    # Obtener el ID del entrenador recién creado
                    $nuevoId = $objEntrenador->getLastInsertId();
                    if ($nuevoId) {
                        # Inicializar el array para este ID si no existe
                        if (!isset($_SESSION['observaciones_entrenador'][$nuevoId])) {
                            $_SESSION['observaciones_entrenador'][$nuevoId] = [];
                        }

                        # Agregar la observación inicial
                        $_SESSION['observaciones_entrenador'][$nuevoId][] = [
                            'texto' => $observaciones,
                            'fecha' => date('Y-m-d H:i:s')
                        ];
                    }
                }

                # Éxito al guardar
                header('Location:/agregarEntrenador');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el entrenador. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    public function view($id_user)
    {
        $objEntrenador = new AgregarUsuarioModel($id_user);
        $entrenadorInfo = $objEntrenador->getUser();
        if(!empty($entrenadorInfo)) {
            $data = [
                'id_user' => $entrenadorInfo[0]->id_user,
                'name' => $entrenadorInfo[0]->name,
                'document_type' => $entrenadorInfo[0]->document_type,
                'document' => $entrenadorInfo[0]->document,
                'birthdate' => $entrenadorInfo[0]->birthdate,
                'email' => $entrenadorInfo[0]->email,
                'gender' => $entrenadorInfo[0]->gender, 
                'status' => $entrenadorInfo[0]->status, 
                'phone' => $entrenadorInfo[0]->phone, 
                'eps' => $entrenadorInfo[0]->eps,
                'blood_type' => $entrenadorInfo[0]->blood_type,
                'emergency_phone' => $entrenadorInfo[0]->emergency_phone,
                'password' => $entrenadorInfo[0]->password, 
                'observations' => $entrenadorInfo[0]->observations,
                'id_role' => $entrenadorInfo[0]->id_role
            ];
            $this->render("agregarEntrenador/viewOneEntrenador.php", $data);
        } else {
            echo "Entrenador no encontrado.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario 
    public function editEntrenador($id_user)
    {
        $objEntrenador = new AgregarUsuarioModel($id_user);
        $entrenadorInfo = $objEntrenador->getUser();
        if (!empty($entrenadorInfo)) {
            # Obtener roles
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
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;

            # Si hay observaciones nuevas, agregarlas a la sesión 
            if (!empty($observaciones)) {
                # Inicializar el array para este Id si no existe
                if (!isset($_SESSION['observaciones_entrenador'][$id])) {
                    $_SESSION['observaciones_entrenador'][$id] = [];
                }

                # Agregar la nueva observación 
                $_SESSION['observaciones_entrenador'][$id][] = [
                    'texto' => $observaciones,
                    'fecha' => date('Y-m-d H:i:s')
                ];
            }

            $entrenadorObjEdit = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $entrenadorObjEdit->editUser();

            if ($respuesta) {
                header("Location:/agregarEntrenador");
                exit();
            } else {
                echo "Error al actualizar el entrenador. Por favor. Inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            echo "ID de entrenador no proporcionado";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar 
    public function deleteEntrenador($id_user)
    {
        $objEntrenador = new AgregarUsuarioModel($id_user);
        $entrenadorInfo = $objEntrenador->getUser();
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
            $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
            $password = $_POST['txtPassword'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fkIdRol = $_POST['txtFKidRol'] ?? null;

            $entrenadorObjDelete = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, null, null, $telefonoEmerjencia, $password, $observaciones, $fkIdRol);
            $respuesta = $entrenadorObjDelete->deleteUser();

            if ($respuesta) {
                # Eliminar las observaciones de la sesión para este entrenador
                if (isset($_SESSION['observaciones_entrenador'][$id])) {
                    unset($_SESSION['observaciones_entrenador'][$id]);
                }

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

    # Método para agregar observaciones (usando sesiones)

    public function agregarObservacion()
    {
        if (isset($_POST['txtId']) && isset($_POST['nuevaObservacion'])) {
            $id = $_POST['txtId'] ?? null;
            $nuevaObservacion = trim($_POST['nuevaObservacion']) ?? '';
            
            if ($id && $nuevaObservacion) {
                // Inicializar el array para este ID si no existe
                if (!isset($_SESSION['observaciones_entrenador'][$id])) {
                    $_SESSION['observaciones_entrenador'][$id] = [];
                }
                
                // Agregar la nueva observación con fecha
                $_SESSION['observaciones_entrenador'][$id][] = [
                    'texto' => $nuevaObservacion,
                    'fecha' => date('Y-m-d H:i:s')
                ];
                
                // Redirigir de vuelta a la lista
                header("Location:/agregarEntrenador");
                exit();
            } else {
                echo "Datos incompletos para agregar observación.";
                header('Refresh: 3; URL=/agregarEntrenador');
                exit();
            }
        } else {
            echo "Datos incompletos para agregar observación.";
            header('Refresh: 3; URL=/agregarEntrenador');
            exit();
        }
    }
}

?>