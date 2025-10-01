<?php
session_start();

define('RECAPTCHA_SECRET_KEY', '6LeORj8rAAAAAFp3Y1BwOMpILRb-cYH5V0G7s3W0');

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "gymtech"; // Cambiar nombre de base de datos si es necesario

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $_SESSION['login_error'] = "Error de conexión con la base de datos. Intente más tarde.";
    error_log("Conexión fallida: " . $conn->connect_error);
    header("Location: /");
    exit;
}

if (!$conn->set_charset("utf8mb4")) {
    // Manejar el error si es necesario
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => RECAPTCHA_SECRET_KEY, 'response' => $recaptcha_response);
        $options = array('http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method'  => 'POST', 'content' => http_build_query($data)));
        $context  = stream_context_create($options);
        $verify_result_json = @file_get_contents($verify_url, false, $context);
        if ($verify_result_json === FALSE) {
            $_SESSION['login_error'] = "Error al verificar reCAPTCHA. Intente de nuevo.";
            header("Location: /");
            exit;
        }
        $verify_result = json_decode($verify_result_json);
        if (!$verify_result || !$verify_result->success) {
            $_SESSION['login_error'] = "Verificación reCAPTCHA fallida. Por favor, inténtelo de nuevo.";
            header("Location: /");
            exit;
        }
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

    $sql = "SELECT u.*, r.name as role_name
            FROM `user` u
            LEFT JOIN `role` r ON u.id_role = r.id_role
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
        $user_data = $result->fetch_assoc(); 
        $password_hash_db = $user_data['password'];

        if (password_verify($password_ingresada, $password_hash_db)) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user_data['id_user'];
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role_id'] = $user_data['id_role'];
            $_SESSION['user_role_name'] = strtolower($user_data['role_name'] ?? 'unknown'); 
            $_SESSION['user_picture'] = $user_data['picture'];

            unset($_SESSION['login_error']);

            $userRole = $_SESSION['user_role_name'];
            $redirect_url = '/inicio'; 

            switch ($userRole) {
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
    header("Location: /");
    exit;
}

$conn->close();
?>