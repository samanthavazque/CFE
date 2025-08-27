<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['rp'])) {
  header('Location: index.php');
  exit;
}

require 'Config/Conexion.php';

$sqlerrores = "SELECT p.id, p.numeroerrores, p.descripcion, p.solucionoperativa, p.soluciontecnica, p.poster, g.nombre AS categoria
               FROM errores AS p
               INNER JOIN categoria AS g ON p.id_categoria = g.id";
$errores = $conn->query($sqlerrores);

$dir = "posters/"; // carpeta donde podrían estar los videos: posters/{id}.mp4
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Comisión Federal de Electricidad</title>
  <link rel="shortcut icon" href="comision1.png">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables + Bootstrap 5 (1.13.6) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <style>
    /* Tabla estable y sin desbordes */
    table#tabla1 { table-layout: fixed; width: 100%; }
    #tabla1 th, #tabla1 td { padding: .5rem .6rem; vertical-align: top; overflow-wrap: anywhere; }

    /* Anchos de columnas (ajusta si deseas) */
    #tabla1 th:nth-child(1), #tabla1 td:nth-child(1) { width: 60px; }   /* # */
    #tabla1 th:nth-child(2), #tabla1 td:nth-child(2) { width: 140px; }  /* Categoría */
    #tabla1 th:nth-child(3), #tabla1 td:nth-child(3) { width: 100px; }  /* Número error */
    #tabla1 th:nth-child(7), #tabla1 td:nth-child(7) { width: 240px; }  /* Imágenes */
    #tabla1 th:nth-child(8), #tabla1 td:nth-child(8) { width: 240px; }  /* Video */

    .cell-text { white-space: normal; line-height: 1.25; }

    /* Miniaturas */
    .media-column { display: flex; flex-wrap: wrap; gap: .5rem; }
    .media-thumb { flex: 0 0 200px; max-width: 200px; }
    .media-thumb img {
      width: 100%; height: 120px; object-fit: cover;
      border-radius: 8px; display: block;
    }

    /* Video 16:9 sin desbordes */
    .media-video { flex: 0 0 200px; max-width: 200px; }
    .media-video .ratio { width: 100%; }
    .media-video video { width: 100%; height: 100%; border-radius: 8px; }

    /* Responsive tipo tarjeta en móviles */
    @media (max-width: 30em) {
      table#tabla1 { font-size: .9em; }
      thead { display: none; }
      #tabla1 tr {
        display: flex; flex-direction: column;
        border: 1px solid #e5e5e5; border-radius: 8px;
        padding: 1rem; margin-bottom: 1rem;
      }
      #tabla1 td::before {
        content: attr(data-titulo);
        font-weight: 700; display: inline-block; width: 160px;
        margin-right: .5rem;
      }
    }
  </style>
</head>

<body class="d-flex flex-column h-100">
  <!-- Barra de navegación -->
  <nav class="navbar navbar-dark shadow-sm" style="background: linear-gradient(90deg, #218838 60%, #155724 100%);">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="logoo.jpg" alt="Logo" style="height:60px;width:auto;margin-right:16px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.10);">
      </a>
      <form action="cerrarsesion.php" method="POST" class="d-flex align-items-center">
        <button type="submit" class="btn btn-outline-light btn-lg fw-bold d-flex align-items-center" style="gap:10px;border-radius:8px;">
          <i class="bi bi-power" style="font-size:1.5rem;"></i> <span style="font-size:1.1rem;">Cerrar sesión</span>
        </button>
      </form>
    </div>
  </nav>

  <div class="container py-3">
    <?php if (isset($_SESSION['msg'], $_SESSION['color'])) { ?>
      <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['msg']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['color'], $_SESSION['msg']); } ?>

    <!-- TABLA DE REGISTROS -->
    <div class="table-responsive mt-4">
      <table class="table table-sm table-striped table-hover" id="tabla1">
        <thead>
          <tr>
            <th>#</th>
            <th>Categoría</th>
            <th>Número Error</th>
            <th>Descripción</th>
            <th>Solución Operativa</th>
            <th>Solución Técnica</th>
            <th>Imágenes</th>
            <th>Video</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $errores->fetch_assoc()) { ?>
          <tr>
            <td data-titulo="#" class="cell-text"><?= $row['id']; ?></td>
            <td data-titulo="Categoría" class="cell-text"><?= $row['categoria']; ?></td>
            <td data-titulo="Número Error" class="cell-text"><?= $row['numeroerrores']; ?></td>
            <td data-titulo="Descripción" class="cell-text"><?= utf8_decode($row['descripcion']); ?></td>
            <td data-titulo="Solución Operativa" class="cell-text"><?= utf8_decode($row['solucionoperativa']); ?></td>
            <td data-titulo="Solución Técnica" class="cell-text"><?= utf8_decode($row['soluciontecnica']); ?></td>

            <!-- Imágenes -->
            <td data-titulo="Imágenes">
              <div class="media-column">
                <?php
                  $cadena = $row['poster'] ?? '';
                  $imgs = array_filter(array_map('trim', explode(',', $cadena)));
                  if (!empty($imgs)) {
                    foreach ($imgs as $imagePath) {
                      if (is_file($imagePath)) {
                        echo '<a class="media-thumb" href="'.$imagePath.'" target="_blank">';
                        echo '  <img src="'.$imagePath.'?n='.time().'" alt="Imagen">';
                        echo '</a>';
                      }
                    }
                  } else {
                    echo '<span class="text-muted">Sin imágenes</span>';
                  }
                ?>
              </div>
            </td>

            <!-- Video -->
            <td data-titulo="Video">
              <div class="media-column">
                <?php
                  $videoFileName = $row['id'].'.mp4';
                  $videoFilePath = $dir.$videoFileName;
                  if (is_file($videoFilePath)) {
                    echo '<div class="media-video">';
                    echo '  <div class="ratio ratio-16x9">';
                    echo '    <video controls preload="metadata">';
                    echo '      <source src="'.$videoFilePath.'?n='.time().'" type="video/mp4">';
                    echo '    </video>';
                    echo '  </div>';
                    echo '</div>';
                  } else {
                    echo '<span class="text-muted">Sin video</span>';
                  }
                ?>
              </div>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- DataTables core + Bootstrap 5 (1.13.6) -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(function () {
      $('#tabla1').DataTable({
        pageLength: 10,
        lengthChange: true,   // Muestra "Mostrar _MENU_ entradas"
        searching: true,      // Muestra "Buscar"
        dom: 'lfrtip',        // l=length, f=filter, r=processing, t=table, i=info, p=paging
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
      });
    });
  </script>
</body>
</html>
