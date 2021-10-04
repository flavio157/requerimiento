<div class="modal fade" id="mdpersonal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title" id="exampleModalLabel">Buscar Personal</h5></center>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <label>Nombre personal</label>
            <input id="txtcodpersonal" class="form-control" style="display: none;">
            <div class="col">
              <input type="text" id="txtpersonal" class="form-control" autocomplete="off">
            </div>
            <div id="personal" class="sugerenciaspersonal"></div>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAddpersonal" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>