<?php
session_start();

// --- CONFIGURACIÓN DE RECAPTCHA ---
// Reemplaza TU_SECRET_KEY_AQUI con tu Clave secreta de Google reCAPTCHA
define('RECAPTCHA_SECRET_KEY', '6LeORj8rAAAAAFp3Y1BwOMpILRb-cYH5V0G7s3W0');
// ----------------------------------

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "mydb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Para producción, sería mejor loguear el error y mostrar un mensaje genérico
    $_SESSION['login_error'] = "Error de conexión con la base de datos. Intente más tarde.";
    error_log("Conexión fallida: " . $conn->connect_error);
    header("Location: /"); // O a tu index.php si no usas rutas amigables
    exit;
}

if (!$conn->set_charset("utf8mb4")) {
    // Manejar el error si es necesario
    // printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- VALIDACIÓN DE RECAPTCHA ---
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => RECAPTCHA_SECRET_KEY,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] // Opcional pero recomendado
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify_result_json = @file_get_contents($verify_url, false, $context); // Usar @ para suprimir errores si allow_url_fopen está desactivado

        if ($verify_result_json === FALSE) {
            // Error al contactar el servidor de Google reCAPTCHA
            // Podrías usar cURL como alternativa si file_get_contents falla o está deshabilitado
            $_SESSION['login_error'] = "Error al verificar reCAPTCHA. Intente de nuevo.";
            error_log("reCAPTCHA: No se pudo conectar con el servidor de Google.");
            header("Location: /");
            exit;
        }
        
        $verify_result = json_decode($verify_result_json);

        if (!$verify_result || !$verify_result->success) {
            $_SESSION['login_error'] = "Verificación reCAPTCHA fallida. Por favor, inténtelo de nuevo.";
            header("Location: /");
            exit;
        }
        // --- FIN VALIDACIÓN DE RECAPTCHA ---
        // Si llegamos aquí, el reCAPTCHA fue exitoso. Continuamos con el login.

    } else {
        $_SESSION['login_error'] = "Por favor, completa el reCAPTCHA.";
        header("Location: /");
        exit;
    }

    $email = $_POST['email'] ?? '';
    $password_ingresada = $_POST['password'] ?? '';

    if (empty($email) || empty($password_ingresada)) {
        $_SESSION['login_error'] = "Email y contraseña son requeridos.";
        header("Location: /");
        exit;
    }

    $sql = "SELECT u.id, u.nombre, u.password, u.fkIdRol, r.nombre as nombreRol
            FROM usuario u
            LEFT JOIN rol r ON u.fkIdRol = r.id
            WHERE u.email = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log("Error preparando statement: " . $conn->error); 
        $_SESSION['login_error'] = "Error del sistema. Intente más tarde.";
        header("Location: /");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        $password_hash_db = $usuario['password'];

        if (password_verify($password_ingresada, $password_hash_db)) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nombre'] = $usuario['nombre'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_rol_id'] = $usuario['fkIdRol'];
            $_SESSION['user_rol_nombre'] = strtolower($usuario['nombreRol'] ?? 'desconocido');

            unset($_SESSION['login_error']);

            $rolUsuario = $_SESSION['user_rol_nombre'];
            $redirect_url = '/inicio'; // URL por defecto si el rol no coincide

            switch ($rolUsuario) {
                case 'admin':
                    $redirect_url = '/inicio';
                    break;
                case 'entrenador': 
                    $redirect_url = '/inicio';
                    break;
                case 'aprendiz': 
                    $redirect_url = '/inicio';
                    break;
            }

            header("Location: " . $redirect_url);
            exit;

        } else {
            $_SESSION['login_error'] = "Email o contraseña incorrectos.";
            header("Location: /");
            exit;
        }
    } else {
        $_SESSION['login_error'] = "Email o contraseña incorrectos.";
        header("Location: /");
        exit;
    }

    $stmt->close();

} else {
    // Si no es POST, redirigir (aunque tu .htaccess o router ya debería manejar esto)
    header("Location: /");
    exit;
}

$conn->close();
?>