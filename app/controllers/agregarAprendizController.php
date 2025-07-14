<?php

namespace App\Controller;

use App\Models\AgregarAprendizModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarAprendizModel.php";

class AgregarAprendizController extends BaseController
{
    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'agregarAprendiz_layout';
        
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inicializar el array de observaciones en la sesión si no existe
        if (!isset($_SESSION['observaciones_aprendiz'])) {
            $_SESSION['observaciones_aprendiz'] = [];
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $agregarAprendizObj = new AgregarAprendizModel();
        
        # Obtener solo los aprendices (rol 3) desde el modelo 
        $aprendices = $agregarAprendizObj->getAprendicesOnly();
        
        # Obtener roles, grupos y centros de formación
        $roles = $agregarAprendizObj->getRoles();
        $grupos = $agregarAprendizObj->getGrupos();
        $centrosFormacion = $agregarAprendizObj->getCentrosFormacion();
        
        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Aprendices',
            'aprendices' => $aprendices,
            'roles' => $roles,
            'grupos' => $grupos,
            'centrosFormacion' => $centrosFormacion
        ];
        
        # Renderizar la vista a traves del metodo de BaseController
        $this->render('agregarAprendiz/agregarAprendiz.php', $data);
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
        $peso = $_POST['txtPeso'] ?? null;
        $estatura = $_POST['txtEstatura'] ?? null;
        $telefonoEmerjencia = $_POST['txtTelefonoEmergencia'] ?? null;
        $password = $_POST['txtPassword'] ?? null;
        $observaciones = $_POST['txtObservaciones'] ?? null;
        $fkIdRol = $_POST['txtFKidRol'] ?? null;
        $fkIdGrupo = $_POST['txtFKidGrupo'] ?? null;
        $fkIdCentroFormacion = $_POST['txtFKidCentroFormacion'] ?? null;
        
        if ($nombre) {
            $objAprendiz = new AgregarAprendizModel(null, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $resp = $objAprendiz->save();
            
            if ($resp) {
                // Si hay observaciones iniciales, guardarlas en la sesión
                if (!empty($observaciones)) {
                    // Obtener el ID del aprendiz recién creado
                    $nuevoId = $objAprendiz->getLastInsertId();
                    if ($nuevoId) {
                        // Inicializar el array para este ID si no existe
                        if (!isset($_SESSION['observaciones_aprendiz'][$nuevoId])) {
                            $_SESSION['observaciones_aprendiz'][$nuevoId] = [];
                        }
                        
                        // Agregar la observación inicial
                        $_SESSION['observaciones_aprendiz'][$nuevoId][] = [
                            'texto' => $observaciones,
                            'fecha' => date('Y-m-d H:i:s')
                        ];
                    }
                }
                
                // Éxito al guardar
                header('Location:/agregarAprendiz');
                exit();
            } else {
                // Error al guardar
                echo "Error al guardar el aprendiz. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAprendiz');
                exit();
            }
        } else {
            // Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
            header('Refresh: 3; URL=/agregarAprendiz');
            exit();
        }
    }

