<?php
session_start();
require 'Config/Conexion.php';

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // Validar si el ID existe
    $result = $conn->query("SELECT * FROM errores WHERE id=$id");
    if ($result->num_rows === 0) {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "El ID no existe en la base de datos.";
        header('Location: inicio.php');
        exit;
    }

    // Intentar eliminar el registro
    $sql = "DELETE FROM errores WHERE id=$id";
    if ($conn->query($sql)) {
        // Eliminar archivos asociados si existen
        $dir = "posters";
        $poster = $dir . '/' . $id . '.jpg';
        $video = $dir . '/' . $id . '.mp4';

        if (file_exists($poster)) unlink($poster);
        if (file_exists($video)) unlink($video);

        $_SESSION['color'] = "success";
        $_SESSION['msg'] = "Registro eliminado correctamente.";
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al eliminar el registro: " . $conn->error;
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "ID inválido.";
}

header('Location: inicio.php');
exit;
?>