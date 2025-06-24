<?php
namespace App\Controller;
use App\Models\PerfilModel;
use App\Models\AgregarAprendizModel;

require_once MAIN_APP_ROUTE . "../models/agregarAprendizModel.php";

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/perfilModel.php";

class PerfilController extends BaseController
{

    public function index2()
    {
        $this->render('perfil/perfil.php');
    }

    public function index()
    {
        # Crear una instancia del modelo
        $agregarAprendizObj = new AgregarAprendizModel();
        
        # Obtener todos los aprendices desde el modelo 
        $aprendices = $agregarAprendizObj->getAll();
        
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
        $this->render('perfil/perfil.php', $data);
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'perfil_layout';
    }

    
}
?>