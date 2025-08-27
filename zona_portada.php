<?php

session_start();
// Forzar la codificación UTF-8 en la respuesta HTTP
header('Content-Type: text/html; charset=UTF-8');
if ( !isset($_SESSION['rp'] )){
    header('Location: index.php');
}
require 'Config/Conexion.php';

$sqlerrores = "SELECT p.id, p.numeroerrores, p.descripcion, p.solucionoperativa, p.soluciontecnica, p.poster, g.nombre AS categoria FROM errores AS p INNER JOIN categoria AS g ON p.id_categoria=g.id";
$errores = $conn->query($sqlerrores);


$dir = "posters/";
$sqlCategoria = "SELECT * FROM categoria";
$categoria1 = $conn->query($sqlCategoria);
/* Filtrado */
$campo = '';
if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}  
?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comision Federal de Electricidad</title>
    <link rel="shortcut icon" href="comision1.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <style>


table{
border-collapse: collapse;
}

td, th{
padding: 5px 10px;
}

main{
padding: 1em 2em;
}

/* Responsive styles */
@media (max-width: 30em) {
table{
    width: 100%;
    font-size: .9em;
}
table tr{
    display: flex;
    flex-direction: column;
    border: 1px solid grey;
    padding: 1em;
    margin-bottom: 1em;
}

table td[data-titulo]{
    display: flex;
}

table td,
table th{
    border: none;
}

table td[data-titulo]::before{
    content:attr(data-titulo);
    width: 160px;
    font-weight:bold;
}

table thead{
    display: none;
}

}


</style>
    <script>        
        function abrirModal(){
            alert("si");
            $('#editaModal2').modal('show');
        }
        function buscar() {
            var texto = document.getElementById('campo').value.toLowerCase();
            var lista = $('#tabla1 tr');

            for (let i = 0; i < lista.length; i++) {
                var conten = lista[i].textContent.toLowerCase();
                var contenido = conten.toLowerCase();
                var index = contenido.indexOf(texto);
                var cadena = "";

                if (texto === "") {
                    // Si no se ingresa nada en el campo de búsqueda, mostrar todas las filas
                    lista[i].style.backgroundColor = '#FFFFFF';
                    lista[i].style.display = '';
                } else if (index >= 0) {
                    // Si se ingresa texto y la fila contiene la cadena buscada, resaltarla
                    lista[i].style.backgroundColor = '#00FF00';
                } else {
                    // Si no se encuentra la cadena, ocultar la fila
                    lista[i].style.display = 'none';
                }
            }
        }
    </script>
</head>	
        
<body class="d-flex flex-column h-100">
<!-- MODAL EDITAR REGISTRO -->
<div class="modal fade" id="editaModal2" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editaModalLabel">Editar Error</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editar.php" method="post" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="idd" class="form-label">ID:</label>
                        <input type="text" name="idd" id="idd" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select name="categoria" id="categoria" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php
                                $opcion=""; 
                                while ($row_categoria = $categoria1->fetch_assoc()) {
                                    $opcion = '<option value="' .$row_categoria['id'].'">'.$row_categoria["nombre"].'</option>';

                                    echo $opcion;
                                } 
                            ?>
                            
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="numeroerrores" class="form-label">Numero Errores:</label>
                        <input type="text" name="numeroerrores" id="numeroerrores" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label for="solucionoperativa" class="form-label">Solución Operativa:</label>
                        <textarea type="text" name="solucionoperativa" id="solucionoperativa" class="form-control" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="soluciontecnica" class="form-label">Solución Técnica:</label>
                        <textarea type="text" name="soluciontecnica" id="soluciontecnica" class="form-control"  required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Imagen actual:</label>
                        <div id="editImagePreview" class="mb-2"></div>
                        <label for="file" class="form-label">Cambiar imagen:</label>
                        <input type="file" id="file" name="file[]" class="form-control" multiple onchange="previewImages(this.files, 'editImagePreview')" />
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Video actual:</label>
                        <div id="editVideoPreview" class="mb-2"></div>
                        <label for="video" class="form-label">Cambiar video:</label>
                        <input type="file" name="video" id="video" class="form-control" accept="video/mp4" onchange="previewVideo(this.files, 'editVideoPreview')">
                    </div>

                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"> Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR REGISTRO -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminaModalLabel">Eliminar Registro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este registro?
        </div>
        <div class="modal-footer">
            <form action="elimina.php" method="post">
                <input type="hidden" name="id" id="id">  <!-- Campo oculto para el ID -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
