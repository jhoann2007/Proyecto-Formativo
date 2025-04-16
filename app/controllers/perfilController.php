<?php
namespace App\Controller;
use App\Models\PerfilModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/perfilModel.php";

class PerfilController extends BaseController
{

    public function index()
    {
        $this->render('perfil/perfil.php');
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'perfil_layout';
    }
}
?>