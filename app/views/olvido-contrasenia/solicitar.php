<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Gymtech</title>
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
            <h1>Recuperar</h1>
            <h1>Contraseña</h1>
            <h1>SENA</h1>
        </div>

        <div class="form-container">
            <div class="login-form">
                <h2>Recuperar Contraseña</h2>
                <p style="color: #ccc; text-align: center; margin-bottom: 20px;">
                    Ingresa tu correo electrónico y te enviaremos un código de verificación
                </p>

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

                <form action="/olvido-contrasenia/procesar-solicitud" method="post" id="forgotPasswordForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn01"><span>Enviar Código</span></button>
                    </div>

                    <div class="form-group">
                        <a href="/login" class="link">Volver al Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        const form = document.getElementById('forgotPasswordForm');
        // Si estamos en 8080, redirigir el action al backend Apache
        if (window.location.port === '8080') {
            form.action = 'http://localhost/Proyecto-Formativo/public/olvido-contrasenia/procesar-solicitud';
        }
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            if (!email) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor ingrese su correo electrónico'
                });
                return;
            }
            
            if (!email.includes('@')) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor ingrese un correo electrónico válido'
                });
                return;
            }
        });
    </script>

    <style>
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        
        .alert-error {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff0000;
            color: #ff6b6b;
        }
        
        .alert-success {
            background-color: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #51cf66;
        }
        
        .link {
            color: #00a8ff;
            text-decoration: none;
            text-align: center;
            display: block;
            margin-top: 15px;
        }
        
        .link:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>