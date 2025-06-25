<?php
namespace App\Controller;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";

class HomeController extends BaseController
{
    //Accion 1 del controlador 
    public function index()
    {
        $this->render('login/index.php');
    
    }

    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'admin_layout';
    }

    public function login()
    {
        $this->render('login/login.php');
    }

    public function cerrar()
    {
        $this->render('login/logout.php');
    }

    //Accion 2 del controlador 
    public function saludar()
    {
        echo "<br>CONTROLLER > homeController";
        echo "<br>ACTION > saludo";
    }

    
}
?>

