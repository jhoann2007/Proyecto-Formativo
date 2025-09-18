<?php

namespace App\Controller;

use App\Models\AgregarUsuarioModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/agregarUsuarioModel.php";

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
        $agregarAprendizObj = new AgregarUsuarioModel();
        
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
            $this->render("agregarAprendiz/viewOneAprendiz.php", $data);
        } else {
            echo "Aprendiz no encontrado.";
            header('Refresh: 3; URL=/agregarAprendiz');
            exit();
        }
    }

    # Mostrar lo que se quiere editar en el formulario
    public function editUsuario($id_user)
    {
        $objAprendiz = new AgregarUsuarioModel($id_user);
        $aprendizInfo = $objAprendiz->getUser();
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
            
            $aprendizObjEdit = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $aprendizObjEdit->editUser();
            
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
    public function deleteUsuario($id_user)
    {
        $objAprendiz = new AgregarUsuarioModel($id_user);
        $aprendizInfo = $objAprendiz->getUser();
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
            
            $aprendizObjDelete = new AgregarUsuarioModel($id, $nombre, $tipoDocumento, $documento, $fechaNacimiento, $email, $genero, $estado, $telefono, $eps, $tipoSangre, $peso, $estatura, $telefonoEmerjencia, $password, $observaciones, $fkIdRol, $fkIdGrupo, $fkIdCentroFormacion);
            $res = $aprendizObjDelete->deleteUser();
            
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