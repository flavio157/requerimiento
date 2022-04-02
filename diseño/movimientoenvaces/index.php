<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$fcha = date("d/m/Y");
/*$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];*/
require_once("../menu/index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">

    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsmovimientoenvace.js"></script>
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
          <form style="margin-bottom: 0px;" id="frmmovimiento">
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo ''//$ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo ''//$zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215' //$cod?>"/>
            <div class="row g-2">
                <div class="col">
                  <div><center><h2>GUIA INTERNA</h2></center></div>
                </div>
                <div class="col border mb-3">
                    <center>N°</center>
                    <center>G-</sup><label id="lblnroguia"></label></center>      
                </div>
            </div> 

            <!--<div class="col-12 border">-->
              <div class="row g-2" >
                <div class="col">
                <label>Cliente</label>
                  <div class="input-group flex-nowrap">
                  <input name="txtcodclie" id="txtcodclie" style="display: none;">    
                  <input name="txtdireccion" id="txtdireccion" style="display: none;">    
                      <input type="text" class="form-control mayu" placeholder="Buscar por nombre o razon social" name="txtcliente" id="txtcliente" autocomplete="off">    
                      <a class="btn btn-success" id="btnbuscclien" data-bs-toggle="modal" data-bs-target="#mdclientemolde">
                        <i class="icon-users" title="Buscar Molde"></i>
                      </a>
                  </div>
                </div>  
                <div class="col-md">
                  <label>Fecha</label>
                  <input type="text" class="form-control" id="txtfecha" name="txtfecha" value="<?php echo $fcha?>" disabled>
                </div> 
              </div>
              <div class="row ">
                <div class="col g-3">
                  <label>Observación</label>
                  <textarea class="form-control mayu" rows="3" id="txtobservacion" name="txtobservacion"></textarea>
                </div>
              </div>

              <div class="row">
                <div class="col-md-8 g-3">
                  <label>Envaces</label>
                  <input type="text" class="form-control" disabled id="txtcodenvace" style="display:none">
                  <input type="text" class="form-control mayu" id="txtenvaces" placeholder="Buscar envaces">
                </div>
                <div class="col g-3">
                  <label>Stock</label>
                  <input type="text" class="form-control" disabled id="txtstock">
                </div>
                <div class="col g-3">
                  <label>Cantidad</label>
                  <input type="text" class="form-control" id="txtcantidad">
                </div>
              </div>
              <div class="row">
                <div class="col g-3">
                  <button type="button" class="btn btn-primary" id="btnagregar" style="float:right">
                    <i class="icon-plus" title="Guardar datos"></i>
                  </button>
                </div>
              </div>

              <div class="row">
                <div class="table-responsive g-3" style="overflow: scroll;height: 310px;">
                  <table class="table" id="tbenvaces">
                    <thead>
                      <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="tbdenvaces">
                     
                    </tbody>
                  </table>
                </div>  
              </div>

              <div class="row">
                    <div class="col g-4">
                        <button type="button" id="btncancelar" class="btn btn-primary">Nuevo</button>
                        </button>
                    </div>
                    <div class="col g-4">
                        <button type="button" style="float: right;" id="btnguarguia" class="btn btn-primary">Guardar</button>
                        </button>
                    </div> 
                </div> 
          </form> 

          <div class="modal fade" id="mdclientemolde" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registro de cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frmclientemolde">
                            <div class="row">
                                
                                <div class="row mb-2">
                                    <div class="col">
                                        <input type="text" name="txtcodclientemodal" id="txtcodclientemolda" style="display: none;">  
                                        <label for="formpromocion"  class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control mayu" placeholder="Nombre o razon social" name="txtnombcliente" id="txtnombcliente" autocomplete="off">       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label  class="form-label">Dirección</label> 
                                        <input type="text" class="form-control mayu" placeholder="Direccion" name="txtdireccliente" id="txtdireccliente" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label  class="form-label">RUC</label>
                                        <input type="Number" class="form-control" placeholder="RUC" name="txtidenticliente" id="txtidenticliente" autocomplete="off">    
                                    </div>
                                </div> 
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnsalircli" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btngcliemodle" class="btn btn-primary">Guardar</button>
                    </div>
                    </div>
                </div>
            </div>
          </div>
    </section>    
</body>
  <script src="../js/abootstrap.min.js"></script>
</html>

