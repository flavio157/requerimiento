<div class="modal fade" id="mdmaterial" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title" id="exampleModalLabel">Buscar material</h5></center>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmagregarProducto">
            <div class="row g-2">
              <div class="col">
                  <label for="formfpago" class="form-label">Nombre del Producto</label>
                  <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtnombreproducto" id="mtxtnombreproducto">
              </div>   
              <div class="col">
                      <label for="formfpago" class="form-label">Codigo Producto</label>
                      <input type="text" class="form-control" name="mtxtcodigopro" id="mtxtcodigopro" autocomplete="off">
              </div> 
            </div>                    
            <div class="row g-2">
                <div class="col">
                  <label  for="formentrega" class="form-label">Categoria</label>
                  <select class="form-select" id="slcategoria" aria-label="Default select example">
                    <option selected>Seleccione Categoria</option>
                    <option value="00001">INSUMOS COSMETICA</option>
                    <option value="00002">INSUMOS DE ALIMENTOS</option>
                    <option value="00004">PRODUCTOS DE  ALIMENTOS</option>
                    <option value="00007">INSUMO DE PLASTICOS</option>
                    <option value="00008">PRODUCTO PLASTICOS</option>
                    <option value="00009">UTILES DE ESCRITORIO</option>
                  </select>
                </div>
                </div>
                  <div class="row g-2">
                    <div class="col">
                      <label for="formcantidad" class="form-label">Unidad Medida</label>
                      <input type="text" class="form-control"  name="mtxtunimedida" id="mtxtunimedida">
                    </div>
                  <div class="col">
                    <label for="formfpago" class="form-label">Stock</label>
                    <input type="text" class="form-control" name="mtxtstock" id="mtxtstock" autocomplete="off">
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col">
                    <label for="formpromocion" class="form-label">Abreviatura</label>
                    <input type="text" class="form-control" name="mtxtabreviatura" autocomplete="off" id="mtxtabreviatura">
                  </div>
                  <div class="col">
                    <label for="formfpago" class="form-label">COD CONTRABLE</label>
                    <input type="text" class="form-control" id="mtxtcontable" name="mtxtcontable">
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col">
                    <label for="formpromocion" class="form-label">Peso neto</label>
                    <input type="text" class="form-control" name="mtxtneto" autocomplete="off" id="mtxtneto">
                  </div>
                  <div class="col">
                    <label for="formfpago" class="form-label">Clase</label>
                    <select class="form-select" id="slclase" aria-label="Default select example">
                      <option selected>Seleccione Categoria</option>
                      <option value="00001">Devolucion</option>
                      <option value="00002">No devolucion</option>
                    </select>
                  </div>
                </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" id="btnguardarprod" class="btn btn-primary">Guardar</button>
         </div>
      </div>
    </div>
  </div>
</div>