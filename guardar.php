<?php
session_start();
require 'Config/Conexion.php';

// Captura y sanitiza los datos enviados por POST
$categoria = $conn->real_escape_string($_POST['categoria']);
$numeroerrores = $conn->real_escape_string($_POST['numeroerrores']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$solucionoperativa = $conn->real_escape_string($_POST['solucionoperativa']);
$soluciontecnica = $conn->real_escape_string($_POST['soluciontecnica']);

// Inserción del registro principal en la tabla errores
$sql = "INSERT INTO errores (id_categoria, numeroerrores, descripcion, solucionoperativa, soluciontecnica, fecha_alta)
        VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $categoria, $numeroerrores, $descripcion, $solucionoperativa, $soluciontecnica);


if ($stmt->execute()) {
    $id = $stmt->insert_id; // Obtiene el ID del registro insertado
    $bandera = 0; // Indicador de éxito en la subida de archivos
    $nombreImgs = ""; // Almacena nombres de imágenes

    // Procesar imágenes
    if (isset($_FILES['file']) && count($_FILES['file']['name']) > 0) {
        $cantidad = count($_FILES['file']['name']);
        for ($i = 0; $i < $cantidad; $i++) {
            if ($_FILES['file']['error'][$i] == UPLOAD_ERR_OK) {
                $permitidos = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                $mime_type = mime_content_type($_FILES['file']['tmp_name'][$i]);

                if (in_array($mime_type, $permitidos)) {
                    $dir = "posters";
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777); // Crea la carpeta si no existe
                    }

                    $info_img = pathinfo($_FILES['file']['name'][$i]);
                    $extension = $info_img['extension'];
                    $poster = $dir . '/' . $id . '_' . $i . '.' . $extension;

                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $poster)) {
                        $bandera++;
                        $nombreImgs .= $poster . ',';
                    } else {
                        $_SESSION['msg'] .= "<br>Error al guardar la imagen: " . $_FILES['file']['name'][$i];
                    }
                } else {
                    $_SESSION['msg'] .= "<br>Formato de imagen no permitido: " . $_FILES['file']['name'][$i];
                }
            }
        }

        // Eliminar la última coma de la lista de nombres de imágenes
        $nombreImgs = rtrim($nombreImgs, ',');

        if ($bandera > 0) {
            $sql2 = "UPDATE errores SET poster = ? WHERE id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("si", $nombreImgs, $id);
            $stmt2->execute();
        } else {
            $_SESSION['msg'] .= "<br>No se guardaron imágenes.";
        }
    }

    // Procesar video
    if (isset($_FILES['video']) && $_FILES['video']['error'] == UPLOAD_ERR_OK) {
        $permitidos = ["video/mp4"];
        $mime_type = mime_content_type($_FILES['video']['tmp_name']);

        if (in_array($mime_type, $permitidos)) {
            $dir = "posters";
            if (!file_exists($dir)) {
                mkdir($dir, 0777); // Crea la carpeta si no existe
            }

            $video = $dir . '/' . $id . '.mp4';
            if (move_uploaded_file($_FILES['video']['tmp_name'], $video)) {
                $sql3 = "UPDATE errores SET video = ? WHERE id = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("si", $video, $id);
                $stmt3->execute();
            } else {
                $_SESSION['msg'] .= "<br>Error al guardar el video.";
            }
        } else {
            $_SESSION['msg'] .= "<br>Formato de video no permitido.";
        }
    }

    // Éxito en el registro
    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro guardado correctamente.";
} else {
    // Error en la inserción del registro principal
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al guardar el registro: " . $stmt->error;
}

// Redireccionar
header('Location: inicio.php');
?>