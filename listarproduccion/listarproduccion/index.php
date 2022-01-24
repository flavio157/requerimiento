<?php

header('Content-Type: text/html; charset=UTF-8');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];*/
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
<body style="background: #f5f5f5;">
   <header>
        <title>Moldes en fabricacion</title>
   </header>
   <section>  
        <div class="main"> 
            <form id="frmfabricacion">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo 'SMP2'//$ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php //$echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215' //$cod?>"/>
                   <div class="row">
                        <div class="col mb-3">
                            <center><label class="titulos">Producción</label></center>
                        </div>    
                    </div>
                    <div  class="row mb-3">
                        <div class="col">
                            <div class="table-responsive-sm" style="overflow: scroll;height: 180px;">  
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

                <div class="row">
                  <div class="col mb-3">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                      <input type="radio"  class="btn-check" name="btnradio" id="btnmerma" autocomplete="off" checked>
                      <label class="btn btn-outline-primary" for="btnmerma">Merma</label>
                      <input type="radio" class="btn-check" name="btnradio" id="btndesecho" autocomplete="off">
                      <label class="btn btn-outline-primary" for="btndesecho">Desechos</label>
                      <input type="radio" class="btn-check" name="btnradio" id="btnresiduos" autocomplete="off">
                      <label class="btn btn-outline-primary" for="btnresiduos">Residuos</label>
                      <input type="radio" class="btn-check" name="btnradio" id="btnresiduos" autocomplete="off">
                      <label class="btn btn-outline-primary" for="btnresiduos">final</label>
                    </div>
                  </div>
                </div>
                      <div class="row">
                          <div class="col-auto mb-2">
                            <label>Tipo de insumo</label>
                            <select class="form-select" id="sltipoinsum" name="sltipoinsum" disabled>
                              <option value="P" selected>Propio</option>
                              <option value="E">Externo</option>
                            </select>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <label class="form-label">Fecha Merma</label>
                          <input type="date" class="form-control" id="fechmerma" autocomplete="off"
                          min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."- 30 days"));?>"
                          max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 0 days"));?>"
                          value="<?php echo date("Y-m-d"); ?>">    
                        </div>
                        <div class="col">
                          <label class="form-label">Hora Merma</label>
                          <input type="time" class="form-control"  id="hormerma" autocomplete="off">    
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
                          <label class="form-label">Insumos</label>
                          <div class="input-group mb-3">
                            <input id="txtcodpro" class="form-control" style="display: none;"> 
                            <input type="text" class="form-control" id="txtinsumos" autocomplete="off"> 
                            <a class="btn btn-success" id="btnmdinsumo">
                              <i class="icon-magnifying-glass" title="buscar insumos"></i>
                            </a>
                          </div>
                        
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col">
                          <label class="form-label">Cantidad</label>
                          <input type="text" class="form-control" id="txtcantidad" autocomplete="off">    
                        </div>
                        <div class="col">
                          <label class="form-label">Tipo Merma</label>
                          <select class="form-select mb-3" id="slctipomerma" >
                            <option value="R" selected>Reingreso</option>
                            <option value="P">Perdida</option>  
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col g-3 ">
                            <a class="btn btn-primary" type="button" id="btnagregarmater" style="float: right;">
                                <i class='icon-add-to-list' title='Agregar molde'></i>
                            </a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="table-responsive-sm" style="overflow: scroll;height: 120px;">  
                                  <table  class="table table-sm" id="tbreportinsu">
                                      <thead>
                                          <tr>
                                            <th class="thtitulo" scope="col">Insumo</th>
                                            <th class="thtitulo" scope="col">Cantidad</th>
                                            <th class="thtitulo" scope="col">Acciones</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tbdreportinsu">
                                    
                                      </tbody>
                                  </table>
                              </div>  
                        </div>
                      </div>
                       
                   


                   <!-- <div class="row">
                        <div class="col g-4">
                            <center><label class="titulos">Ocurrencias</label></center>
                        </div>    
                    </div>
                    <div class="row mb-1">
                         <div class="col">
                            <label for="formpromocion" class="form-label">Observacion</label>
                            <textarea  type="text" class="form-control" rows="3" name="txtocurrencias" id="txtocurrencias"></textarea>
                         </div>
                    </div>-->
                    <div class="row">
                      <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left ">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                      </div>
                      <div class="col g-4 divbotones">
                        <button  type="button" class="btn btn-primary mb-2" id="btnguardar" style="float: right;">
                          <i class="icon-save" title="Guardar datos"></i>
                          Guardar
                        </button>
                      </div> 
                    </div>  
                    <img alt="Código QR" id="codigo" style="display: none;">
            </form>

        <div class="modal fade" id="mdregisavances" tabindex="-1"   aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar avances de producción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <div class="row g-2">
                        <div class="col">
                            <label for="formpromocion" class="form-label">cantidad por paquete</label>  <!--cantidad dentro de cada caja -->
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm" name="mdcantxcaja" autocomplete="off" id="mdcantxcaja">
                              <span class="input-group-text" id="basic-addon1">Und</span>
                            </div>
                        </div>
                        <div class="col">
                          <label for="formfpago" class="form-label">paquete a sacar</label><!--es la cantidad de cajas a salir es es dato calculable por sistema
                            se calcula con la cantidad por paquete o la cantidad del items-->
                            <div class="input-group mb-3">
                              <input type="number" class="form-control form-control-sm" id="mdcajasxsacar" name="mdcajasxsacar">
                              <span class="input-group-text" id="basic-addon1">Und</span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                      <div>
                        <a class="btn btn-success" id="btnlstformula" style="display: none;">
                          <i class="icon-print" title="Imprimir ticket"></i>
                        </a>
                      </div>
                    </div>  -->
                    <label id="lblmensaje"></label>  
                </form>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btngavances">Guardar</button>
              </div>
            </div>
          </div> 
        </div>

        <div class="modal fade" id="mdocurrencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


        <div class="modal fade" id="mdlstinsumos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Insumos utilizados</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="table-responsive-sm" style="overflow: scroll;height: 500px;"> 
                <table class="table" id="tblmdinsumo">
                  <thead>
                    <tr>
                    <th class="thtitulo" scope="col" style="display: none;">producion</th>
                      <th class="thtitulo" scope="col" style="display: none;">codigo</th>
                      <th class="thtitulo" scope="col">Nombre</th>
                      <th class="thtitulo" scope="col">Cantidad</th>
                      <th class="thtitulo" scope="col" style="display: none;">Tipo</th>
                      <th class="thtitulo" scope="col">Acción</th>
                    </tr>
                  </thead>
                  <tbody id="tbdlmdinsumo">
                  </tbody>
                </table>
              </div>  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary">Aceptar</button>
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