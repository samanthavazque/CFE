<?php

session_start();
require 'Config/Conexion.php';

// Validar datos recibidos
$id = isset($_POST['idd']) ? $conn->real_escape_string($_POST['idd']) : '';
$categoria = isset($_POST['categoria']) ? $conn->real_escape_string($_POST['categoria']) : '';
$numeroerrores = isset($_POST['numeroerrores']) ? $conn->real_escape_string($_POST['numeroerrores']) : '';
$descripcion = isset($_POST['descripcion']) ? $conn->real_escape_string($_POST['descripcion']) : '';
$solucionoperativa = isset($_POST['solucionoperativa']) ? $conn->real_escape_string($_POST['solucionoperativa']) : '';
$soluciontecnica = isset($_POST['soluciontecnica']) ? $conn->real_escape_string($_POST['soluciontecnica']) : '';

// Consulta para actualizar los datos principales
$sql = "UPDATE errores SET id_categoria = ?, numeroerrores = ?, descripcion = ?, solucionoperativa = ?, soluciontecnica = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $categoria, $numeroerrores, $descripcion, $solucionoperativa, $soluciontecnica, $id);

// Ejecutar la consulta y comprobar si se realizó con éxito
if ($stmt->execute()) {
    // Subir imágenes
    $cantidad = (isset($_FILES['file']['name']) && is_array($_FILES['file']['name'])) ? count($_FILES['file']['name']) : 0;
    $bandera = 0;
    $nombreImgs = "";
    if ($cantidad > 0) {
        for ($i = 0; $i < $cantidad; $i++) {
            $filename = $_FILES['file']['name'][$i];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (isset($_FILES['file']['error'][$i]) && $_FILES['file']['error'][$i] == UPLOAD_ERR_OK) {
                $permitidos = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                $mime_type = mime_content_type($_FILES['file']['tmp_name'][$i]);
                if (in_array($mime_type, $permitidos)) {
                    $dir = "posters";
                    $info_img = pathinfo($filename);
                    $extension = $info_img['extension'];
                    $poster = $dir . '/' . uniqid($id . '_') . '.' . $extension;
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true); // Crear el directorio si no existe
                    }
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $poster)) {
                        $bandera += 1;
                        $nombreImgs .= $poster . ($i == $cantidad - 1 ? '' : ',');
                    } else {
                        $_SESSION['color'] = "danger";
                        $_SESSION['msg'] .= "<br>Error al guardar imagen: $filename";
                    }
                } else {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Formato de imagen no permitido: $filename. Solo se permiten imágenes jpg, jpeg, png, y gif.";
                }
            }
        }
    }

    // Si se subieron imágenes, actualizar la base de datos
    if ($bandera > 0) {
        $sql2 = "UPDATE errores SET poster = ? WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("si", $nombreImgs, $id);
        $stmt2->execute();
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] .= "<br>No se subieron imágenes.";
    }

    // Subir video si está presente
    if ($_FILES['video']['error'] == UPLOAD_ERR_OK) {
        $permitidos_video = ["video/mp4", "video/MP4"];
        if (in_array($_FILES['video']['type'], $permitidos_video)) {
            $dir = "posters";
            $video = $dir . '/' . $id . '.mp4';

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true); // Crear el directorio si no existe
            }

            if (move_uploaded_file($_FILES['video']['tmp_name'], $video)) {
                // Actualizar video en la base de datos
                $sql3 = "UPDATE errores SET video = ? WHERE id = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("si", $video, $id);
                $stmt3->execute();
            } else {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar el video.";
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de video no permitido. Solo se permite mp4.";
        }
    }

    // Mensaje de éxito
    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro actualizado correctamente.";

} else {
    // Mensaje de error si no se actualizó correctamente
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al actualizar el registro.";
}

// Redirigir al usuario
header('Location: zona_portada.php');
exit;

?>