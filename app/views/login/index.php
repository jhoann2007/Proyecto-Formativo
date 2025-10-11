<?php
        session_start();
        // if (isset($_SESSION['login_error'])) {
        //     echo '<p class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
        //     unset($_SESSION['login_error']);
        // }
        ?>

</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gymtech</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
</head>
<body>
    <div class="background-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <div class="container" id="formContainer">
        <div class="logo-section">
            <div class="logo">
                <img src="img/logo_sena-removebg.png" alt="">              
            </div>
            <h1>Bienvenido a</h1>
            <h1>Gym Tech</h1>
            <h1>SENA</h1>
        </div>

        <div class="form-container">
            <div class="login-form">
                <h2>Iniciar Sesión</h2>

                <form action="/login" method="post" id="loginForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <div class="form-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder=" ">
                        <label for="password">Contraseña</label>
                    </div>

                    <div class="form-group recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6LeORj8rAAAAAKlEiLKILUKZpJf5RBxbvRijjty4" data-theme="dark"></div>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn01"><span>Ingresar</span></button>
                    </div>
                </form>
                <div class="extra-links">
                    <a id="showRecovery">¿Olvidaste tu contraseña?</a>
                </div>
            </div>

            <div class="recovery-form">
                <h2>Recuperar Contraseña</h2>
                <div class="error-message" id="recoveryError" style="display: none;"></div>
                <div class="success-message" id="recoverySuccess" style="display: none;"></div>

                <div class="recovery-info">
                    <p>Digita Tu Correo De Recuperacion</p>
                </div>

                <form id="recoveryForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn02"><span>Verificar Código</span></button>
                    </div>
                </form>
                <div class="extra-links">
                    <a id="showLogin">Volver a Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formContainer = document.getElementById('formContainer');
            const showRecovery = document.getElementById('showRecovery');
            const showLogin = document.getElementById('showLogin');
            const loginForm = document.getElementById('loginForm');
            const recoveryForm = document.getElementById('recoveryForm');
            const recoveryError = document.getElementById('recoveryError');
            const recoverySuccess = document.getElementById('recoverySuccess');
            const codeInputs = document.querySelectorAll('.code-inputs input');

            showRecovery.addEventListener('click', function() {
                formContainer.classList.add('recovery-active');
            });

            showLogin.addEventListener('click', function() {
                formContainer.classList.remove('recovery-active');
            });

            <?php
            if (isset($_SESSION['login_error'])) {
                echo "
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '" . htmlspecialchars($_SESSION['login_error']) . "',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'swal2-dark-popup',
                        title: 'swal2-dark-title',
                        content: 'swal2-dark-content',
                        confirmButton: 'swal2-dark-button'
                    }
                });
                ";
                unset($_SESSION['login_error']);
            }
            ?>
        });
    </script>
</body>
</html>