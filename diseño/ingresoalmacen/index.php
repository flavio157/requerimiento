<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$fcha = date("Y-m-d");
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
require_once("../menu/index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	  <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsregistroalmacen.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
    <script src="../js/sweetalert2@11.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="../js/jquery-ui-autocompletar.js"></script>
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
        <title>Registro de producción</title>
   </header>
   <section>
        <div class="ajax-loader">
          <img src="loading.gif" class="img-responsive" />
        </div> 
        <div class="main"> 
          <form style="margin-bottom: 0px;" id="frmproduccion">
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo $zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo $cod?>"/>
                  <div class="row mb-3">
                      <div class="col">
                          <center><label class="titulos">Ingreso al almacén general</label></center>
                      </div>
                  </div>
                    <div class="table-responsive" style="overflow: scroll;height: 600px;">
                      <table class="table" id="tbderivar">
                          <thead>
                            <tr>
                              <th>Operario</th> 
                              <th>Producto</th> 
                              <th>Fecha</th>
                              <th>Paquetes</th>
                              <th>Cantidad</th>
                              <th>Uno de</th>
                              <th>Total</th>
                              <th>Peso (KG)</th>
                              <th>Acciones</th>
                            </tr>      
                          </thead>
                          <tbody id="tbdderivar">
                          </tbody>  
                      </table>
                </div> 
              </div> 
          </form>
        </div>  
    </section>
</body>
  <script src="../js/abootstrap.min.js"></script>
</html>

