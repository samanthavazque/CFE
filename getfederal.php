<?php

require 'Config/Conexion.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT id, id_categoria, numeroerrores, descripcion, solucionoperativa, soluciontecnica, poster, video FROM errores WHERE id=$id LIMIT 1";
$resultado = $conn->query($sql);
$rows = $resultado->num_rows;

$errores = [];

if ($rows > 0) {
    $errores = $resultado->fetch_array();
}

echo json_encode($errores, JSON_UNESCAPED_UNICODE);


?>



