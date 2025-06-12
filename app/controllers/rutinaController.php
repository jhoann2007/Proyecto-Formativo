<?php
namespace App\Controller;
use App\Models\rutinaModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/rutinaModel.php";

class RutinaController extends BaseController {

    
    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'rutina_layout';
    }
    
    public function index()
     {
         $this->render('agregarRutina/rutinaView.php');
     }


}