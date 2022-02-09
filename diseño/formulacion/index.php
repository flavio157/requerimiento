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
    <script src="./js/jsformulacion.js"></script>
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
        <title>Registro de formulación</title>
   </header>
   <section>  
        <div class="main"> 
          <form style="margin-bottom: 0px;" id="frmformulacion">
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo $cod?>"/>
              <div class="row mb-3">
                  <div class="col">
                      <center><label class="titulos">Registro de formulacion</label></center>
                  </div>
              </div>
              <!--<div class="row"> 
                <label for="inputPassword2">Nombre de la formulación</label>
                <div class="input-group">
                  <input type="text" class="form-control mayu" id="txtnombformula" name="txtnombformula" autocomplete="off" disabled> 
                  <a class="btn btn-success" id="btnlstformula" data-bs-toggle="modal" data-bs-target="#mdformula">
                    <i class="icon-magnifying-glass" title="Buscar cliente"></i>
                  </a>
                </div>
              </div>-->
              <div class="row">
                <div class="col">
                <label>Nombre producto</label>
                  <div class="input-group">
                    <input type="text" id="txtproducto" name='txtproducto' class="form-control mayu"  placeholder="Buscar producto">    
                    <input type="text" id="txtnombformula" name="txtnombformula"  style="display: none;"> 
                    <a class="btn btn-success" id="btnlstformula" data-bs-toggle="modal" data-bs-target="#mdformula">
                      <i class="icon-magnifying-glass" title="Buscar cliente"></i>
                    </a>
                  </div>
                </div>  
                <div class="row"> 
                  <div class="col">
                    <label for="inputPassword2">U. medida</label>
                    <input type="text" id="txtunimedida" name="txtunimedida" class="form-control mayu" disabled>
                  </div>
                  <div class="col">
                      <label for="inputPassword2">Cantidad</label>
                      <input type="text" id="txtformulacion" name="txtformulacion" class="form-control">
                    </div>
                </div>
              </div>

                <div class="row">
                  <div class="col g-4">
                      <center><label class="titulos">Insumos</label></center>
                  </div>
                </div>

                <div class="row  mb-1"> 
                  <div class="col">
                    <label>Insumos</label>
                    <div class="input-group mb-3">
                      <input type="text" id="txtmaterial" name="txtmaterial" class="form-control mayu">
                    </div>
                  </div>
                  <div class="col">
                    <label >Cantidad por usar</label>
                    <input type="number" id="txtcantxusar" name="txtcantxusar" class="form-control">
                  </div>
                </div>
                <div class="row ">
                   <div class="col g-3 ">
                      <a class="btn btn-primary" type="button" id="btnagregarmater" style="float: right;">
                          <i class='icon-add-to-list' title='Agregar molde'></i>
                      </a>
                   </div>
                </div>
                <div class="table-responsive" style="overflow: scroll;height: 254px;">
                  <table class="table" id="tbmateriales">
                    <thead>
                        <tr>
                          <th class="thtitulo" style="display: none;">Codigo</th>
                          <th class="thtitulo">Material</th>
                          <th class="thtitulo">Cantidad</th>
                          <th class="thtitulo">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbdmateiales"> 
                    </tbody>  
                  </table>
                </div>    
          </form>
            <div class="row">
               <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left ">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                <div class="col g-4 divbotones">
                  <button  type="button" class="btn btn-primary mb-2" id="btngformula" style="float: right;">
                     <i class="icon-save" title="Guardar datos"></i>
                    Guardar
                   </button>
               </div> 
            </div> 
        </div>     
    </section>

    <div class="modal fade" id="mdformula" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Formulaciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
          <div class="table-responsive" style="overflow: scroll;height: 366px;">
            <table class="table" id="tbformula">
              <thead>
                <tr>
                <th scope="col" style="display: none;">ID</th>
                <th scope="col" class="thtitulo">Nombre</th>
                <th scope="col" class="thtitulo">Cantidad</th>
                <th scope="col" class="thtitulo">Acciones</th>
                </tr>
              </thead>
                <tbody id="tbdformula">
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                      
        </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mditemformula" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar Material</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
          <div class="row "> 
            <div class="col">
              <label>Material</label>
              <div class="input-group mb-3">
                <input id="mdcodmate" style="display: none;">
                <input type="text" id="mdmaterial" name="mdmaterial" class="form-control mayu" disabled>
              </div>
            </div>
            <div class="col">
              <label >Cantidad por usar</label>
              <input type="number" id="mdcantxusar" name="mdcantxusar" class="form-control">
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>         
          <button type="button" id="btnactuitems" class="btn btn-primary">Actualizar</button>
        </div>
        </div>
      </div>
    </div>

</body>
  <script src="../js/abootstrap.min.js"></script>
</html>

