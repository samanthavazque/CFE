<div class="modal fade" id="editaModal1" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editaModalLabel">Agregar Error</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualiza.php" method="post" enctype="multipart/form-data">

                    <div class="mb-2">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select name="categoria" id="categoria" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php while ($row_categoria = $categoria->fetch_assoc()) { ?>
                                <option value="<?php echo $row_categoria["id"]; ?>"><?= $row_categoria["nombre"] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="numeroerrores" class="form-label">Numero Error:</label>
                        <input type="text" name="numeroerrores" id="numeroerrores" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label for="solucionoperativa" class="form-label">Solución Operativa:</label>
                        <input type="text" name="solucionoperativa" id="solucionoperativa" class="form-control" required>

                    <div class="mb-2">
                        <label for="soluciontecnica" class="form-label">Solución Técnica:</label>
                        <input type="text" name="soluciontecnica" id="soluciontecnica" class="form-control"  required>
                    </div>


                   <!--  <div class="mb-2">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" name="img_poster" id="img_poster" class="form-control" accept="image/jpeg">
                    </div> -->
                
                    
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>