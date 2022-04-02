<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
require_once("./menu/index.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">

     <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsrecibos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
    
    <script src="../js/jquery-ui-autocompletar.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .ui-autocomplete.ui-front {
    max-height: 300px;
    width: 100px;
    overflow-y: auto;   
    overflow-x: hidden; 
    z-index:1100 !important;
}

.my-class-form-control-group{
  display:flex;
  align-items:Center;
}
</style>

<body style="background: #f5f5f5;">
   <header>
        <title>Kardex</title>
   </header>
   <section>  
        <div class="main"> 
        <form class="row g-3" id="frmrfechas" style="margin-bottom: 0px;">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
            <div class="row mb-3">
                <div class="col g-4">
                    <center><label class="titulos">Recibos Ingresados</label></center>
                </div>
            </div>
       </form>
            <table id="tbrecibo" class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th  style="display: none;">cod</th>
                        <th  scope="col">Serie</th>
                        <th  scope="col">Correlativo</th>
                        <th  scope="col">Tipo</th>
                        <th class="thtitulo" scope="col">Observación</th>
                        <th class="thtitulo" scope="col">Monto</th>
                        <th class="thtitulo" scope="col">Ver</th>
                    </tr>
                </thead>
                <tbody id="tbdrecibos">
                </tbody>
            </table>
        </div>     
    </section>



    <div class="modal fade" id="mddetalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Productos ingresados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="table-responsive" style="overflow: scroll;height: 500px;">
        <table class="table" id="tbdetalle">
          <thead>
              <tr>
              <th scope="col">#</th>
              <th scope="col">Producto</th>
              <th scope="col">Nro Serie</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              </tr>
          </thead>
          <tbody id="tbddetalle">

          </tbody>
        </table>
      </div>  
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>





</body>
        <script src="../js/abootstrap.min.js"></script>
        <link href= "https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet" >
        <link href='https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css' rel='stylesheet' type='text/css'>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap5.min.js"></script>
      
</html>

