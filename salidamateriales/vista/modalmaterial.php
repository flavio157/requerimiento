<div class="modal fade" id="mdmaterial" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title" id="exampleModalLabel">Buscar material</h5></center>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <label>Material</label>
            <input id="txtcodmaterial" class="form-control" style="display: none;">
            <div class="col">
              <input type="text" id="txtmaterial" class="form-control" autocomplete="off">
            </div>
            <div id='material' class="sugerencias"></div>
        </div>
        <div class="row g-2">
          <div class="col">
              <label for="formpromocion" class="form-label">Nro Serie</label>
              <input type="number" class="form-control" name="G_promocion" autocomplete="off" id="G_promocion">
            </div>
          <div class="col card-body d-flex justify-content-between align-items-center" style="padding: 2rem 1rem !important; flex:0 !important">
            <a class="btn btn-primary active btn-block">
                <i class="icon-attachment" title="Alinear a la derecha"></i>
            </a>
          </div>
        </div>
        <div class="row g-2">
          <table id="tbmaterialsalida" class="table table-striped">
                      <thead>
                          <tr>
                              <th scope="col" class="titulos">Material</th>
                              <th scope="col" class="titulos">Serie</th>
                              <th scope="col" style="display: none;">Descripcion</th>
                              <th scope="col" class="titulos">Acciones</th>
                          </tr>
                      </thead>
                      <tbody id="tbmaterial">
                    </tbody>
          </table>
        </div>
      </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAddamaterial" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>