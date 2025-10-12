<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Código - Gymtech</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <style>
        .code-input {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .code-input input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
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
            <h1>Verificación de</h1>
            <h1>Código</h1>
            <h1>Gym Tech SENA</h1>
        </div>

        <div class="form-container">
            <div class="recovery-form active">
                <h2>Verificar Código</h2>
                <div class="error-message" id="verificationError" style="display: none;"></div>
                <div class="success-message" id="verificationSuccess" style="display: none;"></div>

                <div class="recovery-info">
                    <p>Ingresa el código de verificación que hemos enviado a tu correo electrónico</p>
                </div>

                <form id="verificationForm">
                    <input type="hidden" id="email" name="email" value="">
                    
                    <div class="code-input">
                        <input type="text" maxlength="1" class="code-digit" data-index="0">
                        <input type="text" maxlength="1" class="code-digit" data-index="1">
                        <input type="text" maxlength="1" class="code-digit" data-index="2">
                        <input type="text" maxlength="1" class="code-digit" data-index="3">
                        <input type="text" maxlength="1" class="code-digit" data-index="4">
                        <input type="text" maxlength="1" class="code-digit" data-index="5">
                    </div>
                    
                    <input type="hidden" id="codigo" name="codigo">

                    <div class="form-group">
                        <button type="submit" class="btn02"><span>Verificar Código</span></button>
                    </div>
                </form>
                <div class="extra-links">
                    <a href="/recuperar-contrasenia">Volver a solicitar código</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el email de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const email = urlParams.get('email');
            
            if (!email) {
                window.location.href = '/recuperar-contrasenia';
                return;
            }
            
            document.getElementById('email').value = email;
            
            // Configurar los inputs del código
            const codeInputs = document.querySelectorAll('.code-digit');
            
            codeInputs.forEach((input, index) => {
                // Auto focus al siguiente input
                input.addEventListener('input', function() {
                    if (this.value.length === 1) {
                        const nextInput = document.querySelector(`.code-digit[data-index="${index + 1}"]`);
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                });
                
                // Permitir borrar y volver al input anterior
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0) {
                        const prevInput = document.querySelector(`.code-digit[data-index="${index - 1}"]`);
                        if (prevInput) {
                            prevInput.focus();
                        }
                    }
                });
            });
            
            // Manejar el envío del formulario
            const verificationForm = document.getElementById('verificationForm');
            
            verificationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Recopilar el código completo
                let codigo = '';
                codeInputs.forEach(input => {
                    codigo += input.value;
                });
                
                document.getElementById('codigo').value = codigo;
                
                if (codigo.length !== 6) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Código incompleto',
                        text: 'Por favor, ingresa el código completo de 6 dígitos'
                    });
                    return;
                }
                
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Verificando código...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar solicitud al servidor
                fetch('/recuperar-contrasenia/verificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'email=' + encodeURIComponent(email) + '&codigo=' + encodeURIComponent(codigo)
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Código verificado!',
                            text: data.message,
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            // Redirigir a la página de cambio de contraseña
                            window.location.href = '/recuperar-contrasenia/nueva-contrasenia?email=' + encodeURIComponent(email) + '&codigo=' + encodeURIComponent(codigo);
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