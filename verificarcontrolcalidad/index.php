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

    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsverstock.js"></script>
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
        <div class="main"> 
            
          <form style="margin-bottom: 0px;" id="frmproduccion">
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo $zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo $cod?>"/>
                
              <div class="row mb-3">
                  <div class="col">
                      <center><label class="titulos">Verificar control calidad </label></center>
                  </div>
              </div>
      
              <div class="row mb-3">
                  <div class="col">
                    <label  class="col-sm-2 ">Buscar</label>
                    <div class="col-md-5 input-group  mb-3">
                    <input type="text" id="mdtxtpro" style="display: none;">
                      <input type="text" class="  form-control txtproduccion" id="txtproduccion" style="text-transform: uppercase;" placeholder="BUSCAR PRODUCCION">
                      <a class="btn btn-success" id="btnbuscclien">
                           <i class="icon-magnifying-glass" title="Buscar Molde"></i>
                       </a>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label class="thtitulo">F. Inicio</label>
                    <input type="date" class="form-control" id="dtiniciomd" value="<?php echo $fcha;?>"
                            max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 0 days"));?>">
                  </div>
              </div>
              
              

              
              <div class="table-responsive"  style="overflow: scroll;height: 500px;">
                  <table id="tbproducto" class="table table-sm mb-3" >
                    <thead>
                        <tr>
                            <th style="display: none;">cod</th>
                            <th ></th>
                            <th scope="col">Produccion</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbdproducto">
                    </tbody>
                </table>
              </div>
          </form>     
        </div>
    </section>    
</body>
  <script src="../js/abootstrap.min.js"></script>
</html>

