<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cpicgym"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if (!$conn->set_charset("utf8mb4")) {
    // Manejar el error si es necesario
    // printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", $conn->error);
}


?>