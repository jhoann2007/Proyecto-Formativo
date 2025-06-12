<!DOCTYPE html>
<html lang="en">

<!-- head -->

<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

<style>
    .data-container {
        margin-left: 150px;
        padding: 45px;
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
        padding: 2rem;
    }

    .form-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 3rem 2.0rem;
        margin-bottom: 1.5rem;
        width: 260px;
        min-height: 400px;
        /* Altura mínima para que sea más alta */
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    button {
        width: 180px; 
        text-align: center;
        padding: 8px;
        display: flex;
        justify-content: center;
        margin-bottom: 0.1rem;
        font-size: 1.2rem;
        border-radius: 8px;
        border: none;
        background-color:rgb(106, 106, 106);
        color: white;
        cursor: pointer;
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

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->


    <div class="data-container">
        <?php include_once $content; ?>
    </div>

</body>