<?php
session_start();

require_once 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password_ingresada = $_POST['password'] ?? '';

    if (empty($email) || empty($password_ingresada)) {
        $_SESSION['login_error'] = "Email y contraseña son requeridos.";
        header("Location: index.php");
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
        header("Location: index.php");
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
            $redirect_url = 'default_dashboard.php'; 

            switch ($rolUsuario) {
                case 'admin':
                    $redirect_url = 'index2.php';
                    break;
                case 'entrenador': 
                    $redirect_url = 'index3.php';
                    break;
                case 'estudiante': 
                    $redirect_url = 'index4.php';
                    break;
            }

            header("Location: " . $redirect_url);
            exit;

        } else {
            $_SESSION['login_error'] = "Email o contraseña incorrectos.";
            header("Location: index.php");
            exit;
        }

    } else {
        $_SESSION['login_error'] = "Email o contraseña incorrectos.";
        header("Location: index.php");
        exit;
    }

    $stmt->close();

} else {
    header("Location: index.php");
    exit;
}

$conn->close();

?>