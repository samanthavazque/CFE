<?php
require 'Config/Conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado los datos esperados
    if (isset($_POST['rp']) && isset($_POST['nombre']) && isset($_POST['zona']) && isset($_POST['nivel'])) {
        $rp = $_POST['rp'];
        $nombre = $_POST['nombre'];
        $opcionSeleccionada = $_POST['zona'];
        $opcion2Seleccionada = $_POST['nivel'];

        $sql = "INSERT INTO usuarios (rp, nombre, zona, nivel) VALUES ('$rp', '$nombre', '$opcionSeleccionada', '$opcion2Seleccionada')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Por favor completa todos los campos";
    }
}

//header ("location:inicio.php");

$conn->close();

?>
