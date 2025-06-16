<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CPICGYM</title>
    <link rel="stylesheet" href="css/login.css">
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Script de reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

    <!-- Contenedor para las formas animadas del fondo -->
    <div class="background-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <div class="login-container">
        <!-- Logo del SENA -->
        <div class="login-logo"></div>
        
        <h2>Iniciar Sesión</h2>

        <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>

        <form action="/login" method="post">
            <!-- Grupo de formulario con etiqueta flotante e icono -->
            <div class="form-group">
                <i class="input-icon fas fa-envelope"></i>
                <input type="email" id="email" name="email" required placeholder=" ">
                <label for="email">Correo Electrónico</label>
            </div>
            
            <!-- Grupo de formulario con etiqueta flotante e icono -->
            <div class="form-group">
                <i class="input-icon fas fa-lock"></i>
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Contraseña</label>
            </div>
            
            <!-- Widget de reCAPTCHA con tema oscuro -->
            <div class="form-group recaptcha-container">
                <div class="g-recaptcha" data-sitekey="6LeORj8rAAAAAKlEiLKILUKZpJf5RBxbvRijjty4" data-theme="dark"></div>
            </div>

            <div class="form-group">
                <button type="submit">Ingresar</button>
            </div>
        </form>
        <div class="extra-links">
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>
</html>