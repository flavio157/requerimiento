<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

/*if(!isset($_SESSION['zona'])){
  header('Location: index.php');
  exit;
} */
date_default_timezone_set('America/Lima');
$fcha = date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
      <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <link rel="STYLESHEET" type="text/css" href="../css/bootstrap.min.css">
        <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
   
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="../css/responsive.css" />
    <script src="../js/jsmap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
   <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcyoqHeBQU9jKb3MzMKu86mXtzI89V_Cg&callback=initMap">
    </script>
  </head>
  <body>
    <form>
      <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
      <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
      <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
      <div id="mensajesgenerales">
                                   
      </div>

      <div class="divtitulo">
          <h5><label for="formdescripcion" class="form-label">MARCAR DIRECCIONES</label></h5>
      </div>
     
      <div class="contenedorbs">

              <span id="latitud" ></span>
               <div class="mb-3 contenerdorslc">
                  <input type="text" class="form-control" id="txtcontrato" name="txtcontrato">
               </div>
               <div class="contenedorboton">
                   <div class="mb-3">
                       <div class="gap-2 divbtn col-6 mx-auto">
                               <div class="col divbtnmostrar">
                               <!--  <button class="btn btn-primary" id="lstcoordenadas">Mostrar</button>-->
                                   <button class="btn btn-primary" id="coordenadas">Obtener</button>
                               </div>
                       </div>
                   </div>
               </div>
      </div>  






      
     </form> 
      <div class="main">
          <div id="map">
          </div>
      </div>
  </body>
</html>