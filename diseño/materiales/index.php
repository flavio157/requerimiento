<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];*/
require_once("../menu/index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	  <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsformulario.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
ul.ui-autocomplete {
    z-index: 1100;
}
.ui-autocomplete.ui-front {
    max-height: 300px;
    width: 100px;
    overflow-y: auto;   
    overflow-x: hidden; 
    z-index:1100 !important;
}
</style>
<body style="background: #f5f5f5;">
    <header>
        <title>Ingreso de Materiales</title>
   </header>
   <section>  
        <div class="main">
                <form id="frmmatsalida">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo 'SMP2' //$ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  ''//$zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215'//$cod?>"/>
                <div id="mensajesgenerales">                           
                </div>
                <div class="row">
                    <div class="col g-3">
                    <center><label class="titulos">Registro de material de salida</label></center>
                    </div>    
                </div>
                <div class="row">
                    <div class="col g-4">
                        <label class="thtitulo">Personal Solicitante</label>
                    </div>      
                </div>


                <div class="mb-3">
                    <div class="row">
                        <div class="col-4" style="padding-right: 6px;">
                            <input type="text" class="form-control" name="txtcodigoper" id="txtcodigoper" disabled>
                        </div> 
                        <div class="col-8" style="padding-left: 0px;">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" name="txtnombrepersonal" id="txtnombrepersonal" disabled>
                                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                                    <i class="icon-add-user" title="Buscar Personal"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
        

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label thtitulo">Descripción</label>
                    <textarea class="form-control" id="txtdescripcion" rows="2"></textarea>
                </div>

                <div class="row">
                    <div class="col">
                    <label class="thtitulo">Material Solicitado</label>
                    </div>    
                </div>
                
                <div class="mb-3">
                    <div class="row">
                        <div class="col-7" style="padding-right: 6px;">
                            <input type="text" class="form-control" name="txtcodmaterial" id="txtcodmaterial" style="display: none;">
                            <!--<div class="input-group mb-3" >-->
                                <input type="text" class="form-control" name="txtmaterial" id="txtmaterial" placeholder="Material">
                            <!--</div>-->
                        </div> 

                        <div class="col-5" style="padding-left: 0px;">
                            <div class="input-group mb-3" >
                                <input type="text" class="form-control" name="txtseriematerial" id="txtseriematerial" placeholder="Nro Serie">
                                
                                <a class="btn  btn-primary" id="aentrega" >
                                    <i class="icon-squared-plus" title="Agregar Material"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-4" style="padding-right: 0px;">
                        <label class="thtitulo">Cantidad</label>
                        <input type="text" class="form-control" name="txtcanmaterial" id="txtcanmaterial" placeholder="cantidad">
                    </div>
                    <div class="col-4" style="padding-left: 6px;">
                        <label class="thtitulo">Stock</label>
                        <input type="text" class="form-control" name="txtstckmaterial" id="txtstckmaterial" disabled>
                    </div>
                    <div class="col-4" style="padding-left: 6px;">
                        <div class="d-grid col-4 ">
                            <label class="thtitulo">Reeingreso</label>
                            <a class="btn  btn-primary" id="btnreingreso" style="width: 52%;">
                                <i class="icon-box" title="Reeingreo material perdido"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div  class="row">
                    <div class="col">
                        <div class="col g-1 titulos materiales"><center>Material a entregar</center></div>    
                        <div class="table-responsive" style="overflow: scroll;height: 250px;">  
                            <table id="tbmaterialentrega" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Serie</th>
                                        <th class="thtitulo" scope="col">cant.</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tdmaterialentrega">
                                </tbody>
                            </table>
                        </div>  
                    </div> 
                    <div class="col">  
                        <div class="col g-1 titulos materiales"><center>Materiales a devolver</center>
                        </div> 
                        <div class="table-responsive" style="overflow: scroll;height: 250px;">  
                            <table id="tbmaterialsalida" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Serie</th>
                                        <th class="thtitulo" scope="col">cant.</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbmaterial">
                                </tbody>
                            </table>
                        </div>     
                    </div>     
                </div>
                <div class="row">
                    <div class="col g-4">
                        <button id="btnnuevo" type="button" class="btn btn-primary mb-2 pull-left">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                    <div class="col g-4">
                        <button id="btnguardar" type="button" class="btn btn-primary mb-2"  style="float: right;">
                        <i class="icon-save" title="Guardar datos"></i>
                        Guardar
                        </button>
                    </div> 
                </div> 
                </form>  

            <div class="modal fade" id="mdpersonal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <center><h5 class="modal-title">Buscar Personal</h5></center>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <label>Nombre personal</label>
                        <input id="txtcodpersonal" class="form-control" style="display: none;">
                        <div class="col">
                          <input type="text" id="txtpersonal" class="form-control" autocomplete="off">
                        </div>
                    </div>   
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnAddpersonal" class="btn btn-primary">Agregar</button>
                  </div>
                </div>
              </div>
            </div>

      

        <!-- Modal -->
        <div class="modal fade" id="modalrepor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Devolución de materiales</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">   
                            <div class="col mb-2">
                                <input id="txtmodcodpro" name="txtmodcodpro"  class="form-control" style="display: none;">
                                <input id="txtmodserie" name="txtmodserie" class="form-control" style="display: none;">
                                <input id="txtmodtipo" name="txtmodtipo" class="form-control" style="display: none;">
                                <input id="codmatxdia" name="codmatxdia" class="form-control" style="display: none;">
                                <label for="exampleFormControlTextarea1" class="form-label thtitulo">Material</label>
                                <input type="text" id="txtmodnombpro" class="form-control" autocomplete="off" disabled>
                                <input id="txtmodsalida" class="form-control" style="display: none;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label thtitulo">Cantidad</label>
                                <input type="Number" id="txtmodcanpro" class="form-control" autocomplete="off">
                            </div>
                            <div class="col mb-2">
                                    <label for="exampleFormControlTextarea1" class="form-label thtitulo">Motivo</label>
                                    <select class="form-select" id="modslcmotivo" aria-label="Default select example">
                                        <option value="D" selected>Devolucion</option>
                                        <option value="R">Reotorgar</option>
                                        <option value="P">Perdido</option>
                                    </select>
                            </div>
                        </div>
                    
                        <div class="row">   
                            <div class="col mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label thtitulo">Descripción</label>
                                <textarea class="form-control" id="txtmodadescr" rows="2" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="modbtnguardar" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal reeingreso de material perdido -->
        <div class="modal fade" id="modalreingreso" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reingreso de material perdido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frmreingreso">
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="txtreincodmat" name="txtreincodmat" style="display: none;">
                                    <input type="text" id="txtreinsalida" name="txtreinsalida" style="display: none;">
                                    <label for="exampleFormControlTextarea1" class="form-label thtitulo">Material</label>
                                    <input type="text" id="txtreinmater" name="txtreinmater" class="form-control" autocomplete="off" disabled>
                                    <input type="text" id="txtreintipo" name="txtreintipo" style="display: none;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label thtitulo">Cantidad Perdida</label>  
                                        <input type="Number" id="txtreincanper" name="txtreincanper" class="form-control" autocomplete="off" disabled>
                                </div>
                                <div class="col mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label thtitulo">Cantidad devuelta</label>  
                                        <input type="Number" class="form-control" id="txtreingcant" name="txtreingcant" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label thtitulo">Serie Perdida</label>  
                                        <input type="text" id="txtreinserper" name="txtreinserper" class="form-control" autocomplete="off" disabled>
                                </div>
                                <div class="col mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label thtitulo">Serie reemplazo</label>  
                                        <input type="text" id="txtreinserie" name="txtreinserie" class="form-control mayu" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label thtitulo">Observacion</label>  
                                        <textarea class="form-control" id="txtreinobservaion" name="txtreinobservaion" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow: scroll;height: 200px;">  
                                <table id="tbreingreso" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th style="display: none;" scope="col">personal</th>
                                            <th style="display: none;" scope="col">Codigo</th>
                                            <th scope="col">Material</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col" style="display: none;">codsalida</th>
                                            <th scope="col" >Serie</th>
                                            <th scope="col" style='display: none;'>clase</th>
                                            <th class="thtitulo" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tdbreingreso">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btncerrreing" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btngreingreso" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
   
</body>
</html>