<div class="modal fade" id="Mostrafoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <style>
               @media only screen and (max-width: 700px) {
               video{
                    max-width: 100%;
                    }
               }
          </style>
        <h5 class="modal-title" id="exampleModalLabel">PREVISUALIZAR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
               <input type="text" name="nombre" id="nombre" style="visibility:hidden">
               

               <div class="row g-2">
                    <center><label for="formTipo" class="form-label">SELECCIONE UN DISPOSITIVO</label></center>
                    <div class="col-7">
                         <select class="form-select" aria-label="Default select example" name="listaDeDispositivos" id="listaDeDispositivos">  
                         </select>          
                    </div>
                    <div class="col-5">
                         <a id="boton" class="btn btn-info">Tomar foto</a>
                         <p id="estado"></p>
                    </div>
                </div>

               <br>
               <video muted="muted" id="video"></video>
               <canvas id="canvas" style="display: none;"></canvas>  
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <script src="./js/script.js"></script>
               </div>
      </div>
     
    </div>
  </div>
</div>