</div>

</head>
<body>

      <!-- Barra de navegación -->
            <nav class="navbar navbar-dark shadow-sm" style="background: #218838;">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="logoo.jpg" alt="Logo" style="height:60px; width:auto; margin-right:16px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.10);">
                    </a>
                    <form action="cerrarsesion.php" method="POST" class="d-flex align-items-center">
                        <button type="submit" class="btn btn-danger btn-lg fw-bold d-flex align-items-center" style="gap: 10px; border-radius: 8px;">
                            <i class="bi bi-power" style="font-size: 1.5rem;"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </nav>


    <div class="container py-3">
        <!-- <h2 class="text-center">Comision</h2> -->
        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
            <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
            unset($_SESSION['color']);
            unset($_SESSION['msg']);
        } ?>

        <!--  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success" href="registros.php"><b>Registro Usuario</b>   </a>
                <a class="btn btn-success" href="php/cerrarsesion.php"><b>Cerrar Sesion</b>   </a>
            </div> -->

    <!-- <div class="wrapper">
        
        <div class="container">
                
            <div class="col-lg-12">
            
                <center>
                    <h1>Pagina Administrativa</h1>
                    
                    <h3>
                    <?php
                        if(isset($_SESSION['admi_login']))
                        {
                        ?>
                            Bienvenido,
                        <?php
                                echo $_SESSION['admi_login'];
                        }
                        ?>
                    </h3>
                        
            </div>  -->

<!-- BOTONES       -->
        <div class="row">
            <div class="col-auto">
                <div class="col-5"></div>
                    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoModal"><b> Nuevo registro </b></a>
                        <!-- <i class="fa fa-power-off" aria-hidden="true"></i>-->
                    </a>

                        <a class="btn btn-success" href="excel.php"><b>Excel</b>
                        <!-- <i class="fa fa-table" aria-hidden="true"></i> -->
                        </a>
                        <a href="fpdf/reporte.php" class="btn btn-success"><b>PDF</b> </a>
                    
            </div>

