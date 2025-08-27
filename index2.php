<?php
    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: inicio.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="comision.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CFE</title>
</head>
<body>
    <div class="container">
        <div class="form sign-up-container">
            <h1>REGISTRARSE</h1>
            <form action="registro.php" method="POST" class="formulario">
                <input type="text" placeholder="Rp" name="rp" id="rp">
                <input type="text" placeholder="Nombre" name="nombre" id="name">
                <label for="zona" class="form-label">Seleccionar las zonas:</label><br><br>
                <select class="form-select" id="zona" name="zona">
                    <option selected>Zona</option>
                    <option value="1">DP000 Ofininas</option>
                    <option value="2">DP030 San JUan Rico</option>
                    <option value="3">DP060 Irapuato</option>
                    <option value="4">DP070 León</option>
                    <option value="5">DP080 Celaya</option>
                    <option value="6">DP090 Queretaro</option>
                    <option value="7">DP100 Salvatierra</option>
                    <option value="8">DP130 </option>
                    <option value="9">DP520 Aguascaliente</option>
                    <option value="10">DP530 </option>
                    <option value="11">DP580 Zacateca</option>
                </select><br><br>
                <label for="nivel" class="form-label">Seleccionar el Nivel:</label><br><br>
                <select class="form-select" id="nivel" name="nivel">
                    <option selected>Nivel</option>
                    <option value="1">Administrativo</option>
                    <option value="2">Consulta</option>
                    <option value="3">Gto</option>
                </select><br><br>
                <a class="ok-account">¿Ya tienes una cuenta?</a>
                <input type="submit" value="Registrarse"> 
            </form>
        </div>

         <div class="form sign-in-container">
            <h1>Iniciar sesión</h1>
            <form action="php/loginusuario.php" method="POST" class="formulario2">
                <input type="text" name="rp" placeholder="Rp" id="rp">
                <input type="text" name="nombre" placeholder="Nombre" id="nombre">
                <a class="no-account">¿Aun no tienes cuenta?</a>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>
    <p class="notify check_notify">¡TE REGISTRASTE CORRECTAMENTE</p>
    <p class="notify error_notify">Lo siento! ocurrio un error, por favor verifica tus datos</p>
    <script src="js/script.js"></script>
</body>
</html>