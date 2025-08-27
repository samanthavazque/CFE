<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="comision1.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <center><img src="logo.png" class="img-fluid" alt="Logo"></center>
        
        <?php
        require 'Config/Conexion.php'; // Conexión a la base de datos
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rp = $_POST['rp'];
            $nombre = $_POST['nombre'];
            $password = $_POST['password'];
            $estado = $_POST['estado'];
            $rol_nivel = $_POST['rol_nivel'];

            // Asignar permisos según el rol
            $permisos = [];
            if ($rol_nivel == "Administrador") {
                $permisos = ['admin_permission_1', 'admin_permission_2'];
            } elseif ($rol_nivel == "Zona") {
                $permisos = ['zona_permission_1', 'zona_permission_2'];
            } elseif ($rol_nivel == "Consulta") {
                $permisos = ['consulta_permission_1', 'consulta_permission_2'];
            }

            $permisos_str = implode(',', $permisos);

            // Insertar en la base de datos
            $query = "INSERT INTO usuarios (rp, nombre, password, estado, rol_nivel, permisos) VALUES ('$rp', '$nombre', '$password', '$estado', '$rol_nivel', '$permisos_str')";

            if (mysqli_query($conn, $query)) {
                echo '<div class="alert alert-success text-center" role="alert">
                        <h4 class="alert-heading">¡Registro exitoso!</h4>
                        <p>El usuario ha sido registrado correctamente.</p>
                        <hr>
                        <a href="inicio.php" class="btn btn-success">Regresar al inicio</a>
                      </div>';
            } else {
                echo '<div class="alert alert-danger text-center" role="alert">
                        <h4 class="alert-heading">Error en el registro</h4>
                        <p>No se pudo registrar el usuario. Por favor, inténtalo de nuevo.</p>
                        <hr>
                        <a href="registro.php" class="btn btn-danger">Intentar de nuevo</a>
                      </div>';
            }

            mysqli_close($conn);
        } else {
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="rp">RPE:</label>
                <input type="text" class="form-control" name="rp" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="estado">Zona:</label>
                <select class="form-control" name="estado" required>
                    <option value="Zona">Zona</option>
                    <option value="Ofininas">DP000 Oficinas</option>
                    <option value="sanjuan">DP030 San Juan Rico</option>
                    <option value="irapuato">DP060 Irapuato</option>
                    <option value="leon">DP070 León</option>
                    <option value="celaya">DP080 Celaya</option>
                    <option value="queretaro">DP090 Queretaro</option>
                    <option value="salvatierra">DP100 Salvatierra</option>
                    <option value="michoacan">DP130 Michoacán</option>
                    <option value="aguascalientes">DP520 Aguascalientes</option>
                    <option value="salamanca">DP530 Salamanca</option>
                    <option value="zacatecas">DP580 Zacatecas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rol_nivel">Nivel:</label>
                <select class="form-control" name="rol_nivel" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Zona">Zona</option>
                    <option value="Consulta">Consulta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-block">Registrar</button>
        </form>

        <?php } ?>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