<!-- TABLA DE REGISTROS  -->
<div class="container-fluid mt-4">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover" id="tabla1">
            <thead class="thead">
            <tr>
                <th>#</th>
                <th>Categoria</th>
                <th>Numero Error</th>
                <th>Descripción</th>
                <th>Solución Operativa</th>
                <th>Solución Técnica</th>
                <th>Imágenes</th>
                <th>Video</th>
                <th>Accion</th>
            </tr>
            </thead>

            <tbody>
            <?php while ($row = $errores->fetch_assoc()) { ?>
                <tr>
                    <td data-titulo="Id"><?= $row['id']; ?></td>
                    <td data-titulo="Categoria" name='cat'><?= $row['categoria']; ?></td>
                    <td data-titulo="Numero Error"><?= $row['numeroerrores']; ?></td>
                    <td data-titulo="Descripcion"><?= utf8_decode($row['descripcion']); ?></td>
                    <td data-titulo="Solucion Operativa"><?= utf8_decode($row['solucionoperativa']); ?></td>
                    <td data-titulo="Solucion Tecnica"><?= utf8_decode($row['soluciontecnica']); ?></td>
                    <td>
                    <?php
                        $cadena = $row['poster'];
                        $imgs = explode(',', $cadena);
                        $tam = count($imgs);

                        // Mostrar imágenes
                        for ($i = 0; $i < $tam; $i++) {
                            $imagePath = $imgs[$i];
                            if (file_exists($imagePath)) {
                                echo '<a href="' . $imagePath . '" target="_blank" class="d-block mb-3">';
                                echo '<img src="' . $imagePath . '?n=' . time() . '" class="img-fluid" style="width:100%;height:auto;" alt="Image">';
                                echo '</a>';
                            } else {
                                echo '<p>Imagen no encontrada</p>';
                            }
                        }

                        // Mostrar video
                        $videoPath = isset($row['video']) ? $row['video'] : '';
                        if ($videoPath && $videoPath !== '' && file_exists($videoPath)) {
                            echo "<div style='display: flex; flex-direction: column; align-items: start;'>";
                            echo "<video style='width: 100%;' controls><source src='{$videoPath}?n=" . time() . "' type='video/mp4'>Tu navegador no soporta el elemento de video.</video>";
                            echo "<a href='{$videoPath}' download class='btn btn-success mt-2'>Descargar video</a>";
                            echo "</div>";
                        } else {
                            // No mostrar nada si no hay video
                        }
                    ?>

                    </td>
                    <td>
                        <style>
                            .custom-img-size {

                                    max
                                max-width: 100px; /* Ajusta el tamaño máximo deseado */
                                    
                                    max-h
                                max-height: 100px; /* Ajusta la altura máxima deseada */
                                    object-fit: cover; /* Ajusta la imagen sin distorsionarla */
                                    border-radius: 10px; /* Opcional: bordes redondeados */
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Opcional: sombra */
                                }

                        </style>
                        <?php
                        $videoFileName = $row['id'] . '.mp4'; // Ajusta la extensión del video según tus archivos reales.
                        $videoFilePath = $dir . $videoFileName;

                        if (file_exists($videoFilePath)) {
                            echo "<video style='width: 100%;' controls><source src='{$videoFilePath}' type='video/mp4'>Tu navegador no soporta el elemento de video.</video>";
                        } else {
                            // No mostrar nada si no hay video
                        }
                        ?>
                    </td>
                    <td>
                    <div class="btn-group">
                        <!-- Botón de edición con ícono -->
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal2" data-bs-id="<?= $row['id']; ?>" id="<?= $row['id']; ?>">
                            <i class="bi bi-pencil-fill"></i> 
                        </a>

                       
                    </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


    <?php
    $sqlcategoria = "SELECT id, nombre FROM categoria";
    $categoria = $conn->query($sqlcategoria);
    ?>

    <?php include 'nuevoModal.php'; ?>

    <?php $categoria->data_seek(0); ?>

    <?php include 'editaModal.php'; ?>
    <?php include 'eliminaModal.php'; ?>

<!-- SCRIPTS GLOBALES      -->
    <script>
        let nuevoModal = document.getElementById('nuevoModal');
        let editaModal = document.getElementById('editaModal2');
        let eliminaModal = document.getElementById('eliminaModal');

        /*nuevoModal.addEventListener('shown.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').focus();
        })*/

        nuevoModal.addEventListener('hide.bs.modal', event => {
            let categoria = nuevoModal.querySelector('.modal-body #categoria');
            if (categoria) categoria.value = "";
            let numeroerrores = nuevoModal.querySelector('.modal-body #numeroerrores');
            if (numeroerrores) numeroerrores.value = "";
            let descripcion = nuevoModal.querySelector('.modal-body #descripcion');
            if (descripcion) descripcion.value = "";
            let solucionoperativa = nuevoModal.querySelector('.modal-body #solucionoperativa');
            if (solucionoperativa) solucionoperativa.value = "";
            let soluciontecnica = nuevoModal.querySelector('.modal-body #soluciontecnica');
            if (soluciontecnica) soluciontecnica.value = "";
            let poster = nuevoModal.querySelector('.modal-body #poster');
            if (poster) poster.value = "";
        })

        editaModal.addEventListener('hide.bs.modal', event => {
            let id = editaModal.querySelector('.modal-body #id ');
            if (id) id.value = "";
            let categoria = editaModal.querySelector('.modal-body #categoria');
            if (categoria) categoria.value = "";
            let numeroerrores = editaModal.querySelector('.modal-body #numeroerrores');
            if (numeroerrores) numeroerrores.value = "";
            let descripcion = editaModal.querySelector('.modal-body #descripcion');
            if (descripcion) descripcion.value = "";
            let solucionoperativa = editaModal.querySelector('.modal-body #solucionoperativa');
            if (solucionoperativa) solucionoperativa.value = "";
            let soluciontecnica = editaModal.querySelector('.modal-body #soluciontecnica');
            if (soluciontecnica) soluciontecnica.value = "";
            let img_poster = editaModal.querySelector('.modal-body #img_poster');
            if (img_poster) img_poster.value = "";
            let poster = editaModal.querySelector('.modal-body #poster');
            if (poster) poster.value = "";
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let inputId = editaModal.querySelector('.modal-body #id');
            let idd = editaModal.querySelector('.modal-body #idd');
            let inputCategoria = editaModal.querySelector('.modal-body #categoria');
            let inputNumeroErrores = editaModal.querySelector('.modal-body #numeroerrores');
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion');
            let inputSolucionOperativa = editaModal.querySelector('.modal-body #solucionoperativa');
            let inputSolucionTecnica = editaModal.querySelector('.modal-body #soluciontecnica');
            let imagePreview = editaModal.querySelector('.modal-body #editImagePreview');
            let videoPreview = editaModal.querySelector('.modal-body #editVideoPreview');

            let url = "getfederal.php";
            let formData = new FormData();
            formData.append('id', id);

            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (inputId) inputId.value = data.id;
                if (idd) idd.value = data.id;
                if (inputCategoria) inputCategoria.value = data.id_categoria;
                if (inputNumeroErrores) inputNumeroErrores.value = data.numeroerrores;
                if (inputDescripcion) inputDescripcion.value = data.descripcion;
                if (inputSolucionOperativa) inputSolucionOperativa.value = data.solucionoperativa;
                if (inputSolucionTecnica) inputSolucionTecnica.value = data.soluciontecnica;

                // Mostrar imagen actual
                if (imagePreview) {
                    imagePreview.innerHTML = '';
                    if (data.poster) {
                        let imgs = data.poster.split(',');
                        imgs.forEach(function(img) {
                            let imagePath = img.trim();
                            if (imagePath) {
                                let imgElem = document.createElement('img');
                                imgElem.src = imagePath + '?n=' + Date.now();
                                imgElem.className = 'img-fluid';
                                imgElem.style.width = '100%';
                                imgElem.style.height = 'auto';
                                imgElem.style.marginBottom = '8px';
                                imagePreview.appendChild(imgElem);
                            }
                        });
                    } else {
                        imagePreview.innerHTML = '<p>No hay imagen disponible</p>';
                    }
                }

                // Mostrar video actual
                if (videoPreview) {
                    videoPreview.innerHTML = '';
                    let videoPath = 'posters/' + data.id + '.mp4';
                    // Se puede mejorar con validación de existencia si se requiere
                    let videoElem = document.createElement('video');
                    videoElem.controls = true;
                    videoElem.style.maxWidth = '200px';
                    videoElem.innerHTML = `<source src="${videoPath}?n=${Date.now()}" type="video/mp4">Tu navegador no soporta el elemento de video.`;
                    videoPreview.appendChild(videoElem);
                }
            })
            .catch(err => console.log(err));

        })


        eliminaModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;  // El botón que activó el modal
        let id = button.getAttribute('data-bs-id');  // Obtener el ID del botón
        eliminaModal.querySelector('.modal-footer #id').value = id;  // Poner el ID en el campo oculto del formulario
    });

        $(document).ready(function() {
            $('#tabla1').DataTable({
                "pageLength": 10
            });
        });

        /* imagenes */ 
    
        function uploadFiles(event) {
            event.preventDefault();

            const fileInput = document.getElementById("fileInput");
            const selectedFiles = fileInput.files;

            //const formData = new FormData();
            const filess = [];
            for (let i = 0; i < selectedFiles.length; i++) {
                //formData.append("files[]", selectedFiles[i]);
                filess.append(selectedFiles[i]);
            }
        }

        function previewImages(files, containerId = 'imagePreview') {
            var previewContainer = document.getElementById(containerId);
            if (!previewContainer) return;
            previewContainer.innerHTML = '';
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    image.className = 'img-fluid';
                    image.style.width = '100%';
                    image.style.height = 'auto';
                    image.style.marginBottom = '8px';
                    previewContainer.appendChild(image);
                };
                reader.readAsDataURL(file);
            }
        }

        function previewVideo(files, containerId = 'editVideoPreview') {
            var previewContainer = document.getElementById(containerId);
            if (!previewContainer) return;
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                var file = files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var video = document.createElement('video');
                    video.controls = true;
                    video.style.maxWidth = '100%';
                    video.style.height = 'auto';
                    video.innerHTML = `<source src="${e.target.result}" type="video/mp4">Tu navegador no soporta el elemento de video.`;
                    previewContainer.appendChild(video);
                };
                reader.readAsDataURL(file);
            }
        }
    var offcanvas = document.getElementById('offcanvasNavbar');
    if (offcanvas) {
        offcanvas.addEventListener('hidden.bs.offcanvas', function () {
            document.body.style.overflow = 'auto';
        });
        offcanvas.addEventListener('shown.bs.offcanvas', function () {
            document.body.style.overflow = 'hidden';
        });
    }
    
    

</script>



<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>