    public function view($id)
    {
        $objAprendiz = new AgregarAprendizModel($id);
        $aprendizInfo = $objAprendiz->getAprendiz();
        if (!empty($aprendizInfo)) {
            $data = [
                'id' => $aprendizInfo[0]->id,
                'nombre' => $aprendizInfo[0]->nombre,
                'tipoDocumento' => $aprendizInfo[0]->tipoDocumento,
                'documento' => $aprendizInfo[0]->documento,
                'fechaNacimiento' => $aprendizInfo[0]->fechaNacimiento,
                'email' => $aprendizInfo[0]->email,
                'genero' => $aprendizInfo[0]->genero, 
                'estado' => $aprendizInfo[0]->estado, 
                'telefono' => $aprendizInfo[0]->telefono, 
                'eps' => $aprendizInfo[0]->eps,
                'tipoSangre' => $aprendizInfo[0]->tipoSangre,
                'peso' => $aprendizInfo[0]->peso, 
                'estatura' => $aprendizInfo[0]->estatura,
                'telefonoEmerjencia' => $aprendizInfo[0]->telefonoEmerjencia,
                'password' => $aprendizInfo[0]->password, 
                'observaciones' => $aprendizInfo[0]->observaciones,
                'fkIdRol' => $aprendizInfo[0]->fkIdRol,
                'fkIdGrupo' => $aprendizInfo[0]->fkIdGrupo,
                'fkIdCentroFormacion' => $aprendizInfo[0]->fkIdCentroFormacion
            ];
            $this->render("agregarAprendiz/viewOneAprendiz.php", $data);
        } else {
            echo "Aprendiz no encontrado.";
            header('Refresh: 3; URL=/agregarAprendiz');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editUsuario($id)
    {
        $objAprendiz = new AgregarAprendizModel($id);
        $aprendizInfo = $objAprendiz->getAprendiz();
        if (!empty($aprendizInfo)) {
            # Obtener roles, grupos y centros de formación
            $roles = $objAprendiz->getRoles();
            $grupos = $objAprendiz->getGrupos();
            $centrosFormacion = $objAprendiz->getCentrosFormacion();
            
            $data = [
                'infoReal' => $aprendizInfo[0],
                'roles' => $roles,
                'grupos' => $grupos,
                'centrosFormacion' => $centrosFormacion
            ];
            $this->render("agregarAprendiz/editAprendiz.php", $data);
        } else {
            echo "Aprendiz no encontrado.";
            header('Refresh: 3; URL=/agregarAprendiz');
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
            
            // Si hay observaciones nuevas, agregarlas a la sesión
            if (!empty($observaciones)) {
                // Inicializar el array para este ID si no existe
                if (!isset($_SESSION['observaciones_aprendiz'][$id])) {
                    $_SESSION['observaciones_aprendiz'][$id] = [];
                }
                
                // Agregar la nueva observación
                $_SESSION['observaciones_aprendiz'][$id][] = [
                    'texto' => $observaciones,
                    'fecha' => date('Y-m-d H:i:s')
                ];
            }
            
            $aprendizObjEdit = new AgregarAprendizModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $aprendizObjEdit->editAprendiz();
            
            if ($res) {
                header("Location:/agregarAprendiz");
                exit();
            } else {
                echo "Error al actualizar el aprendiz. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAprendiz');
                exit();
            }
        } else {
            echo "ID de aprendiz no proporcionado.";
            header('Refresh: 3; URL=/agregarAprendiz');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar
    public function deleteUsuario($id)
    {
        $objAprendiz = new AgregarAprendizModel($id);
        $aprendizInfo = $objAprendiz->getAprendiz();
        if (!empty($aprendizInfo)) {
            $data = [
                'infoReal' => $aprendizInfo[0],
            ];
            $this->render("agregarAprendiz/deleteAprendiz.php", $data);
        } else {
            echo "Aprendiz no encontrado.";
            header('Refresh: 3; URL=/agregarAprendiz');
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
            
            $aprendizObjDelete = new AgregarAprendizModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $aprendizObjDelete->deleteAprendiz();
            
            if ($res) {
                // Eliminar las observaciones de la sesión para este aprendiz
                if (isset($_SESSION['observaciones_aprendiz'][$id])) {
                    unset($_SESSION['observaciones_aprendiz'][$id]);
                }
                
                header("Location:/agregarAprendiz");
                exit();
            } else {
                echo "Error al eliminar el aprendiz. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/agregarAprendiz');
                exit();
            }
        } else {
            echo "ID de aprendiz no proporcionado.";
            header('Refresh: 3; URL=/agregarAprendiz');
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
                if (!isset($_SESSION['observaciones_aprendiz'][$id])) {
                    $_SESSION['observaciones_aprendiz'][$id] = [];
                }
                
                // Agregar la nueva observación con fecha
                $_SESSION['observaciones_aprendiz'][$id][] = [
                    'texto' => $nuevaObservacion,
                    'fecha' => date('Y-m-d H:i:s')
                ];
                
                // Redirigir de vuelta a la lista
                header("Location:/agregarAprendiz");
                exit();
            } else {
                echo "Datos incompletos para agregar observación.";
                header('Refresh: 3; URL=/agregarAprendiz');
                exit();
            }
        } else {
            echo "Datos incompletos para agregar observación.";
            header('Refresh: 3; URL=/agregarAprendiz');
            exit();
        }
    }
}

?>