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
        
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inicializar el array de observaciones en la sesión si no existe
        if (!isset($_SESSION['observaciones_entrenador'])) {
            $_SESSION['observaciones_entrenador'] = [];
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $agregarEntrenadorObj = new AgregarEntrenadorModel();
        
        # Obtener todos los entrenadores desde el modelo 
        $entrenadores = $agregarEntrenadorObj->getAll();
        
        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Entrenadores',
            'entrenadores' => $entrenadores
        ];
        
        # Renderizar la vista a traves del metodo de BaseController
        $this->render('agregarEntrenador/agregarEntrenador.php', $data);
    }

    # Muestra el formulario para crear un nuevo entrenador
    public function new()
    {
        $this->render('agregarEntrenador/newEntrenador.php');
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
        
        if ($nombre) {
            $objEntrenador = new AgregarEntrenadorModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones);
            $resp = $objEntrenador->save();
            
            if ($resp) {
                // Si hay observaciones iniciales, guardarlas en la sesión
                if (!empty($observaciones)) {
                    // Obtener el ID del entrenador recién creado
                    $nuevoId = $objEntrenador->getLastInsertId();
                    if ($nuevoId) {
                        // Inicializar el array para este ID si no existe
                        if (!isset($_SESSION['observaciones_entrenador'][$nuevoId])) {
                            $_SESSION['observaciones_entrenador'][$nuevoId] = [];
                        }
                        
                        // Agregar la observación inicial
                        $_SESSION['observaciones_entrenador'][$nuevoId][] = [
                            'texto' => $observaciones,
                            'fecha' => date('Y-m-d H:i:s')
                        ];
                    }
                }
                
                // Éxito al guardar
                header('Location:/agregarEntrenador');
                exit();
            } else {
                // Error al guardar
                echo "Error al guardar el entrenador. Por favor, inténtelo de nuevo.";
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
                'telefonoEmergencia' => $entrenadorInfo[0]->telefonoEmergencia,
                'password' => $entrenadorInfo[0]->password, 
                'observaciones' => $entrenadorInfo[0]->observaciones
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
            $data = [
                'infoReal' => $entrenadorInfo[0]
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
            
            // Si hay observaciones nuevas, agregarlas a la sesión
            if (!empty($observaciones)) {
                // Inicializar el array para este ID si no existe
                if (!isset($_SESSION['observaciones_entrenador'][$id])) {
                    $_SESSION['observaciones_entrenador'][$id] = [];
                }
                
                // Agregar la nueva observación
                $_SESSION['observaciones_entrenador'][$id][] = [
                    'texto' => $observaciones,
                    'fecha' => date('Y-m-d H:i:s')
                ];
            }
            
            $entrenadorObjEdit = new AgregarEntrenadorModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones);
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
            
            $entrenadorObjDelete = new AgregarEntrenadorModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $telefonoEmergencia, $password, $observaciones);
            $res = $entrenadorObjDelete->deleteEntrenador();
            
            if ($res) {
                // Eliminar las observaciones de la sesión para este entrenador
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