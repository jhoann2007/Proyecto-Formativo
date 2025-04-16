<?php
namespace App\Controller;
// use App\Models\PerfilModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
// require_once MAIN_APP_ROUTE . "../models/calendarioModel.php";

class CalendarioController extends BaseController
{

    public function index()
    {
        // # Crear una instancia del modelo rol 
        // $calendarioObj = new CalendarioModel();
        // # Obtener todos los roles desde el modelo 
        // $calendario = $calendarioObj->getAll();
        // # Pasar los datos a la vista 
        // $data = [
        //     'title' => 'Lista de calendario',
        //     'Calendarios' => $calendario
        // ];
        // # Renderizar la vista  a traves del metodo de BaseController
        $this->render('calendario/calendario.php');
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'calendario_layout';
    }
}
?>