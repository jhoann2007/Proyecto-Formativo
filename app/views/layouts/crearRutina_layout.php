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
    margin-left: 120px; /* igual que el sidebar */
    padding: 15px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center; /* centra horizontalmente */
    justify-content: flex-start;
    box-sizing: border-box;
}

.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 200%;
    margin-top: 50px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 12px;
    gap: 10px;
}

.submit-button, .cancel-button {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    background: #222;
    color: #fff;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
}


.cancel-button {
    background: #888;
}

.submit-button:hover {
    background: #0056b3;
}

.create-form textarea {
    min-height: 200px;   /* Puedes aumentar este valor según lo que necesites */
    resize: vertical;    /* Permite al usuario agrandar si quiere */
    font-size: 1rem;
    padding: 8px;
}

.create-form {
    background: #fff;
    padding: 32px 24px;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    min-width: 350px;
    max-width: 400px;
    width: 100%;
    min-height: 400px; /* Ajusta según lo que necesites */
    display: flex;
    flex-direction: column;
    
}

.form-actions {
    margin-top: auto; /* Empuja los botones al fondo */
    display: flex;
    gap: 16px;
    justify-content: center;
}
</style>

<body class="index-page">


    <div class="data-container">
        <?php include_once $content; ?>
    </div>

</body>