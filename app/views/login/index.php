<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CPICGYM</title>
    <link rel="stylesheet" href="css/login.css">
    <!-- Script de reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <?php
        session_start(); // Asegúrate que session_start() esté al inicio
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>

        <form action="/login" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <!-- Widget de reCAPTCHA -->
            <div class="form-group">
                <!-- Reemplaza TU_SITE_KEY_AQUI con tu Clave del sitio -->
                <div class="g-recaptcha" data-sitekey="6LeORj8rAAAAAKlEiLKILUKZpJf5RBxbvRijjty4"></div>
            </div>

            <div class="form-group">
                <button type="submit">Ingresar</button>
            </div>
        </form>
    </div>
</body>
</html>