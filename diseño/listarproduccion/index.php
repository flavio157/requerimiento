<?php

header('Content-Type: text/html; charset=UTF-8');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];*/
//require_once("./menu/index.php");
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    
    <script src="./js/jslstproduccion.js"></script>
    <link rel="stylesheet" type="text/css" href="../fonts/style.css">
    <link rel="stylesheet" type="text/css" href="./css/responsive.css">

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
        <title>Moldes en fabricacion</title>
   </header>
   <section>  
        <div class="ajax-loader">
          <img src="loading.gif" class="img-responsive" />
        </div> 
        <div class="main"> 
            <form id="frmfabricacion">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo 'SMP2'//$ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  ''//$zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215'//$cod?>"/>
                   <div class="row">
                        <div class="col mb-3">
                            <center><label class="titulos">Producción</label></center>
                        </div>    
                    </div>
                    <div  class="row mb-3">
                        <div class="col">
                            <div class="table-responsive-sm" style="overflow: scroll;height: 500px;">  
                                <table id="tbproduccion" class="table table-sm">
                                    <thead>
                                        <tr>
                                          <th class="thtitulo" scope="col" style="display: none;">produccion</th>
                                          <th class="thtitulo" scope="col">Nombre</th>
                                          <th class="thtitulo" scope="col">Cliente</th>
                                          <!--<th class="thtitulo" scope="col">Molde</th>-->
                                          <th class="thtitulo" scope="col">Cantidad</th>
                                          <th class="thtitulo" scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbdproduccion">
                                  
                                    </tbody>
                                </table>
                            </div>  
                        </div>     
                    </div> 
                    
                     <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mdmerma">Merma</button>
                      <button type="button" id="btnsobras" class="btn btn-success" >Sobras</button>
                      <button type="button" id="btnresiduos" class="btn btn-secondary">Residuos</button>
                      <button type="button" id="btndesecho" class="btn btn-danger" >Desechos</button>-->

             
                    <!--<img alt="Código QR" id="codigo" style="display: none;">-->
            </form>

        <div class="modal fade" id="mdregisavances" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"   aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar producción</h5>
                <button type="button" class="btn-close"  data-bs-dismiss="modal"  id="btncloseavan" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="frmavances">  
                  <div class="row">
                    <div class="col mb-3">
                      <label>Total de produccion: </label>
                    </div>
                    <div class="col mb-3">
                      <input type="text" class="form-control form-control-sm" id="mdtotal" name="mdtotal"
                      disabled style="border: 0;"> 
                    </div>  
                  </div>
                    <div class="row g-2"> 
                        <div class="col">
                            <input type="text" style="display: none;" id="mdlote" name="mdlote">
                            <input type="text" style="display: none;" id="mdcodprod" name="mdcodprod">
                            <input type="text" style="display: none;" id="mdproduc" name="mdproduc">
                           
                            <label for="formcantidad" class="form-label">Tara</label>
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm"  name="mdtara" id="mdtara" autocomplete="off">
                              <span class="input-group-text" id="basic-addon1">Kg</span>
                            </div>
                        </div>
                        <div class="col">
                            <label for="formfpago" class="form-label">Peso neto</label>
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm" name="mdpesoneto" id="mdpesoneto">
                              <span class="input-group-text" id="basic-addon1">Kg</span>
                            </div>
                        </div>
                      </div>
                    <div class="row g-1">
                        <div class="col">
                            <label for="formpromocion" class="form-label">cantidad por paquete</label>  <!--cantidad dentro de cada caja -->
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm" name="mdcantxcaja" autocomplete="off" id="mdcantxcaja">
                              <span class="input-group-text" id="basic-addon1">Uds</span>
                            </div>
                        </div>
                        <div class="col">
                          <label for="formfpago" class="form-label">paquete a sacar</label><!--es la cantidad de cajas a salir es es dato calculable por sistema
                            se calcula con la cantidad por paquete o la cantidad del items-->
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm" id="mdcajasxsacar" name="mdcajasxsacar">
                              <span class="input-group-text" id="basic-addon1">Uds</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col" style="padding-right: 0px;">
                          <label>Turno</label>
                          <select class="form-select" id="slcmdturno" name="slcmdturno">
                            <option selected value="">Seleccione Turno</option>
                            <option value="M">Mañana</option>
                            <option value="T">Tarde</option>
                          </select>
                        </div>
                        <div class="col" style="padding-left: 5px;">
                          <input type="text" id="mdcodmaquinista" name="mdcodmaquinista" style="display: none;">
                          <label>Maquinista</label>
                            <input type="text" class="form-control" id="mdmaquinista" name="mdmaquinista">
                        </div>
                    </div>  
                    <div class="row mb-1">
                      <div class="col">
                        <a class="btn btn-success" id="btnimprimir" >
                          <i class="icon-print" title="Imprimir"></i>
                        </a>
                      </div>
                    </div>  
                    <label id="lblmensaje"></label>  
                </form>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnregisproduc" disabled>Registrar producción</button>
                <button type="button" class="btn btn-primary" id="btngavances">Registrar reportes</button>
              </div>
            </div>
          </div> 
        </div>

        <div class="modal fade" id="mdocurrencia" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ocurrencias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Descripciòn</label>
                  <textarea class="form-control" id="txtocurrencias" rows="3"></textarea>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="table-responsive-sm" style="overflow: scroll;height: 189px;"> 
                      <table class="table" id="tbocurrencia">
                        <thead>
                          <tr>
                              <th>Descripción</th>
                              <th>Fecha</th>
                          </tr>      
                        </thead>
                        <tbody id="tbdocurrencia">
                        </tbody>  
                      </table>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btngocurrencia">Guardar</button>
              </div>
            </div>
          </div>
        </div>


      <div class="modal fade" id="mdregiresiduo" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Registrar residuos</h5>
              <button type="button" class="btn-close" id="btnclose" ></button>
            </div>
            <div class="modal-body">
            <form id="mdregistroresi">
                    <div class="row">
                      <div class="col mb-3">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                          <input type="radio"  class="btn-check" name="btnradio" id="btnmerma" autocomplete="off" checked>
                          <label class="btn btn-outline-primary merma" for="btnmerma">Merma</label>
                          <input type="radio" class="btn-check" name="btnradio" id="btndesecho" autocomplete="off">
                          <label class="btn btn-outline-primary desechos" for="btndesecho">Desechos</label>
                          <input type="radio" class="btn-check" name="btnradio" id="btnresiduos" autocomplete="off">
                          <label class="btn btn-outline-primary sobra" for="btnresiduos">Sobrantes</label>
                        </div>
                      </div>
                    </div>
                  
                      <div class="row">
                        <div class="col">
                          <label class="form-label">Fecha incidencia</label>
                          <input type="date" class="form-control" id="fehincidencia" autocomplete="off"
                          min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 30 days"));?>"
                          max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 0 days"));?>"
                          value="<?php echo date("Y-m-d");?>">     
                        </div>
                        <div class="col">
                          <label class="form-label">Hora incidencia</label>
                          <input type="time" class="form-control" id="horincidencia" autocomplete="off">    
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" rows="3" id="txtobservacion"></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label class="form-label">Producto Malogrado</label>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtprodfalla" autocomplete="off">    
                            <span class="input-group-text" id="basic-addon1">Uds</span>
                          </div>
                        </div>
                        <div class="col">
                          <label class="form-label">Peso</label>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtcantidad" autocomplete="off">    
                            <span class="input-group-text" id="basic-addon1">g</span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-auto">
                          <label class="form-label">Tipo Merma</label>
                          <select class="form-select mb-3" id="slctipomerma" >
                            <option value="R" selected>Reingreso</option>
                            <option value="P">Perdida</option>  
                          </select>
                        </div>
                      </div>
                  </form>        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" id="btncerragre">Cerrar</button>
              <button type="button" class="btn btn-primary" id="btnguardar">Confirmar</button>
            </div>
          </div>
        </div>
      </div>



      <div class="modal fade" id="mdmodacregiresidu" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Registrar residuos</h5>
              <button type="button" class="btn-close"  data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                  <div class="row">
                      <div class="col mb-3">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                          <input type="radio"  class="btn-check" name="btnradio" id="btnmodimerma" autocomplete="off" checked>
                          <label class="btn btn-outline-primary" for="btnmodimerma">Merma</label>
                          <input type="radio" class="btn-check" name="btnradio" id="btnmoddesecho" autocomplete="off">
                          <label class="btn btn-outline-primary" for="btnmoddesecho">Desechos</label>
                          <input type="radio" class="btn-check" name="btnradio" id="btnmodresiduos" autocomplete="off">
                          <label class="btn btn-outline-primary" for="btnmodresiduos">Sobrantes</label>
                        </div>
                      </div>
                    </div>
            <form id="frmdmresiduos">
                    <div class="row">
                        <div class="col">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" rows="3" id="txtmdobservacion" name="txtmdobservacion"></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label class="form-label">Producto Malogrado</label>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="txtmdprodfalla" id="txtmdprodfalla" autocomplete="off">    
                            <span class="input-group-text" id="basic-addon1">Uds</span>
                          </div>
                        </div>
                        <div class="col">
                          <label class="form-label">Peso</label>
                          <div class="input-group mb-3">
                            <input type="text" id="txtmdpeso" name="txtmdpeso" style="display: none;"> 
                            <input type="text" class="form-control" name="txtmdcantidad" id="txtmdcantidad" autocomplete="off">    
                            <span class="input-group-text" id="basic-addon1">g</span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <input type="text" id="slcmdtipo" name="slcmdtipo" style="display: none;"> 
                        <div class="col-auto">
                          <label class="form-label">Tipo Merma</label>
                          <select class="form-select mb-3" id="slcmdtipomerma" name="slcmdtipomerma">
                            <option value="R" selected>Reingreso</option>
                            <option value="P">Perdida</option>  
                          </select>
                        </div>
                      </div>

                      <div class="row" id="divtable">
                        <div class="col">
                          <table class="table" id="tbmodificar">
                              <thead>
                                <tr>
                                  <th>Descripcion</th>
                                  <th>cantidad</th>
                                  <th>Acción</th>
                                </tr>
                              </thead>
                              <tbody id="tbdmodificar">
                               
                              </tbody>
                          </table>
                        </div>
                      </div>

                  </form>        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" id="btnmodificaresi">Confirmar</button>
            </div>
          </div>
        </div>
      </div>






    </div>    
</body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script src="https://unpkg.com/qrious@4.0.2/dist/qrious.js"></script>
</html>
<script>
	

    
	</script>
