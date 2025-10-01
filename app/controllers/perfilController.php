<?php
// Archivo: app/controllers/PerfilController.php

namespace App\Controller;

use App\Models\PerfilModel;

require_once __DIR__ . '/BaseController.php'; 
require_once __DIR__ . '/../models/PerfilModel.php'; 

class PerfilController extends BaseController
{
    public function index()
    {
        //echo "Punto 1: Entrando al método index de PerfilController.<br>"; // Punto de control 1

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            echo "Punto 2: No hay user_id en la sesión. Redirigiendo...<br>"; // Punto de control 2
            $this->redirectTo('/');
            return;
        }

        $userId = $_SESSION['user_id'];
        //echo "Punto 3: El ID de usuario de la sesión es: " . htmlspecialchars($userId) . "<br>"; // Punto de control 3
        
        $perfilModel = new PerfilModel();
        
        $userData = $perfilModel->getUserProfileById($userId);
        
        // echo "Punto 4: Datos obtenidos del modelo:<br>"; // Punto de control 4
        // echo "<pre>";
        // print_r($userData); // Muestra el contenido del objeto o si es 'false'
        // echo "</pre>";

        if (!$userData) {
            echo "Punto 5: userData es falso o vacío. Deteniendo ejecución.<br>"; // Punto de control 5
            // exit; // Descomenta esta línea para detener aquí y ver los mensajes
            return;
        }

        //echo "Punto 6: Todo correcto. A punto de renderizar la vista.<br>"; // Punto de control 6
        // exit; // Descomenta esta línea para detener aquí y ver los mensajes

        $this->render('perfil/perfil.php', ['user' => $userData]);
    }

     public function __construct()
    {
        // Se define el layout para este controlador 
        $this->layout = 'perfil_layout';
    }
}