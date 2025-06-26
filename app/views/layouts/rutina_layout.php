<!DOCTYPE html>
<html lang="en">

<!-- head -->


<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

<!-- header -->
<header id="header" class="header dark-background d-flex flex-column">
    <?php include 'assets/config/header.php'; ?>
</header>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/header.css">
<!-- fin header -->
<style>
    .data-container {
        margin-left: 160px;
        padding: 10px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;
        box-sizing: border-box;
    }

    .card-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        /* Espacio entre tarjetas */
        justify-content: center;
        /* Centra las tarjetas horizontalmente */
        padding: 5px;
    }

    .form-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 2rem 1.5rem;
        margin-bottom: 1.5rem;
        width: 260px;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* 🔑 Esto distribuye el contenido verticalmente */
    }

    .card-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .card-image {
        width: 200px;
        height: auto;
        margin-bottom: 1rem;
        padding: 50px;
    }

    .card-title {
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .card-description {
        font-size: 0.9rem;
        color: #555;
    }

    .card-footer {
        text-align: center;
        margin-top: auto;
        /* 🔑 Empuja el botón hacia el fondo */
    }

    .card-footer button {
        width: 100%;
        padding: 10px;
        border: none;
        background-color: #000;
        color: #fff;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
    }

    .add-button {
        width: 180px;
        text-align: center;
        padding: 8px;
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-left: 15px;
        font-size: 1.2rem;
        border-radius: 8px;
        border: none;
        background-color: rgb(106, 106, 106);
        color: white;
        cursor: pointer;
        text-decoration: none;
        text-transform: none;
    }

    .button {
        margin-bottom: 20px;
    }

    .form-group {
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        width: 100%;
    }


    .container {
        margin-top: -40px;
        /* Esto podría necesitar ajuste si el header es fixed/sticky */
    }

    /* Opcional: si tu sidebar es colapsable */
    .sidebar-collapsed .data-container {
        margin-left: 80px;
        /* Ajusta si el menú se colapsa */
    }
</style>

<body class="index-page">




    <div class="data-container">
        <?php include_once $content; ?>
    </div>

</body>