<!DOCTYPE html>
<html lang="en">

<!-- head -->
<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->

<!-- header -->

<link rel="stylesheet" href="/css/reset.css">
<link rel="stylesheet" href="/css/header.css">
<link rel="stylesheet" href="/css/crearRutina.css">
<!-- fin header -->

<body class="index-page">
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <main class="main">
        <div class="data-container">
            <?php include_once $content; ?>
        </div>
    </main>
    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>
    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->
</body>