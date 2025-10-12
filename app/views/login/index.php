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

                <form action="/olvido-contrasenia/solicitar" method="post" id="recoveryForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="recoveryEmail" name="email" required placeholder=" ">
                        <label for="recoveryEmail">Correo Electrónico</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn02"><span>Enviar Código</span></button>
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

            // Manejar el envío del formulario de recuperación
            if (recoveryForm) {
                recoveryForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const email = document.getElementById('recoveryEmail').value;
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Procesando...',
                        text: 'Enviando código de recuperación',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Determinar base de la API: si la app se sirve en 8080, apuntar a 8000
                    const apiBase = (window.location.port === '8080') ? 'http://localhost:8000' : '';

                    // Enviar solicitud AJAX al endpoint que responde JSON
                    fetch(`${apiBase}/olvido-contrasenia/procesar-solicitud`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'email=' + encodeURIComponent(email)
                    })
                    .then(async (response) => {
                        let data = null;
                        try {
                            data = await response.json();
                        } catch (e) {
                            // Si no es JSON, continuar con manejo de error
                        }
                        if (!response.ok) {
                            const msg = (data && data.message) ? data.message : `Error ${response.status}`;
                            throw new Error(msg);
                        }
                        return data || { success: false, message: 'Respuesta inválida del servidor.' };
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Código enviado!',
                                text: 'Se ha enviado un código de verificación a tu correo electrónico.',
                                confirmButtonText: 'Continuar',
                                customClass: {
                                    popup: 'swal2-dark-popup',
                                    title: 'swal2-dark-title',
                                    content: 'swal2-dark-content',
                                    confirmButton: 'swal2-dark-button'
                                }
                            }).then(() => {
                                // Redirigir a la página de verificación (usar base si es 8080)
                                const apiBase = (window.location.port === '8080') ? 'http://localhost:8000' : '';
                                window.location.href = `${apiBase}/olvido-contrasenia/verificar?email=` + encodeURIComponent(email);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: data.message || 'Ha ocurrido un error al enviar el código.',
                                confirmButtonText: 'Entendido',
                                customClass: {
                                    popup: 'swal2-dark-popup',
                                    title: 'swal2-dark-title',
                                    content: 'swal2-dark-content',
                                    confirmButton: 'swal2-dark-button'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: (error && error.message) ? error.message : 'Ha ocurrido un error al procesar la solicitud.',
                            confirmButtonText: 'Entendido',
                            customClass: {
                                popup: 'swal2-dark-popup',
                                title: 'swal2-dark-title',
                                content: 'swal2-dark-content',
                                confirmButton: 'swal2-dark-button'
                            }
                        });
                    });
                });
            }

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