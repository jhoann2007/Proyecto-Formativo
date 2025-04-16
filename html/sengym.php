<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sengym - SENA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Íconos opcionales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .logo img {
            width: 150px;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 40px auto;
        }

        .btn {
            width: 100%;
        }

        .boton-ayuda {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 24px;
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <div class="container text-center mt-5">
        <div class="logo mb-3">
            <a href="https://oferta.senasofiaplus.edu.co/sofia-oferta/">
                <img src="../img/logo-sena-negro-jpg-2022-1024x1004-removebg-preview.png" alt="Logo SENA" class="img-fluid">
            </a>
        </div>
        <p class="lead">Sengym es el aplicativo de acceso al gimnasio del SENA ubicado en la sede de Maltería-Manizales.</p>
        <p>Dele click para descargar</p>
        <a href="inicioDeSesion.php" class="btn btn-primary mb-4">Descargar Ahora</a>
    </div>

    <div class="login-container">
        <div class="text-center mb-4">
            <img src="../img/logo-sena-negro-jpg-2022-1024x1004-removebg-preview.png" alt="SENA Logo" class="img-fluid" style="width: 80px;">
            <h4 class="mt-2">Ingreso al Sistema</h4>
        </div>

        <form>
            <div class="mb-3">
                <label for="tipo-documento" class="form-label">Tipo de documento</label>
                <select id="tipo-documento" class="form-select">
                    <option value="cc">Cédula de Ciudadanía</option>
                    <option value="ti">Tarjeta de Identidad</option>
                    <option value="ce">Cédula de Extranjería</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="documento" class="form-label">Número de documento</label>
                <input type="text" id="documento" class="form-control" placeholder="Número de documento">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" class="form-control" placeholder="Contraseña">
            </div>

            <div class="mb-3 text-end">
                <a href="OlvidoContraseña.php" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
            </div>

            <a href="../iPortfolio/index.php" class="btn btn-success w-100">Ingresar</a>

        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>