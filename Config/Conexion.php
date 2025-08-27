<?php
$db_host = "localhost"; // Servidor de base de datos
$db_user = "root";      // Usuario de la base de datos
$db_password = "";      // Contraseña de la base de datos
$db_name = "comision";  // Nombre de la base de datos

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Forzar la conexión a usar UTF-8
mysqli_set_charset($conn, 'utf8mb4');
?>
