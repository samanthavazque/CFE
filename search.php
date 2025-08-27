<?php
if (isset($_GET['q'])) {
    $query = $_GET['q'];

    // Realiza la búsqueda en tu base de datos o en tus datos
    // Ejemplo (simulado):
    $results = array("Resultado 1", "Resultado 2", "Resultado 3");

    // Muestra los resultados encontrados
    foreach ($results as $result) {
        echo "<p>$result</p>";
    }
}
?>