<?php
declare(strict_types=1);
require 'Config/Conexion.php';

/* Cookies de sesión más seguras (antes de session_start) */
$secure   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$cookieParams = [
  'lifetime' => 0,
  'path'     => '/',
  'domain'   => '',
  'secure'   => $secure,
  'httponly' => true,
  'samesite' => 'Lax',
];
if (PHP_VERSION_ID >= 70300) {
  session_set_cookie_params($cookieParams);
}
session_start();

/* Solo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php'); exit;
}

/* CSRF */
$post_token = $_POST['csrf_token'] ?? '';
$ses_token  = $_SESSION['csrf_token'] ?? '';
if (!$post_token || !$ses_token || !hash_equals($ses_token, $post_token)) {
  $_SESSION['login_error'] = 'Sesión inválida. Recarga la página e inténtalo de nuevo.';
  header('Location: index.php'); exit;
}

/* Inputs */
$rp       = trim((string)($_POST['rp'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$remember = isset($_POST['remember']); // opcional si decides implementar persistencia

/* Validaciones básicas */
if ($rp === '' || $password === '') {
  $_SESSION['login_error'] = 'Usuario o contraseña vacíos.';
  $_SESSION['old_rp'] = $rp;
  header('Location: index.php'); exit;
}
/* Limita longitud y caracteres del RPE (ajusta si necesitas otros) */
$rp = mb_substr($rp, 0, 30);
if (!preg_match('/^[\w.@-]{1,30}$/u', $rp)) {
  $_SESSION['login_error'] = 'Formato de RPE inválido.';
  $_SESSION['old_rp'] = '';
  header('Location: index.php'); exit;
}

/* Consulta segura */
$sql = "SELECT rp, nombre, estado, rol_nivel, permisos, password 
        FROM usuarios WHERE rp = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
  $_SESSION['login_error'] = 'Error interno (prep).';
  header('Location: index.php'); exit;
}
mysqli_stmt_bind_param($stmt, 's', $rp);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
  $hashDB = (string)($row['password'] ?? '');

  /* 1) Intentar como hash (bcrypt/argon) */
  $ok = false;
  if ($hashDB !== '' && preg_match('/^\$2y\$|\$argon2(id|i)\$/', $hashDB) === 1) {
    $ok = password_verify($password, $hashDB);
  }

  /* 2) Fallback legado (texto plano) si no pasó (usa hash_equals para timing-safe) */
  if (!$ok && $hashDB !== '' && !preg_match('/^\$2y\$|\$argon2(id|i)\$/', $hashDB)) {
    $ok = hash_equals($hashDB, $password);
  }

  if ($ok) {
    /* Regenerar ID de sesión (previene fijación) */
    session_regenerate_id(true);

    $_SESSION['rp']        = $row['rp'];
    $_SESSION['nombre']    = $row['nombre'];
    $_SESSION['estado']    = $row['estado'];     // ojo: aquí parece ser estado geográfico, no "activo"
    $_SESSION['rol_nivel'] = $row['rol_nivel'];
    $_SESSION['permisos']  = array_filter(array_map('trim', explode(',', (string)$row['permisos'])));

    /* Redirección por rol */
    $routes = [
      'Administrador' => 'inicio.php',
      'Zona'          => 'zona_portada.php',
      'Consulta'      => 'consulta_portada.php',
    ];
    $dest = $routes[$_SESSION['rol_nivel']] ?? 'inicio.php';

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header('Location: '.$dest); 
    exit;
  }
}

/* Si llega aquí: credenciales inválidas */
if (isset($stmt)) mysqli_stmt_close($stmt);
mysqli_close($conn);

$_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
$_SESSION['old_rp'] = $rp;                 // para rellenar el campo al volver
header('Location: index.php'); 
exit;
