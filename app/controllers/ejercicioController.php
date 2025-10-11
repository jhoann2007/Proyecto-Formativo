<?php
namespace App\Controller;
use App\Models\EjercicioModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/ejercicioModel.php";

class EjercicioController extends BaseController
{
    public function __construct()
    {
        # Se define el layout para este cont$this->layout = 'ejercicio_layout';$this->layout = 'ejercicio_layout';$this->layout = 'ejercicio_layout';rolador
        $this->layout = 'ejercicio_layout';

        # Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
    }

    public function index()
    {
        # Crear una instancia del modelo
        $ejercicioObj = new EjercicioModel();

        # Obtener todos los ejercicios desde el modelo
        $exercise = $ejercicioObj->getAll();

        # Obtener grupos musculares
        $musclegroup = $ejercicioObj->getGruposMusculares();

        # Pasar los datos a la vista
        $data = [
            'title' => 'Gestión de Ejercicios',
            'exercise' => $exercise,
            'musclegroup' => $musclegroup
        ];

        # Renderizar la vista a través del método de BaseController
        $this->render('agregarEjercicio/ejercicioView.php', $data);
    }

    public function agregarEjercicio()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['txtNombre'] ?? null;
            $musclegroup = $_POST['txtGrupoMuscular'] ?? null;
            $rutaImagen = '';
            
            // Verificar si se ha subido un archivo
            if (isset($_FILES['fileImagen']) && $_FILES['fileImagen']['error'] === UPLOAD_ERR_OK) {
                $archivo = $_FILES['fileImagen'];
                $nombreArchivo = time() . '_' . basename($archivo['name']);
                $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . '/Gym/public/img/ejercicios/';
                
                // Crear el directorio si no existe
                if (!file_exists($directorioDestino)) {
                    mkdir($directorioDestino, 0777, true);
                }
                
                $rutaCompleta = $directorioDestino . $nombreArchivo;
                
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
                    // La ruta que se guardará en la base de datos (ruta relativa para mostrar en el navegador)
                    $rutaImagen = '/Gym/public/img/ejercicios/' . $nombreArchivo;
                } else {
                    // Error al mover el archivo
                    echo "Error al subir la imagen. Por favor, inténtelo de nuevo.";
                    header('Refresh: 3; URL=/ejercicio');
                    exit();
                }
            } else {
                // Error con el archivo
                echo "Error con el archivo de imagen. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/ejercicio');
                exit();
            }

            if ($name && $rutaImagen && $musclegroup) {
                # Crear una instancia del modelo con los datos
                $ejercicioObj = new EjercicioModel(null, $name, $rutaImagen, $musclegroup);

                # Guardar el ejercicio
                $resultado = $ejercicioObj->createEjercicio();

                if ($resultado) {
                    # Éxito al guardar
                    header('Location:/ejercicio');
                    exit();
                } else {
                    # Error al guardar
                    echo "Error al guardar el ejercicio. Por favor, inténtelo de nuevo.";
                    header('Refresh: 3; URL=/ejercicio');
                    exit();
                }
            } else {
                # Datos incompletos
                echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
                header('Refresh: 3; URL=/ejercicio');
                exit();
            }
        } else {
            # Método no permitido
            header('Location:/ejercicio');
            exit();
        }
    }

    public function agregarGrupoMuscular()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['txtNombreGrupo'] ?? null;
            $rutaImagen = '';
            
            // Verificar si se ha subido un archivo
            if (isset($_FILES['fileImagenGrupo']) && $_FILES['fileImagenGrupo']['error'] === UPLOAD_ERR_OK) {
                $archivo = $_FILES['fileImagenGrupo'];
                $nombreArchivo = time() . '_' . basename($archivo['name']);
                $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . '/Gym/public/img/ejercicios/';
                
                // Crear el directorio si no existe
                if (!file_exists($directorioDestino)) {
                    mkdir($directorioDestino, 0777, true);
                }
                
                $rutaCompleta = $directorioDestino . $nombreArchivo;
                
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
                    // La ruta que se guardará en la base de datos (ruta relativa para mostrar en el navegador)
                    $rutaImagen = '/Gym/public/img/ejercicios/' . $nombreArchivo;
                } else {
                    // Error al mover el archivo
                    echo "Error al subir la imagen. Por favor, inténtelo de nuevo.";
                    header('Refresh: 3; URL=/ejercicio');
                    exit();
                }
            } else {
                // Error con el archivo
                echo "Error con el archivo de imagen. Por favor, inténtelo de nuevo.";
                header('Refresh: 3; URL=/ejercicio');
                exit();
            }

            if ($name && $rutaImagen) {
                # Crear una instancia del modelo
                $ejercicioObj = new EjercicioModel();

                # Guardar el grupo muscular
                $resultado = $ejercicioObj->createGrupoMuscular($name, $rutaImagen);

                if ($resultado) {
                    # Éxito al guardar
                    header('Location:/ejercicio');
                    exit();
                } else {
                    # Error al guardar
                    echo "Error al guardar el grupo muscular. Por favor, inténtelo de nuevo.";
                    header('Refresh: 3; URL=/ejercicio');
                    exit();
                }
            } else {
                # Datos incompletos
                echo "Datos incompletos. Por favor, complete todos los campos obligatorios.";
                header('Refresh: 3; URL=/ejercicio');
                exit();
            }
        } else {
            # Método no permitido
            header('Location:/ejercicio');
            exit();
        }
    }
}
?>

