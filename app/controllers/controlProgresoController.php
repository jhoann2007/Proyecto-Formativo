<?php
namespace App\Controller;

use App\Models\ControlProgresoModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/controlProgresoModel.php";

class ControlProgresoController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este controlador
        $this->layout = 'controlProgreso_layout';
        # Inciiar sesión sino está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        # Iniciar el array de observaciones en la sesión sino existe
        if (!isset($_SESSION['observaciones_control'])) {
            $_SESSION['observaciones_control'] = [];
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $controlObj = new ControlProgresoModel();

        # Obtener los Controles de progreso
        $controles = $controlObj->getControlProgreso();

        # Obtener solo los aprendices (rol 3) desde el modelo
        $aprendices = $controlObj->getAprendicesOnly();

        # Pasar los datos a la vista
        $data = [
            'title' => 'Control de Progreso',
            'controles' => $controles,
            'aprendices' => $aprendices
        ];
        # Renderizar la vista a traves del metodo BaseController
        $this->render('controlProgreso/controlProgreso.php', $data);
    }

    # Guardar los datos del formulario
    public function create()
    {
        $fechaRealizacion = $_POST['txtFechaRealizacion'] ?? null;
        $peso = $_POST['txtPeso'] ?? null;
        $cintura = $_POST['txtCintura'] ?? null;
        $cadera = $_POST['txtCadera'] ?? null;
        $musloDerecho = $_POST['txtMusloDerecho'] ?? null;
        $musloIsquierdo = $_POST['txtMusloIzquierdo'] ?? null;
        $brazoDerecho = $_POST['txtBrazoDerecho'] ?? null;
        $brazoIzquierdo = $_POST['txtBrazoIzquierdo'] ?? null;
        $antebrazoDerecho = $_POST['txtAntebrazoDerecho'] ?? null;
        $antebrazoIzquierdo = $_POST['txtAntebrazoIzquierdo'] ?? null;
        $pantorrillaDerecha = $_POST['txtPantorrillaDerecha'] ?? null;
        $pantorrillaIzquierda = $_POST['txtPantorrillaIzquierda'] ?? null;
        $examenMedico = $_POST['txtExamenMedico'] ?? null;
        $observaciones = $_POST['txtObservaciones'] ?? null;
        $fechaExamen = $_POST['txtFechaExamen'] ?? null;
        $fkIdUsuario = $_POST['txtFKidUsuario'] ?? null;

        if ($fechaRealizacion && $fkIdUsuario) { // Asegurar que los campos esenciales estén presentes
            $objControlprogreso = new ControlProgresoModel(null, $fechaRealizacion, $peso, $cintura, $cadera, $musloDerecho, $musloIsquierdo, $brazoDerecho, $brazoIzquierdo, $antebrazoDerecho, $antebrazoIzquierdo, $pantorrillaDerecha, $pantorrillaIzquierda, $examenMedico, $observaciones, $fechaExamen, $fkIdUsuario);
            $response = $objControlprogreso->save();
            if ($response) {
                # Si hay observaciones iniciales, guárdalas en la sesión
                if (!empty($observaciones)) {
                    # Obtener el ID del control de progreso recién creado
                    $nuevoId = $objControlprogreso->getLastInsertId();
                    if ($nuevoId) {
                        # Inicializar el array para este ID si no existe
                        if (!isset($_SESSION['observaciones_controlprogreso'][$nuevoId])) {
                            $_SESSION['observaciones_controlprogreso'][$nuevoId] = [];
                        }
                        # Agregar la observación inicial
                        $_SESSION['observaciones_controlprogreso'][$nuevoId][] = [
                            'texto' => $observaciones,
                            'fecha' => date('Y-m-d H:i:s')
                        ];
                    }
                }
                # Éxito al guardar
                header('Location:/controlProgreso');
                exit();
            } else {
                # Error al guardar
                echo "Error al guardar el Control de Progreso. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/controlProgreso');
                exit();
            }
        } else {
            # Datos incompletos
            echo "Datos incompletos. Por favor, complete todos los campos obligatorios";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }

    public function view($id)
    {
        $objControl = new ControlProgresoModel($id);
        $controlInfo = $objControl->getControlProgreso();
        if (!empty($controlInfo)) {
            $data = [
                'fechaRealizacion' => $controlInfo[0]->id,
                'peso' => $controlInfo[0]->peso,
                'cintura' => $controlInfo[0]->cintura,
                'cadera' => $controlInfo[0]->cadera,
                'musloDerecho' => $controlInfo[0]->musloDerecho,
                'musloIsquierdo' => $controlInfo[0]->musloIsquierdo,
                'brazoDerecho' => $controlInfo[0]->brazoDerecho,
                'brazoIzquierdo' => $controlInfo[0]->brazoIzquierdo,
                'antebrazoDerecho' => $controlInfo[0]->antebrazoDerecho,
                'antebrazoIzquierdo' => $controlInfo[0]->antebrazoIzquierdo,
                'pantorrillaDerecha' => $controlInfo[0]->pantorrillaDerecha,
                'pantorrillaIzquierda' => $controlInfo[0]->pantorrillaIzquierda,
                'examenMedico' => $controlInfo[0]->examenMedico,
                'observaciones' => $controlInfo[0]->observaciones,
                'fechaExamen' => $controlInfo[0]->fechaExamen,
                'fkIdUsuario' => $controlInfo[0]->fkIdUsuario
            ];
            $this->render("controlProgreso/viewOneControlProgreso.php", $data);
        } else {
            echo "Control de Progreso no encontrado.";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }

    public function editControl($id)
    {
        $objControl = new ControlProgresoModel($id);
        $controlInfo = $objControl->getControlProgreso();
        if (!empty($controlInfo)) {
            # Obtener aprendices
            $aprendices = $objControl->getAprendicesOnly();

            $data = [
                'infoReal' => $controlInfo[0],
                'aprendices' => $aprendices
            ];
            $this->render("controlProgreso/editControlProgreso.php", $data);
        } else {
            echo "Control de progreso no encontrado.";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }

    # Se edita como tal en la DB
    public function updateControl()
    {
        if (isset($_POSST['txtId'])) {
            $id = $_POST['txtId'] ?? null;
            $fechaRealizacion = $_POST['txtFechaRealizacion'] ?? null;
            $peso = $_POST['txtPeso'] ?? null;
            $cintura = $_POST['txtCintura'] ?? null;
            $cadera = $_POST['txtCadera'] ?? null;
            $musloDerecho = $_POST['txtMusloDerecho'] ?? null;
            $musloIsquierdo = $_POST['txtMusloIzquierdo'] ?? null;
            $brazoDerecho = $_POST['txtBrazoDerecho'] ?? null;
            $brazoIzquierdo = $_POST['txtBrazoIzquierdo'] ?? null;
            $antebrazoDerecho = $_POST['txtAntebrazoDerecho'] ?? null;
            $antebrazoIzquierdo = $_POST['txtAntebrazoIzquierdo'] ?? null;
            $pantorrillaDerecha = $_POST['txtPantorrillaDerecha'] ?? null;
            $pantorrillaIzquierda = $_POST['txtPantorrillaIzquierda'] ?? null;
            $examenMedico = $_POST['txtExamenMedico'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fechaExamen = $_POST['txtFechaExamen'] ?? null;
            $fkIdUsuario = $_POST['txtFKidUsuario'] ?? null;

            # Si hay observaciones nuevas, agregarlas a la sesión
            if (!empty($observaciones)) {
                # Inicializar el array para este ID sino existe
                if (!isset($_SESSION['observaciones_control'][$id])) {
                    $_SESSION['observaciones_control'][$id] = [];
                }

                # Agregar la nueva observación
                $_SESSION['observaciones_control'][$id][] = [
                    'texto' => $observaciones,
                    'fecha' => date("Y-m-d H:i:s")
                ];
            }

            $controlObjEdit = new ControlProgresoModel($id, $fechaRealizacion, $peso, $cintura, $cadera, $musloDerecho, $musloIsquierdo, $brazoDerecho, $brazoIzquierdo, $antebrazoDerecho, $antebrazoIzquierdo, $pantorrillaDerecha, $pantorrillaIzquierda, $examenMedico, $observaciones, $fechaExamen, $fkIdUsuario);
            $response = $controlObjEdit->editControlProgreso();

            if ($response) {
                header("Location:/controlProgreso");
                exit();
            } else {
                echo "Error al actualizar el control de progreso. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/controlProgreso');
                exit();
            }
        } else {
            echo "ID de Control de progreso no proporcionado.";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }

    # Muestra lo que se quiere eliminar
    public function deleteControl($id)
    {
        $objControl = new ControlProgresoModel($id);
        $controlInfo = $objControl->getControlProgreso();
        if (!empty($controlInfo)) {
            $data = [
                'infoReal' => $controlInfo[0]
            ];
            $this->render("controlProgreso/deleteControlProgreso.php", $data);
        } else {
            echo "Control de progreso no encontrado.";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }

    # Se elimina de la DB
    public function borrarControl()
    {
        if (isset($_POST['txtId'])) {
            $id = $_POST['txtId'] ?? null;
            $fechaRealizacion = $_POST['txtFechaRealizacion'] ?? null;
            $peso = $_POST['txtPeso'] ?? null;
            $cintura = $_POST['txtCintura'] ?? null;
            $cadera = $_POST['txtCadera'] ?? null;
            $musloDerecho = $_POST['txtMusloDerecho'] ?? null;
            $musloIsquierdo = $_POST['txtMusloIzquierdo'] ?? null;
            $brazoDerecho = $_POST['txtBrazoDerecho'] ?? null;
            $brazoIzquierdo = $_POST['txtBrazoIzquierdo'] ?? null;
            $antebrazoDerecho = $_POST['txtAntebrazoDerecho'] ?? null;
            $antebrazoIzquierdo = $_POST['txtAntebrazoIzquierdo'] ?? null;
            $pantorrillaDerecha = $_POST['txtPantorrillaDerecha'] ?? null;
            $pantorrillaIzquierda = $_POST['txtPantorrillaIzquierda'] ?? null;
            $examenMedico = $_POST['txtExamenMedico'] ?? null;
            $observaciones = $_POST['txtObservaciones'] ?? null;
            $fechaExamen = $_POST['txtFechaExamen'] ?? null;
            $fkIdUsuario = $_POST['txtFKidUsuario'] ?? null;

            $controlObjDelete = new ControlProgresoModel($id, $fechaRealizacion, $peso, $cintura, $cadera, $musloDerecho, $musloIsquierdo, $brazoDerecho, $brazoIzquierdo, $antebrazoDerecho, $antebrazoIzquierdo, $pantorrillaDerecha, $pantorrillaIzquierda, $examenMedico, $observaciones, $fechaExamen, $fkIdUsuario);
            $response = $controlObjDelete->deleteControlProgreso();

            if ($response) {
                # Eliminar las observaciones de la sesión para este control
                if (isset($_SESSION['observaciones_control'][$id])) {
                    unset($_SESSION['observaciones_control'][$id]);
                }
                header("Location:/controlProgreso");
                exit();
            } else {
                echo "Error al eliminar el control de progreso. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/controlProgreso');
                exit();
            }
        } else {
            echo "ID de control de progreso no proporcionado";
            header('Refresh: 3; URL=/controlProgreso');
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
                if (!isset($_SESSION['observaciones_control'][$id])) {
                    $_SESSION['observaciones_control'][$id] = [];
                }
                
                // Agregar la nueva observación con fecha
                $_SESSION['observaciones_control'][$id][] = [
                    'texto' => $nuevaObservacion,
                    'fecha' => date('Y-m-d H:i:s')
                ];
                
                // Redirigir de vuelta a la lista
                header("Location:/controlProgreso");
                exit();
            } else {
                echo "Datos incompletos para agregar observación.";
                header('Refresh: 3; URL=/controlProgreso');
                exit();
            }
        } else {
            echo "Datos incompletos para agregar observación.";
            header('Refresh: 3; URL=/controlProgreso');
            exit();
        }
    }
}
?>