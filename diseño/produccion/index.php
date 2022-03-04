<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$fcha = date("Y-m-d");
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
    <script src="./js/jsproduccion.js"></script>
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
                  <input type="text" id="vroficina" style="display: none;" value="<?php echo ''//$ofi?>"/>
                  <input type="text" id="vrzona" style="display: none;" value="<?php echo ''//$zon?>"/>
                  <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215'//$cod?>"/>
                
              <div class="row mb-3">
                  <div class="col">
                      <center><label class="titulos">Registro de producción</label></center>
                  </div>
              </div>
              <div class="row">
                <div class="col">
                <input type="text" id="txtprod" name="txtprod" style="display: none;">
                <input type="text" id="txtform" name="txtform" style="display: none;">
                    <label>Nombre formula</label>
                    <input type="text" id="txtbformula" name="txtbformula" class="form-control mayu"  placeholder="Buscar formula" autocomplete="off">
                </div> 
                <div class="col-auto">
                  <label>Producción</label>
                  <select class="form-select" id="sltipoprod" name="sltipoprod">
                    <option value="P" selected>Propio</option>
                    <option value="E">Externo</option>
                  </select>
                </div> 
              </div>

                <div class="row"> 
                  <div class="col-md"> 
                    <label>Cliente</label> 
                    <div class="input-group">
                      <input type="text" id="txtcodclie" name="txtcodclie" style="display: none;">
                      <input type="text" id="txtbuscli" name="txtbuscli" class="form-control mayu">
                      <a class="btn btn-success" id="btnmdcliente" data-bs-toggle="modal" data-bs-target="#mdcliente">
                        <i class="icon-users" title="agregar nuevo cliente"></i>
                      </a>
                    </div>
                  </div>
                  <div class="col-md">
                    <label>Molde</label>
                    <div class="input-group">
                     <input type="text" id="txtcodmolde" name="txtcodmolde" style="display: none;">
                      <input type="text" id="txtbusmolde"  class="form-control">
                      <a class="btn btn-success" id="btnmdmolde" data-bs-toggle="modal" data-bs-target="#mdmolde">
                        <i class="icon-magnifying-glass" title="agregar nuevo molde"></i>
                      </a>
                    </div>  
                  </div>
                </div>
                <div class="row mb-3"> 
                  <div class="col-auto">
                    <label>Maquina en producción</label>
                    <input type="text" id="txtcavidades" name="txtcavidades" class="form-control" value="2">
                  </div>
                  <div class="col">
                    <label>Peso uni.</label>
                    <input type="text" id="txtpesouni" name="txtpesouni" class="form-control">
                  </div>
                  
                  <div class="col-auto">
                    <label>Ciclo</label>
                    <input type="text" id="txtciclo" name="txtciclo" class="form-control">
                  </div>
                  <div class="col">
                    <label>Producción</label>
                    <input type="text" id="txtprodcant" name="txtprodcant" class="form-control">
                  </div>
                  
                </div>  
                <div class="row mb-4">  
                   <div class="col-auto mb-3">
                      <select class="form-select"  id="slcestimolde" disabled name="slctipoalmacen" class="btn btn-primary mb-2 pull-left">
                        <option value="" selected>TIPO</option>
                        <option value="I">INYECCIÓN</option>
                        <option value="S">SOPLADO</option>
                      </select>
                  </div>
                  <div class="col-auto mb-3">
                   <button type="button" class="btn btn-primary" id="btnparametros"
                    data-bs-toggle="modal" data-bs-target="#mdparametros" style="float: right;">
                      Parametros
                    </button>
                  </div>
                  <div class="col-auto mb-3">
                    <button type="button" class="btn btn-primary" id="btntimelf" data-bs-toggle="modal" data-bs-target="#mdtimelf" >
                      Timer LF
                    </button>
                  </div>
                </div>
                <Center><label><strong>Fecha tentativa de producción</strong></label></Center>
                <div class="row mb-5">
                  <div class="col">
                    <label>Inicio</label>
                    <input type="date" class="form-control" name="txtinicio" id="txtinicio" value="<?php echo $fcha;?>"
                            min = "<?php echo date("Y-m-d");?>">
                  </div>
                  <div  class="col">
                    <label>Fin</label>
                    <input type="date" class="form-control" name="txtfin" id="txtfin" value="<?php echo $fcha;?>"
                            min = "<?php echo date("Y-m-d");?>">
                  </div>
                </div>

                <div class="table-responsive" style="overflow: scroll;height: 337px;">
                        <table class="table" id="tbmateriales">
                          <thead>
                              <tr>
                                <th class="thtitulo" style="display: none;">Codigo</th>
                                <th class="thtitulo">Insumo</th>
                               <!-- <th class="thtitulo">Cantidad</th>-->
                                <th class="thtitulo">Cantidad por usar</th>
                                <th class="thtitulo">Acciones</th>
                              </tr>
                          </thead>
                          <tbody id="tbdmateiales"> 
                          </tbody>  
                        </table>
                    </div>  
                    <table class="table" id="tbpasadas" style="display: none;">
                      <thead>
                        <tr>
                          <th>insumo</th>
                          <th>pasadas</th>
                          <th>nombre</th>
                          <th>cantidad</th>
                          <th>tipo</th>
                        </tr>
                      </thead>
                      <tbody id="tbdpasadas">
                      </tbody>  
                    </table> 
                    
          </form>
            <div class="row">
               <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left ">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                <div class="col g-4 divbotones">
                  <button  type="button" class="btn btn-primary mb-2" id="btngproduccion" style="float: right;">
                     <i class="icon-save" title="Guardar datos"></i>
                    Guardar
                   </button>
               </div> 
            </div> 
        </div>
          
    </section>

    <div class="modal fade" id="mdparametros" tabindex="-1"  data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Parametros de producción</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="frmparametros">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Temperatura</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Carga</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" style="display: none;">Soplado</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!--<div class="row">
                      <div class="col g-2">
                          <center><label class="titulos">Temperatura</label></center>
                      </div>
                    </div>-->
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="thtitulo">#1</th>
                          <th class="thtitulo">#2</th>
                          <th class="thtitulo">#3</th>
                          <th class="thtitulo">#4</th>
                          <th class="thtitulo">#5</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="number" id="txttemp1" name="txttemp1" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp2" name="txttemp2" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp3" name="txttemp3" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp4" name="txttemp4" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp5" name="txttemp5" class="form-control">
                          </td>
                        </tr>
                        <tr id="tempSo">
                          <td>
                            <input type="number" id="txttemp6" name="txttemp6" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp7" name="txttemp7" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp8" name="txttemp8" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="txttemp9" name="txttemp9" class="form-control">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  <div class="row">
                      <div class="col g-1">
                          <center><label id="lblbotador" class="titulos">Botadores Expul.</label></center>
                      </div>
                  </div>
                    <table class="table" id="tbbotadores">
                      <thead>
                        <tr>
                          <th class="thtitulo">#</th>
                          <th class="thtitulo">#1</th>
                          <th class="thtitulo">#2</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                          <label>Presión</label>
                          </td>
                          <td>
                            <input type="number" id="presexplu1" name="presexplu1" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="presexplu2" name="presexplu2" class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>Velocidad</label>
                          </td>
                          <td>
                            <input type="number"  id="velexplu1" name="velexplu1"  class="form-control">
                          </td>
                          <td>
                            <input type="number"  id="velexplu2" name="velexplu2"  class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>Pisición</label>
                          </td>
                          <td>
                            <input type="number" id="pisiexplu1" name="pisiexplu1" class="form-control">
                          </td>
                          <td>
                            <input type="number" id="pisiexplu2" name="pisiexplu2" class="form-control">
                          </td>
                        </tr>
                      </tbody>
                    </table>

                  <!--<div class="row">
                      <div class="col g-1">
                          <center><label class="titulos">Botadores Contrac.</label></center>
                      </div>
                  </div>

                
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="thtitulo">#2</th>
                            <th class="thtitulo">#1</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <input type="number" id="contrac1" name="contrac1" class="form-control">
                            </td>
                            <td>
                              <input type="number"  id="contrac2" name="contrac2" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" id="contrac3" name="contrac3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="contrac4" name="contrac4" class="form-control">
                            </td>
                          </tr>
                        </tbody>
                    </table>-->


                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <!--<div class="row">
                      <div class="col g-1">
                          <center><label class="titulos">Carga</label></center>
                      </div>
                    </div>-->
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="thtitulo">P.ATRA</th>
                            <th class="thtitulo">#1</th>
                            <th class="thtitulo">#2</th>
                            <th class="thtitulo">#3</th>
                            <th class="thtitulo">Succiona</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                            <label class="tdtexto">Presión</label>
                            </td>
                            <td>
                              <input type="number" id="cargapres1" name="cargapres1" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargapres2" name="cargapres2" class="form-control">
                            </td>
                            <td>
                              <input type="number"  id="cargapres3" name="cargapres3"class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargapresucc" name="cargapresucc" class="form-control">
                            </td>
                          </tr> 
                          <tr>
                            <td>
                              <label class="tdtexto">Velocidad</label>
                            </td>
                            <td>
                              <input type="number" id="cargavel1" name="cargavel1" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargavel2" name="cargavel2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargavel3" name="cargavel3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargavelsucc" name="cargavelsucc" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Posición</label>
                            </td>
                            <td>
                              <input type="number" id="cargapisi1" name="cargapisi1" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargapisi2" name="cargapisi2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargapisi3" name="cargapisi3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="cargapisisucci" name="cargapisisucci" class="form-control">
                            </td>
                          </tr>
                        </tbody>
                      </table>

                  <div class="row">
                      <div class="col g-1">
                          <center><label class="titulos">Inyeccion</label></center>
                      </div>
                  </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="thtitulo"></th>
                            <th class="thtitulo">#4</th>
                            <th class="thtitulo">#3</th>
                            <th class="thtitulo">#2</th>
                            <th class="thtitulo">#1</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <label>Presión</label>
                            </td>
                            <td>
                              <input type="number" id="inyecpres4" name="inyecpres4" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecpres3" name="inyecpres3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecpres2" name="inyecpres2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecpres1" name="inyecpres1"  class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Velocidad</label>
                            </td>
                            <td>
                              <input type="number" id="inyecvelo4" name="inyecvelo4" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecvelo3" name="inyecvelo3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecvelo2" name="inyecvelo2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecvelo1" name="inyecvelo1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Posicion</label>
                            </td>
                            <td>
                              <input type="number" id="inyecposi4" name="inyecposi4" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecposi3" name="inyecposi3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecposi2" name="inyecposi2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="inyecposi1" name="inyecposi1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <th scope="row"></th>
                            <th scope="row"></th>
                            <th scope="row"></th>
                            <td colspan="1" class="thtitulo">Tiempo</td>
                            <td><input type="number" id="inyectiemp" name="inyectiemp" class="form-control"></td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                <table class="table">
                        <thead>
                          <tr>
                            <th class="thtitulo">Presion</th>
                            <th class="thtitulo">#3</th>
                            <th class="thtitulo">#2</th>
                            <th class="thtitulo">#1</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <label>Velocidad</label>
                            </td>
                            <td>
                              <input type="number" id="velocidad3" name="velocidad3" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="velocidad2" name="velocidad2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="velocidad1" name="velocidad1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Posicion</label>
                            </td>
                            <td>
                              <input type="number" id="posicion3" name="posicion3" class="form-control">
                            </td>
                            <td>
                              <input type="number"  id="posicion2" name="posicion2" class="form-control">
                            </td>
                            <td>
                              <input type="number" id="posicion1" name="posicion1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <th scope="row"></th>
                            <th scope="row"></th>
                            <td colspan="1" class="thtitulo">Tiempo</td>
                            <td><input type="number" id="tiempo" name="tiempo" class="form-control"></td>
                          </tr>
                        </tbody>
                    </table>
                    
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>-->
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirmar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mditemformula" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ingresar Insumos</h5>
            <button type="button" class="btn-close" id="btnclose" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
        <div class="row">
            <div class="col">
              <label>Tipo</label>
              <select class="form-select" id="slcmdtipo">
                <option value="P" selected>Propio</option>
                <option value="E">Externo</option>
              </select>
            </div>
            <div class="col-auto">
              <label >Cantidad</label>
              <input type="number" id="mdcant" name="mdcant" class="form-control" disabled>
            </div> 
        </div>
          <div class="row">
            <div class="col">
              <div class="table-responsive" style="overflow: scroll;height: 180px;"> 
                <table class="table" id="tbmdinsumos">
                      <thead>
                        <tr>
                          <th style="display: none;">codigo </th>
                          <th class="thtitulo">Insumo</th>
                          <th class="thtitulo">Stock</th>
                        </tr>
                      </thead>
                      <tbody id="tbdmdinsumos">
                      </tbody>  
                </table> 
              </div>
            </div>
          </div>
          <!--<div class="row">
            <div class="col">
              <label >Insumo</label>
              <input type="text" id="txtnominsumo" class="form-control" disabled>
            </div>
            <div class="col">
              <label >Cantidad por usar</label>
              <div class="input-group">
                <input type="number" id="mdcantxusar" name="mdcantxusar" class="form-control">
                <a class="btn btn-success" id="btnmdcantxusar">
                  <i class="icon-plus" title="agregar nuevo cliente"></i>
                </a>
              </div>
            </div>
          </div>-->

          <div class="row">
            <div class="col">
              <div class="table-responsive" style="overflow: scroll;height: 180px;"> 
                <table class="table" id="tbmdinsumosa">
                      <thead>
                        <tr>
                          <th style="display: none;">codigo</th>
                          <th class="thtitulo">Insumo</th>
                          <th class="thtitulo">cantidad</th>
                          <th style="display: none;">tipo</th>
                          <!--<th class="thtitulo">acciones</th>-->
                        </tr>
                      </thead>
                      <tbody id="tbdmdinsumosa">
                      </tbody>  
                </table> 
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>         
          <button type="button" id="btnactuitems" class="btn btn-primary">Confirmar</button>
        </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mdcliente" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmmdcliente">
                    <div class="row">    
                      <div class="row mb-2">
                        <div class="col">
                          <label for="formpromocion"  class="form-label">Nombre Completo</label>
                          <input type="text" class="form-control mayu" placeholder="Nombre o razon social" id="txtnombcliente" name="txtnombcliente"  autocomplete="off">       
                        </div>
                        </div>
                          <div class="row">
                            <div class="col">
                              <label  class="form-label">Dirección</label> 
                              <input type="text" class="form-control mayu" placeholder="Direccion"  id="txtdireccliente" name="txtdireccliente" autocomplete="off">
                            </div>
                            <div class="col">
                              <label  class="form-label">Correo</label> 
                              <input type="text" class="form-control mayu" placeholder="Correo" name="txtcorreocliente" id="txtcorreocliente" autocomplete="off">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <label  class="form-label">Identificación</label>
                              <input type="Number" class="form-control" placeholder="DNI o RUC" name="txtidenticliente" id="txtidenticliente" autocomplete="off">    
                            </div>
                            <div class="col">
                              <label class="form-label">Telefono</label>
                              <input type="Number" class="form-control" placeholder="Telefon o celular" name="txttelefon" id="txttecliente" autocomplete="off">    
                            </div>
                          </div> 
                      </div> 
                    </div>
                </form>    
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="button" id="btnmdgcliente" class="btn btn-primary">Guardar</button>
                </div>
            </div>
          </div>
      </div>


    <div class="modal fade" id="mdmolde" tabindex="-1"  data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Registrar molde externo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="frmmdmolde">
              <div class="row mb-2">
                <div class="col-md">
                  <label for="formpromocion"  class="form-label">Nombre</label>
                  <input type="text" class="form-control mayu" name="txtnommolde" id="txtnommolde" autocomplete="off">
                </div>
                <div class="col-md">
                  <label class="form-label">Medidas molde</label>
                  <input type="text" class="form-control" name="txtmedmolde" id="txtmedmolde" autocomplete="off">    
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnmdgmolde">Guardar</button>
          </div>
        </div>
      </div>
    </div>






    <div class="modal fade" id="mdtimelf" tabindex="-1"  data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Parametros de producción</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="frmtimelf">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#uno" type="button" role="tab" aria-controls="home" aria-selected="true">1</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#dos" type="button" role="tab" aria-controls="profile" aria-selected="false">2</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#tres" type="button" role="tab" aria-controls="contact" aria-selected="false">3</button>
                </li>
              </ul>
              <div class="tab-content" >
                <div class="tab-pane fade show active" id="uno" role="tabpanel" aria-labelledby="home-tab">
                  <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <label>Carriageup delaytime</label>
                            </td>
                            <td>
                              <input type="number" id="txtcarriage" name="txtcarriage" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Closedould delaytime</label>
                            </td>
                            <td>
                              <input type="number" id="txtclosedd" name="txtclosedd" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Cuter delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtcuter" name="txtcuter" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Head up delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txthead" name="txthead" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>BlowpingDown delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtblow" name="txtblow" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Total blow delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txttotalblo" name="txttotalblo" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Blow time</label>
                            </td>
                            <td>
                              <input type="number" id="txtblow1" name="txtblow1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Lf to RG time</label>
                            </td>
                            <td>
                              <input type="number" id="txtlf" name="txtlf" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Deflation delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtdefla" name="txtdefla" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Undercuting delay </label>
                            </td>
                            <td>
                              <input type="number" id="txtunde" name="txtunde" class="form-control">
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="dos" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <label>Cooling blow delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtcoolin" name="txtcoolin" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Lock mould delay</label>
                            </td>
                            <td>
                              <input type="number" id="txtlock" name="txtlock" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>bottle cooling ET</label>
                            </td>
                            <td>
                              <input type="number" id="txtbottle" name="txtbottle" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>CarriageDown delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtcarria" name="txtcarria" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Open mould delay time</label>
                            </td>
                            <td>
                              <input type="number" id="txtopenmoul" name="txtopenmoul" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>cuter time</label>
                            </td>
                            <td>
                              <input type="number" id="txtcuter1" name="txtcuter1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Head up time</label>
                            </td>
                            <td>
                              <input type="number" id="txthead1" name="txthead1" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Blowpin dow time</label>
                            </td>
                            <td>
                              <input type="number" id="txtblowpin" name="txtblowpin" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Total blow time</label>
                            </td>
                            <td>
                              <input type="number" id="txttotalbl" name="txttotalbl" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label>Deflation Time</label>
                            </td>
                            <td>
                              <input type="number" id="txtdeflati" name="txtdeflati" class="form-control">
                            </td>
                          </tr>
                        </tbody>
                    </table>   
                </div>
                <div class="tab-pane fade" id="tres" role="tabpanel" aria-labelledby="contact-tab">
                  <table class="table">
                          <tbody>
                            <tr>
                              <td>
                                <label>Blowpin ShortUp Time</label>
                              </td>
                              <td>
                                <input type="number" id="txtblopinS" name="txtblopinS" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>DeflationTime</label>
                              </td>
                              <td>
                                <input type="number" id="txtdeflation" name="txtdeflation" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>-</label>
                              </td>
                              <td>
                                <input type="number" id="txtcamvaci1" name="txtcamvaci1" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>Cooling blow Time</label>
                              </td>
                              <td>
                                <input type="number" id="txtcooling" name="txtcooling" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>-</label>
                              </td>
                              <td>
                                <input type="number" id="txtcamvaci2" name="txtcamvaci2" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>-</label>
                              </td>
                              <td>
                                <input type="number" id="txtcamvaci3" name="txtcamvaci3" class="form-control">
                              </td>
                            </tr>
                          </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>-->
            <button type="button" class="btn btn-primary"  data-bs-dismiss="modal">Confirmar</button>
          </div>
        </div>
      </div>
    </div>
    

    <div class="modal fade" id="mdconfirmacion" tabindex="-1"  data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Codigo de confirmación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label>Se modifico los parametros de producción ingrese codigo de confirmación o para cancelar vuelva a seleccionar la formula</label>
              
              <div class="row mb-2">
                <div class="col-md">
                <br>
                  <label for="formpromocion"  class="form-label">codigo de confirmación</label>
                  <input type="text" class="form-control mayu" name="txtconfirmacod" id="txtconfirmacod" autocomplete="off">
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnconfirmacion">Guardar</button>
          </div>
        </div>
      </div>
    </div>
</body>
  <script src="../js/abootstrap.min.js"></script>
</html>

