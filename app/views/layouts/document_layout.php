<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- head -->

<head>
    <?php
    // session_start(); // Movido arriba
    include 'assets/config/head.php';
    ?>

    <meta charset="UTF-8">
    <title>Tabla Aprendices</title>
    <style>
        .data-container {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            box-sizing: border-box;
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 3rem 2.0rem;
            margin-bottom: 1.5rem;
            width: 415px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
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




</head>
<!-- fin head -->

<body>
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>

    <div class="container">


        <div class="data-container">
            <?php include_once $content; ?>
        </div>

    </div>
</body>