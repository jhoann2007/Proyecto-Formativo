<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Gymtech</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
</head>
<body>
    <div class="background-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <img src="/img/logo_sena-removebg.png" alt="">              
            </div>
            <h1>Cambiar</h1>
            <h1>Contraseña</h1>
            <h1>SENA</h1>
        </div>

        <div class="form-container">
            <div class="login-form">
                <h2>Nueva Contraseña</h2>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <form action="/olvido-contrasenia/procesar-cambio" method="post" id="changePasswordForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="nueva_contrasenia" name="nueva_contrasenia" required placeholder=" " minlength="6">
                        <label for="nueva_contrasenia">Nueva Contraseña</label>
                    </div>
                    
                    <div class="form-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="confirmar_contrasenia" name="confirmar_contrasenia" required placeholder=" " minlength="6">
                        <label for="confirmar_contrasenia">Confirmar Contraseña</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn01"><span>Cambiar Contraseña</span></button>
                    </div>
                </form>
                <div class="extra-links">
                    <a href="/login">Volver a Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        // Si el frontend corre en 8080, apuntar al backend Apache
        const changeForm = document.getElementById('changePasswordForm');
        if (window.location.port === '8080') {
            changeForm.action = 'http://localhost/Proyecto-Formativo/public/olvido-contrasenia/procesar-cambio';
        }
    </script>
</body>
</html>