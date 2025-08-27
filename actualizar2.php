<?php
session_start();
require 'Config/Conexion.php';


$id = isset($_POST['idd']) ? $conn->real_escape_string($_POST['idd']) : '';
$categoria = isset($_POST['categoria']) ? $conn->real_escape_string($_POST['categoria']) : '';
$numeroerrores = isset($_POST['numeroerrores']) ? $conn->real_escape_string($_POST['numeroerrores']) : '';
$descripcion = isset($_POST['descripcion']) ? $conn->real_escape_string($_POST['descripcion']) : '';
$solucionoperativa = isset($_POST['solucionoperativa']) ? $conn->real_escape_string($_POST['solucionoperativa']) : '';
$soluciontecnica = isset($_POST['soluciontecnica']) ? $conn->real_escape_string($_POST['soluciontecnica']) : '';
$imag = isset($_POST['img_poster']) ? $conn->real_escape_string($_POST['img_poster']) : '';

// Validar que el ID exista antes de continuar
if (empty($id)) {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "ID no recibido. No se puede actualizar el registro.";
    header('Location: inicio.php');
    exit;
}

// Actualiza los datos principales
$sql = "UPDATE errores SET id_categoria ='$categoria', numeroerrores = '$numeroerrores', descripcion = '$descripcion', solucionoperativa ='$solucionoperativa', soluciontecnica ='$soluciontecnica' WHERE id=$id";
if ($conn->query($sql)) {
    $cantidad = (isset($_FILES['file']['name']) && is_array($_FILES['file']['name'])) ? count($_FILES['file']['name']) : 0;
    $bandera = 0;
    $nombreImgs = "";

    // Revisa si hay archivos
    if ($cantidad > 0) {
        for ($i = 0; $i < $cantidad; $i++) {
            $filename = $_FILES['file']['name'][$i];            
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            
            if ($_FILES['file']['error'][$i] == UPLOAD_ERR_OK) {
                $permitidos = array("jpg", "jpeg", "png", "gif");
                
                if (in_array($extension, $permitidos)) {
                    $dir = "posters";
                    $poster = $dir . '/' .$id .'_' . $i . '.' . $extension;

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }

                    if (!move_uploaded_file($_FILES['file']['tmp_name'][$i], $poster)) {
                        $_SESSION['color'] = "danger";
                        $_SESSION['msg'] .= "<br>Error al guardar imagen $i";
                    } else {
                        $bandera += 1;
                        $nombreImgs .= $poster . ($i == $cantidad - 1 ? '' : ',');
                    }
                } else {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Formato de imagen no permitido en archivo $i. Solo se permiten imágenes jpg, jpeg, png, y gif.";
                }
            }
        }
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "No se mandaron imágenes a guardar";
    }

    // Si se guardaron imágenes, actualiza la base de datos
    if ($bandera > 0) {
        $sql2 = "UPDATE errores SET poster = '$nombreImgs' WHERE id = $id";
        if ($conn->query($sql2)) {
            $_SESSION['color'] = "success";
            $_SESSION['msg'] = "Registro guardado";
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] = "Error al guardar imágenes";
        }
    }

    // Subida de video
    if (isset($_FILES['video']) && $_FILES['video']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("video/mp4", "video/MP4");
        if (in_array($_FILES['video']['type'], $permitidos)) {
            $dir = "posters";
            $video = $dir . '/' . $id . '.mp4';
            // Eliminar el video anterior si existe
            if (file_exists($video)) {
                unlink($video);
            }
            if (!move_uploaded_file($_FILES['video']['tmp_name'], $video)) {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar el video";
            } else {
                $sql3 = "UPDATE errores SET video = '$video' WHERE id = $id";
                if ($conn->query($sql3)) {
                    // Si ya hay mensaje de éxito por imagen, lo complementa
                    if (isset($_SESSION['color']) && $_SESSION['color'] == "success") {
                        $_SESSION['msg'] .= "<br>Video actualizado correctamente.";
                    } else {
                        $_SESSION['color'] = "success";
                        $_SESSION['msg'] = "Video actualizado correctamente.";
                    }
                } else {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Error al guardar video en la base de datos";
                }
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de video no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al actualizar registro";
}

header('Location: inicio.php');
?>
