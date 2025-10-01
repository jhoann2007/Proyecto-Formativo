<!DOCTYPE html>
<html lang="en">

<!-- head -->
<head>
    <?php include 'assets/config/head.php'; ?>
</head>
<!-- fin head -->


<link rel="stylesheet" href="/css/reset.css">
<link rel="stylesheet" href="/css/header.css">

<link rel="stylesheet" href="/css/rutina.css">

<body class="index-page">
    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <?php include 'assets/config/header.php'; ?>
    </header>
    <!-- fin header -->
    <main class="main">
        <div class="data-container">
            <?php include_once $content; ?>
        </div>
    </main>
    <!-- footer -->
    <footer id="footer" class="footer position-relative light-background">
        <?php include 'assets/config/footer.php'; ?>
    </footer>
    <!-- fin footer -->

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

</body>