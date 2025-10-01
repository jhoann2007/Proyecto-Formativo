<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'assets/config/head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización</title>
    <!-- Cargar estilos en el orden correcto -->
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/main.css"> <!-- Estilos principales -->
    <link rel="stylesheet" href="/css/header.css"> <!-- Estilos específicos del header -->
    <link rel="stylesheet" href="/css/crearRutina.css"> <!-- Estilos específicos de la página -->
</head>
<body>
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>

    <main class="main-content">
        <div class="content-wrapper">
            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>
    
    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->
</body>
</html>