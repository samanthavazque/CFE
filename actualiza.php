<?php

session_start();

require 'Conexion.php';

$id = $conn->real_escape_string($_POST['idd']);
$categoria = $conn->real_escape_string($_POST['categoria']);
$numeroerrores = $conn->real_escape_string($_POST['numeroerrores']);
$descripcion = $conn->real_escape_string($_POST['descripcion']);
$solucionoperativa = $conn->real_escape_string($_POST['solucionoperativa']);
$soluciontecnica = $conn->real_escape_string($_POST['soluciontecnica']);
$imag = $conn->real_escape_string($_POST['img_poster']);

$sql = "UPDATE errores SET id_categoria ='$categoria', numeroerrores = '$numeroerrores', descripcion = '$descripcion', solucionoperativa ='$solucionoperativa', soluciontecnica ='$soluciontecnica' WHERE id=$id";
if ($conn->query($sql)) {
    $cantidad = count($_FILES['file']['name']);
    $bandera = 0;
    $nombreImgs = "";
    for ($i = 0; $i < $cantidad; $i += 1) {
        $filename = $_FILES['file']['name'][$i];            
        $extension = 'image/'. pathinfo($filename, PATHINFO_EXTENSION);
        
        if ($_FILES['file']['error'][$i] == UPLOAD_ERR_OK) {
            $permitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
            
            if (in_array($extension, $permitidos)) {
                $dir = "posters";
                $info_img = pathinfo($_FILES['file']['name'][$i]);
                $extension = $info_img['extension'];

                $poster = $dir . '/' .$id .'_' . $i . '.' . $extension;

                if (!file_exists($dir)) {
                    mkdir($dir, 0777);
                }

                if (!move_uploaded_file($_FILES['file']['tmp_name'][$i], $poster)) {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Error al guardar imagen";
                } else {
                    $bandera += 1;
                    if ($i == $cantidad - 1)
                        $nombreImgs .= $poster;
                    else
                        $nombreImgs .= $poster . ',';
                }
            } else {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Formato de imagen no permitido. Solo se permiten imágenes jpg, jpeg, png, y gif.";
            }
        }
    }
    if($bandera > 0){
        $sql2 = "UPDATE errores SET poster = '$nombreImgs' WHERE id = $id";
        if ($conn->query($sql2)) {
            // $_SESSION['color'] = "danger";
            // $_SESSION['msg'] =  $nombreImgs .",". $bandera ."<br>";
            $_SESSION['color'] = "success";
            $_SESSION['msg'] = "Registro guardado";
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] = "Error al guardar el error";
        }
    }
    else{
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "No se mandaron imagenes a guardar";
    }

    if ($_FILES['video']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("video/mp4", "video/MP4");
        if (in_array($_FILES['video']['type'], $permitidos)) {

            $dir = "posters";

            $info_vid = pathinfo($_FILES['img_poster']['name']);
            $info_vid['extension'];

            $video = $dir . '/' . $id . '.mp4';

            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }

            if (!move_uploaded_file($_FILES['video']['tmp_name'], $video)) {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al guardar el video";
            }
         else{
            $sql2="UPDATE errores SET video = '$video' WHERE id = $id";
            if ($conn->query($sql2)) {
                $_SESSION['color'] = "success";
                $_SESSION['msg'] = "Registro actualizado";
            }
            else{
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] = "Error al guardar el error";
            }
        } 
    }else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de video no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al actualizar registro";
}


header('Location: consulta_portada.php');

?>