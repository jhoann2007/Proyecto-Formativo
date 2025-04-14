<?php
namespace App\Controller;
use App\Models\PerfilModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/perfilModel.php";

class PerfilController extends BaseController
{

    public function index()
    {
        # Crear una instancia del modelo rol 
        $perfilObj = new PerfilModel();
        # Obtener todos los roles desde el modelo 
        $perfiles = $perfilObj->getAll();
        # Pasar los datos a la vista 
        $data = [
            'title' => 'Lista de Perfiles',
            'perfiles' => $perfiles
        ];
        # Renderizar la vista  a traves del metodo de BaseController
        $this->render('perfil/perfil.php', $data);
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'perfil_layout';
    }
}
?>