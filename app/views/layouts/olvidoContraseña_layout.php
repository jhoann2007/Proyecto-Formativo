<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="/css/OlvidoContraseña.css">
</head>

<body>



    <div class="login-container">
        <a id="ayuda" href="ayuda">?</a>
        <img src="../img/logo-sena-negro-jpg-2022-1024x1004-removebg-preview.png" alt="SENA Logo" class="logo">
        <form>
            <input type="email" placeholder="Correo electrónico" id="correo">
            <input type="password" placeholder="Número de documento" id="documento">
            <input type="password" placeholder="Copiar nueva contraseña" id="nueva">

            <a href="/codigo">
                <button type="button" class="btn">Restablecer contraseña</button>
            </a>
        </form>
    </div>

</body>

</html>