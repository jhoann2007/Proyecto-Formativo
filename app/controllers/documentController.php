<?php
namespace App\Controller;
use App\Models\documentModel;

require_once MAIN_APP_ROUTE . "../controllers/baseController.php";
require_once MAIN_APP_ROUTE . "../models/documentModel.php";

class DocumentController extends BaseController {

    
    public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'document_layout';
    }
    
    public function index()
     {
         $this->render('document/documentView.php');
     }


}