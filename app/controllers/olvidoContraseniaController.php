<?php
namespace App\Controller;

require_once MAIN_APP_ROUTE . "../models/olvidoContraseniaModel.php";
require_once MAIN_APP_ROUTE . "../../vendor/autoload.php";

use App\Models\OlvidoContraseniaModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OlvidoContraseniaController {
    
    private $model;
    private $lastMailError = null;
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new OlvidoContraseniaModel();
    }
    
    /**
     * Muestra el formulario para solicitar recuperación de contraseña o procesa la solicitud
     */
    public function mostrarFormularioSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si es POST, procesar la solicitud
            $this->procesarSolicitud();
        } else {
            // Si es GET, mostrar el formulario
            require_once MAIN_APP_ROUTE . "../views/olvido-contrasenia/solicitar.php";
        }
    }
    
    /**
     * Procesa la solicitud de recuperación de contraseña
     */
    public function procesarSolicitud() {
        try {
            // Evitar que advertencias/errores se impriman y contaminen JSON
            ini_set('display_errors', '0');
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->enviarRespuesta(false, 'Método no permitido.');
                return;
            }
            
            $email = trim($_POST['email'] ?? '');
            
            if (empty($email)) {
                $this->enviarRespuesta(false, 'Por favor ingrese su correo electrónico.');
                return;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->enviarRespuesta(false, 'Por favor ingrese un correo electrónico válido.');
                return;
            }
            
            // Verificar si el correo existe
            $usuario = $this->model->verificarCorreo($email);
            
            if (!$usuario) {
                $this->enviarRespuesta(false, 'No se encontró una cuenta asociada a este correo electrónico.');
                return;
            }
            
            // Generar código de verificación
            $codigo = $this->generarCodigo();
            
            // Guardar código en la base de datos
            if ($this->model->guardarCodigo($email, $codigo)) {
                // Enviar correo
                if ($this->enviarCorreoRecuperacion($email, $codigo)) {
                    $_SESSION['email_recuperacion'] = $email;
                    $this->enviarRespuesta(true, 'Se ha enviado un código de verificación a su correo electrónico.');
                    return;
                } else {
                    $detalleCorreo = $this->lastMailError ? (' DetalleCorreo: ' . $this->lastMailError) : '';
                    $this->enviarRespuesta(false, 'Error al enviar el correo. Intente nuevamente.' . $detalleCorreo);
                    return;
                }
            } else {
                // Adjuntar detalle temporal para depurar
                $detalle = $this->model->getLastError();
                $mensaje = 'Error interno. Intente nuevamente.';
                if ($detalle && is_array($detalle)) {
                    $mensaje .= ' Detalle: ' . json_encode($detalle, JSON_UNESCAPED_UNICODE);
                }
                $this->enviarRespuesta(false, $mensaje);
                return;
            }
        } catch (Exception $e) {
            error_log("Error en procesarSolicitud: " . $e->getMessage());
            $this->enviarRespuesta(false, 'Ha ocurrido un error al procesar la solicitud. Error: ' . $e->getMessage());
            return;
        }
    }
    
    /**
     * Envía respuesta JSON para solicitudes AJAX
     */
    private function enviarRespuesta($exito, $mensaje) {
        // Limpia cualquier salida previa para no contaminar el JSON
        if (function_exists('ob_get_length') && ob_get_length()) {
            @ob_clean();
        }
        // CORS para entorno de desarrollo cuando frontend corre en 8080
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $origin = $_SERVER['HTTP_ORIGIN'];
            // Permitir localhost:8080 en desarrollo
            if (preg_match('/^https?:\/\/localhost:8080$/', $origin)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Credentials: true');
                header('Vary: Origin');
            }
        }
        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'success' => $exito,
            'message' => $mensaje
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Muestra el formulario para verificar el código
     */
    public function mostrarFormularioVerificacion() {
        if (!isset($_SESSION['email_recuperacion'])) {
            header('Location: /olvido-contrasenia/solicitar');
            exit;
        }
        
        require_once MAIN_APP_ROUTE . "../views/olvido_contrasenia/verificar.php";
    }
    
    /**
     * Procesa la verificación del código
     */
    public function procesarVerificacion() {

        // Responder en JSON para consumo vía fetch
        ini_set('display_errors', '0');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarRespuesta(false, 'Método no permitido.');
            return;
        }
        
        // Permitir pasar email por POST cuando la verificación se hace por AJAX
        $email = $_SESSION['email_recuperacion'] ?? (trim($_POST['email'] ?? ''));
        $codigo = trim($_POST['codigo'] ?? '');
        
        if (empty($email) || empty($codigo)) {
            $this->enviarRespuesta(false, 'Datos incompletos para verificación.');
            return;
        }
        
        // Verificar el código
        $resultado = $this->model->verificarCodigo($email, $codigo);
        
        if ($resultado) {
            $_SESSION['codigo_verificado'] = $codigo;
            $_SESSION['email_recuperacion'] = $email; // asegurar persistencia para el cambio
            $this->enviarRespuesta(true, 'Código verificado correctamente. Ahora puede cambiar su contraseña.');
            return;
        } else {
            $this->enviarRespuesta(false, 'Código inválido o expirado. Solicite un nuevo código.');
            return;
        }
    }
    
    /**
     * Muestra el formulario para cambiar la contraseña
     */
    public function mostrarFormularioCambio() {
        if (!isset($_SESSION['email_recuperacion']) || !isset($_SESSION['codigo_verificado'])) {
            header('Location: /olvido-contrasenia/solicitar');
            exit;
        }
        
        require_once MAIN_APP_ROUTE . "../views/olvido_contrasenia/cambiar.php";
    }
    
    /**
     * Procesa el cambio de contraseña
     */
    public function procesarCambio() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /olvido-contrasenia/cambiar');
            exit;
        }
        
        if (!isset($_SESSION['email_recuperacion']) || !isset($_SESSION['codigo_verificado'])) {
            header('Location: /olvido-contrasenia/solicitar');
            exit;
        }
        
        $nuevaContrasenia = $_POST['nueva_contrasenia'] ?? '';
        $confirmarContrasenia = $_POST['confirmar_contrasenia'] ?? '';
        $email = $_SESSION['email_recuperacion'];
        $codigo = $_SESSION['codigo_verificado'];
        
        if (empty($nuevaContrasenia) || empty($confirmarContrasenia)) {
            $_SESSION['error'] = 'Por favor complete todos los campos.';
            header('Location: /olvido-contrasenia/cambiar');
            exit;
        }
        
        if (strlen($nuevaContrasenia) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
            header('Location: /olvido-contrasenia/cambiar');
            exit;
        }
        
        if ($nuevaContrasenia !== $confirmarContrasenia) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            header('Location: /olvido-contrasenia/cambiar');
            exit;
        }
        
        // Verificar nuevamente el código antes de cambiar la contraseña
        $verificacion = $this->model->verificarCodigo($email, $codigo);
        
        if (!$verificacion) {
            $_SESSION['error'] = 'Sesión expirada. Solicite un nuevo código.';
            unset($_SESSION['email_recuperacion'], $_SESSION['codigo_verificado']);
            header('Location: /olvido-contrasenia/solicitar');
            exit;
        }
        
        // Hashear la nueva contraseña
        $contraseniaHasheada = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);
        
        // Cambiar la contraseña
        if ($this->model->cambiarContrasenia($email, $contraseniaHasheada)) {
            // Limpiar variables de sesión
            unset($_SESSION['email_recuperacion'], $_SESSION['codigo_verificado']);
            
            $_SESSION['success'] = 'Contraseña cambiada exitosamente. Ya puede iniciar sesión.';
            header('Location: /login');
            exit;
        } else {
            $_SESSION['error'] = 'Error al cambiar la contraseña. Intente nuevamente.';
            header('Location: /olvido-contrasenia/cambiar');
            exit;
        }
    }
    
    /**
     * Genera un código aleatorio de 6 dígitos
     * @return string Código generado
     */
    private function generarCodigo()
    {
        $mailConfig = require MAIN_APP_ROUTE . "../config/mail.php";
        $length = $mailConfig['recovery']['code_length'];
        $max = pow(10, $length) - 1;
        return str_pad(random_int(0, $max), $length, '0', STR_PAD_LEFT);
    }
    
    /**
     * Envía el correo de recuperación
     * @param string $email Email del destinatario
     * @param string $codigo Código de verificación
     * @return bool True si se envió correctamente, False en caso contrario
     */
    private function enviarCorreoRecuperacion($email, $codigo) {
        try {
            // Cargar configuración de correo
            $mailConfig = require MAIN_APP_ROUTE . "../config/mail.php";
            
            $mail = new PHPMailer(true);
            
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = $mailConfig['smtp']['host'];
            $mail->SMTPAuth = $mailConfig['smtp']['auth'];
            $mail->Username = $mailConfig['credentials']['username'];
            $mail->Password = $mailConfig['credentials']['password'];
            $mail->SMTPSecure = $mailConfig['smtp']['encryption'];
            $mail->Port = $mailConfig['smtp']['port'];
            
            // Forzar el debug a no imprimir por pantalla y redirigir a log
            $mail->SMTPDebug = 0; // nunca imprimir en salida
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer SMTP debug (nivel $level): $str");
            };
            $mail->CharSet = 'UTF-8';
            
            // Configuración del correo
            $mail->setFrom($mailConfig['from']['address'], $mailConfig['from']['name']);
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = $mailConfig['recovery']['subject'];
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #333; text-align: center;'>Recuperación de Contraseña</h2>
                    <div style='background-color: #f9f9f9; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                        <p>Has solicitado recuperar tu contraseña para tu cuenta en GymTech.</p>
                        <p>Tu código de verificación es:</p>
                        <div style='text-align: center; margin: 20px 0;'>
                            <span style='font-size: 24px; font-weight: bold; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; letter-spacing: 3px;'>$codigo</span>
                        </div>
                        <p><strong>Este código expira en {$mailConfig['recovery']['expiry_minutes']} minutos.</strong></p>
                        <p style='color: #666; font-size: 14px;'>Si no solicitaste este cambio, puedes ignorar este correo de forma segura.</p>
                    </div>
                    <p style='text-align: center; color: #999; font-size: 12px;'>
                        © " . date('Y') . " GymTech. Todos los derechos reservados.
                    </p>
                </div>
            ";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->lastMailError = $mail->ErrorInfo ?: $e->getMessage();
            error_log("Error enviando correo: " . $this->lastMailError);
            return false;
        }
    }
}