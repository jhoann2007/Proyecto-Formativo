<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - Gymtech</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <style>
        .code-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        
        .code-inputs input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            border: 2px solid #444;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .code-inputs input:focus {
            border-color: #00a8ff;
            outline: none;
        }
        
        .verification-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .verification-info p {
            color: #ccc;
            font-size: 14px;
        }
    </style>
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
            <h1>Verificación</h1>
            <h1>Gym Tech</h1>
            <h1>SENA</h1>
        </div>

        <div class="form-container">
            <div class="login-form">
                <h2>Verificar Código</h2>

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

                <form action="/olvido-contrasenia/procesar-verificacion" method="post" id="verifyCodeForm">
                    <div class="verification-info">
                        <p>Hemos enviado un código de 6 dígitos a tu correo electrónico</p>
                        <p><strong><?php echo isset($_SESSION['email_recuperacion']) ? htmlspecialchars($_SESSION['email_recuperacion']) : ''; ?></strong></p>
                    </div>

                    <div class="code-inputs">
                        <input type="text" maxlength="1" name="digit1" id="digit1" required>
                        <input type="text" maxlength="1" name="digit2" id="digit2" required>
                        <input type="text" maxlength="1" name="digit3" id="digit3" required>
                        <input type="text" maxlength="1" name="digit4" id="digit4" required>
                        <input type="text" maxlength="1" name="digit5" id="digit5" required>
                        <input type="text" maxlength="1" name="digit6" id="digit6" required>
                    </div>

                    <input type="hidden" id="fullCode" name="codigo">

                    <div class="form-group">
                        <button type="submit" class="btn01"><span>Verificar</span></button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const codeInputs = document.querySelectorAll('.code-inputs input');
            const verificationForm = document.getElementById('verifyCodeForm');
            
            // Manejar la navegación entre los campos de código
            codeInputs.forEach((input, index) => {
                // Auto focus al primer input
                if (index === 0) {
                    setTimeout(() => {
                        input.focus();
                    }, 100);
                }
                
                input.addEventListener('input', function() {
                    if (this.value.length === this.maxLength) {
                        if (index < codeInputs.length - 1) {
                            codeInputs[index + 1].focus();
                        }
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    // Si se presiona backspace y el campo está vacío, ir al campo anterior
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        codeInputs[index - 1].focus();
                    }
                });
            });
            
            // Manejar el envío del formulario
            verificationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = (document.querySelector('[name=email]')?.value || (document.querySelector('.verification-info strong')?.textContent || '')).trim();
                let code = '';
                
                codeInputs.forEach(input => {
                    code += input.value;
                });
                
                // Mostrar loading
                Swal.fire({
                    title: 'Verificando...',
                    text: 'Comprobando el código ingresado',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Determinar base del API si corremos frontend en 8080 (backend Apache)
                const apiBase = (window.location.port === '8080') ? 'http://localhost/Proyecto-Formativo/public' : '';
                // Enviar solicitud AJAX al endpoint JSON correcto
                fetch(`${apiBase}/olvido-contrasenia/procesar-verificacion`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    credentials: 'include',
                    body: 'email=' + encodeURIComponent(email) + '&codigo=' + encodeURIComponent(code)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Código verificado!',
                            text: 'Ahora puedes cambiar tu contraseña.',
                            confirmButtonText: 'Continuar',
                            customClass: {
                                popup: 'swal2-dark-popup',
                                title: 'swal2-dark-title',
                                content: 'swal2-dark-content',
                                confirmButton: 'swal2-dark-button'
                            }
                        }).then(() => {
                            // Redirigir a la página de cambio de contraseña
                            const apiBase = (window.location.port === '8080') ? 'http://localhost/Proyecto-Formativo/public' : '';
                            window.location.href = `${apiBase}/olvido-contrasenia/cambiar?email=` + encodeURIComponent(email) + '&codigo=' + encodeURIComponent(code);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: data.message || 'Código inválido o expirado.',
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
                        text: 'Ha ocurrido un error al procesar la solicitud.',
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
        });
    </script>
</body>
</html>