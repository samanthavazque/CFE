<?php
// Siempre iniciar sesión ANTES de enviar HTML
session_start();

// CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Mensajes previos
$error  = $_SESSION['login_error'] ?? null;
$old_rp = $_SESSION['old_rp'] ?? '';

// Limpiar mensajes para que no se repitan al refrescar
unset($_SESSION['login_error'], $_SESSION['old_rp']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#198754" />
  <link rel="shortcut icon" href="comision1.png" />
  <title>Iniciar sesión</title>

  <!-- Bootstrap 5 & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    :root{
      /* 👉 Ajusta SOLO esto si quieres cambiar el ancho máximo del card */
      --login-max: clamp(340px, 90vw, 560px);
      --login-radius: 20px;
    }

    /* Fondo y centrado */
    body{
      min-height: 100vh;        /* fallback */
      min-height: 100svh;       /* evita saltos en móviles con teclado */
      background:
        radial-gradient(1200px 600px at 20% -10%, #e9f7ef 0%, transparent 60%),
        radial-gradient(1000px 500px at 120% 10%, #e8f0fe 0%, transparent 55%),
        #f6f7f9;
      display: grid;
      place-items: center;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    .login-wrap{
      width: 100%;
      max-width: var(--login-max);
      padding: clamp(12px, 2vw, 24px);
    }

    .login-card{
      border: 0;
      border-radius: var(--login-radius);
      box-shadow:
        0 10px 20px rgba(0,0,0,.06),
        0 3px 6px rgba(0,0,0,.05);
      overflow: hidden;
      background: #fff;
    }

    .login-header{
      text-align: center;
      padding: clamp(20px, 3vw, 32px) clamp(16px, 2vw, 24px) clamp(10px, 2vw, 14px);
    }

    .brand-logo{
      width: clamp(84px, 18vw, 128px);
      height: auto;
    }

    .login-title{
      margin: 14px 0 0;
      font-weight: 700;
      font-size: clamp(1.1rem, 1.2vw + .7rem, 1.6rem);
      line-height: 1.2;
    }

    .login-body{
      padding: clamp(16px, 2.5vw, 28px) clamp(16px, 2.5vw, 28px) clamp(18px, 2.5vw, 30px);
    }

    .form-label{ font-weight: 600; font-size: clamp(.95rem, .3vw + .8rem, 1rem); }

    /* Altura cómoda para campos y botón */
    .input-group>.form-control,
    .input-group>.btn,
    .btn-login{
      height: clamp(2.75rem, 2.2vw + 2.2rem, 3.25rem);
      font-size: clamp(.95rem, .3vw + .85rem, 1.05rem);
    }

    .btn-login[disabled]{ cursor: not-allowed; }
    .caps-hint{ display: none; }
    .caps-hint.show{ display: block; }
    .small-links{ font-size: .925rem; }
    .footer-note{
      text-align: center;
      color: #6c757d;
      font-size: .85rem;
      margin-top: 10px;
    }

    /* Un poquito más ancho en desktops grandes */
    @media (min-width: 1200px){
      :root{ --login-max: 600px; }
    }

    /* Modo oscuro opcional según sistema */
    @media (prefers-color-scheme: dark){
      body{ background: #0e1114; }
      .login-card{ background: #14181c; color: #e6e6e6; }
      .form-text, .footer-note{ color: #adb5bd; }
      .input-group-text{ background: #0f1317; color: #dee2e6; border-color: #2a2f35; }
      .form-control, .btn, .form-check-input{ border-color: #2a2f35; }
      .form-control{ background-color: #0f1317; color: #e6e6e6; }
      .btn.btn-success{ color: #fff; }
    }
  </style>
</head>
<body>

  <div class="login-wrap">
    <div class="login-card card">
      <div class="login-header">
        <img src="logo.png" alt="Logo" class="brand-logo">
        <h1 class="login-title">Iniciar sesión</h1>
      </div>

      <div class="login-body">
        <?php if ($error): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
          </div>
        <?php endif; ?>

        <form id="loginForm" action="procesar_login.php" method="POST" novalidate>
          <!-- CSRF -->
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

          <div class="mb-3">
            <label for="rp" class="form-label">RPE</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input
                type="text"
                class="form-control"
                id="rp"
                name="rp"
                inputmode="text"
                autocomplete="username"
                spellcheck="false"
                required
                maxlength="30"
                value="<?= htmlspecialchars($old_rp, ENT_QUOTES, 'UTF-8') ?>"
                placeholder=""
                aria-describedby="rpHelp"
              >
            </div>
            <div id="rpHelp" class="form-text">Ingresa tu RPE asignado.</div>
            <div class="invalid-feedback">El RPE es obligatorio.</div>
          </div>

          <div class="mb-2">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                autocomplete="current-password"
                required
                placeholder=""
                aria-describedby="capsHint"
              >
              <button class="btn btn-outline-secondary" type="button" id="togglePwd" aria-label="Mostrar u ocultar contraseña">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            <div id="capsHint" class="form-text text-warning caps-hint"><i class="bi bi-exclamation-triangle"></i> Bloq Mayús activado.</div>
            <div class="invalid-feedback">La contraseña es obligatoria.</div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3 small-links">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
              <label class="form-check-label" for="remember">Recordarme</label>
            </div>
            <a href="#" class="link-secondary text-decoration-none">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn btn-success w-100 btn-login">
            <span class="btn-text"><i class="bi bi-box-arrow-in-right"></i> Iniciar sesión</span>
            <span class="btn-spinner d-none ms-2" role="status" aria-hidden="true">
              <span class="spinner-border spinner-border-sm"></span>
            </span>
          </button>
        </form>

        <div class="footer-note">Uso interno — CFE</div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      const form = document.getElementById('loginForm');
      const btn  = form.querySelector('.btn-login');
      const txt  = btn.querySelector('.btn-text');
      const spn  = btn.querySelector('.btn-spinner');
      const pwd  = document.getElementById('password');
      const caps = document.getElementById('capsHint');
      const togglePwd = document.getElementById('togglePwd');
      const rp = document.getElementById('rp');

      // Validación Bootstrap
      form.addEventListener('submit', function (e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        } else {
          // prevenir doble envío
          btn.disabled = true;
          spn.classList.remove('d-none');
          txt.classList.add('opacity-75');
        }
        form.classList.add('was-validated');
      }, false);

      // Mostrar/ocultar contraseña
      togglePwd.addEventListener('click', function () {
        const isPwd = pwd.getAttribute('type') === 'password';
        pwd.setAttribute('type', isPwd ? 'text' : 'password');
        this.firstElementChild.classList.toggle('bi-eye');
        this.firstElementChild.classList.toggle('bi-eye-slash');
      });

      // Aviso de Caps Lock
      const capsCheck = (e) => {
        if (e.getModifierState && typeof e.getModifierState === 'function') {
          const on = e.getModifierState('CapsLock');
          caps.classList.toggle('show', !!on);
        }
      };
      pwd.addEventListener('keyup', capsCheck);
      pwd.addEventListener('keydown', capsCheck);
      pwd.addEventListener('focus', capsCheck);
      pwd.addEventListener('blur', () => caps.classList.remove('show'));

      // Limpieza y formato del RPE (trim + sin espacios)
      rp.addEventListener('input', () => {
        rp.value = rp.value.replace(/\s+/g, '').trim();
      });
    })();
  </script>
</body>
</html>
