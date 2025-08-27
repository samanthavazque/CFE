<div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="nuevoModalLabel">Agregar Error</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guardar2.php" method="post" enctype="multipart/form-data">
                    <!-- Categoría -->
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select name="categoria" id="categoria" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php while ($row_categoria = $categoria->fetch_assoc()) { ?>
                                <option value="<?php echo $row_categoria["id"]; ?>">
                                    <?= $row_categoria["nombre"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Número de errores -->
                    <div class="mb-3">
                        <label for="numeroerrores" class="form-label">Número de Error:</label>
                        <input type="text" name="numeroerrores" id="numeroerrores" class="form-control" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Solución Operativa -->
                    <div class="mb-3">
                        <label for="solucionoperativa" class="form-label">Solución Operativa:</label>
                        <textarea name="solucionoperativa" id="solucionoperativa" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Solución Técnica -->
                    <div class="mb-3">
                        <label for="soluciontecnica" class="form-label">Solución Técnica:</label>
                        <textarea name="soluciontecnica" id="soluciontecnica" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Archivos (Imágenes y Video) -->
                    <div class="mb-2">
                        <label for="file" class="form-label">Selecciona las imágenes:</label>
                        <input type="file" id="nuevoFile" name="file[]" class="form-control" multiple onchange="previewImages(this.files, 'nuevoImagePreview')">
                        <div id="nuevoImagePreview" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label for="video" class="form-label">Video:</label>
                        <input type="file" name="video" id="nuevoVideo" class="form-control" accept="video/mp4" onchange="previewVideo(this.files, 'nuevoVideoPreview')">
                        <div id="nuevoVideoPreview" class="mt-2"></div>
                    </div>

                    <!-- Botones -->
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>