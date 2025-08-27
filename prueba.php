<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include_once ('Config/Conexion.php');
    $sql = "SELECT c.nombre,f.numeroerrores,f.descripcion,f.solucionoperativa,f.soluciontecnica, f.poster FROM federal f INNER JOIN categoria c ON f.id_categoria = c.id";
    $query = mysqli_query($conn, $sql);

    while ($fila = mysqli_fetch_array($query)) {
        $cads = explode('?',$fila['poster']);
        echo '<img src ="'.$cads[0].'">';
    }

?>    
</body>
</html>
