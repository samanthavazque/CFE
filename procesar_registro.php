<?php

require 'Config/Conexion.php'; // Conexión a la base de datos
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos obligatorios
    $campos = ['rp', 'nombre', 'password', 'estado', 'rol_nivel'];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo])) {
            echo "El campo '$campo' es obligatorio.";
            exit();
        }
    }

    $rp = trim($_POST['rp']);
    $nombre = trim($_POST['nombre']);
    $password = $_POST['password'];
    $estado = trim($_POST['estado']);
    $rol_nivel = trim($_POST['rol_nivel']);

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Asignar permisos según el nivel de rol
    $permisos = [];
    if ($rol_nivel == "Administrador") {
        $permisos = ['admin_permission_1', 'admin_permission_2'];
    } elseif ($rol_nivel == "Zona") {
        $permisos = ['zona_permission_1', 'zona_permission_2'];
    } elseif ($rol_nivel == "Consulta") {
        $permisos = ['consulta_permission_1', 'consulta_permission_2'];
    }
    $permisos_str = implode(',', $permisos);

    // Consulta preparada para insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (rp, nombre, password, estado, rol_nivel, permisos) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $rp, $nombre, $password_hash, $estado, $rol_nivel, $permisos_str);
        if ($stmt->execute()) {
            $_SESSION['rp'] = $rp;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['estado'] = $estado;
            $_SESSION['rol_nivel'] = $rol_nivel;
            $_SESSION['permisos'] = $permisos;
            header("Location: inicio.php");
            exit();
        } else {
            echo "Error en el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
    mysqli_close($conn);
}
?>