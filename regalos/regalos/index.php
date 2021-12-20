<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];*/
//require_once(".././menu/index.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	  <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">

    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsregalos.js"></script>
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
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo 'SMP2'//$ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo 1//$zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  '0215'//$cod?>"/>
              <div>
                <center>Regalos</center>
              </div> 
              <div class="row mb-3">
                  <div class="col g-4">
                    <div class="row">
                      <div class="col">
                        <input type="text" id="txtproducto" name="txtproducto" class="form-control mayu" placeholder="Producto">
                      </div>
                    </div>
                  </div>
              </div>
          </form>
          <table id="tbregalo" class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th  style="display: none;">cod</th>
                        <th  scope="col">Producto</th>
                        <th  scope="col">Precio</th>
                        <th  style="display: none;" scope="col">gramaje</th>
                        <th  scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbdregalo">
                </tbody>
          </table>
          <div class="modal-footer">
            <button type="button" id="btnguardar" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
          </div>
      </div>     
    </section>
</body>
</html>

