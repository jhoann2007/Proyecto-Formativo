<?php
namespace App\Controller;
// use App\Models\AgregarAprendizModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
// require_once MAIN_APP_ROUTE . "../models/agregarAprendizModel.php";

class AgregarAprendizController extends BaseController
{

    public function index()
    {
        // # Crear una instancia del modelo rol 
        // $agregarAprendizObj = new AgregarAprendizModel();
        // # Obtener todos los roles desde el modelo 
        // $aprendices = $agregarAprendizObj->getAll();
        // # Pasar los datos a la vista 
        // $data = [
        //     'title' => 'Lista de Aprendices',
        //     'aprendices' => $aprendices
        // ];
        # Renderizar la vista  a traves del metodo de BaseController
        $this->render('agregar_aprendiz/agregarAprendiz.php');
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'agregarAprendiz_layout';
    }
}
?>