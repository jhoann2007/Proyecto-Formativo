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

    <div class="container" id="formContainer">
        <div class="logo-section">
            <div class="logo">
                <img src="/img/logo_sena-removebg.png" alt="">              
            </div>
            <h1>Recuperación de</h1>
            <h1>Contraseña</h1>
            <h1>Gym Tech SENA</h1>
        </div>

        <div class="form-container">
            <div class="recovery-form active">
                <h2>Recuperar Contraseña</h2>
                <div class="error-message" id="recoveryError" style="display: none;"></div>
                <div class="success-message" id="recoverySuccess" style="display: none;"></div>

                <div class="recovery-info">
                    <p>Ingresa tu correo electrónico para recibir un código de verificación</p>
                </div>

                <form id="recoveryForm">
                    <div class="form-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder=" ">
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn02"><span>Enviar Código</span></button>
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
            const recoveryForm = document.getElementById('recoveryForm');
            const recoveryError = document.getElementById('recoveryError');
            const recoverySuccess = document.getElementById('recoverySuccess');

            recoveryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value;
                
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Enviando código...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Base dinámica: si la UI corre en 8080, apuntar a 8000
                const apiBase = (window.location.port === '8080') ? 'http://localhost:8000' : '';
                // Enviar solicitud al servidor (endpoint correcto)
                fetch(`${apiBase}/olvido-contrasenia/procesar-solicitud`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'email=' + encodeURIComponent(email)
                })
                .then(async (response) => {
                    let data = null;
                    try { data = await response.json(); } catch (e) {}
                    if (!response.ok) {
                        const msg = (data && data.message) ? data.message : `Error ${response.status}`;
                        throw new Error(msg);
                    }
                    return data || { success: false, message: 'Respuesta inválida del servidor.' };
                })
                .then(data => {
                    Swal.close();
                    
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Código enviado!',
                            text: data.message,
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            // Redirigir a la página de verificación
                            window.location.href = '/olvido-contrasenia/verificar?email=' + encodeURIComponent(email);
                        });
                    } else {
                        // Mostrar mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al procesar la solicitud'
                    });
                });
            });
        });
    </script>
</body>
</html>