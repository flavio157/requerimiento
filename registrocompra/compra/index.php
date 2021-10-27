<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
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
    
    <script src="./js/jscompra.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
</style>

<body style="background: #f5f5f5;">
   <header>
        <title>Registro de Comprobante</title>
   </header>
   <section>  
        <div class="main"> 
            <form id="frmfabricacion">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="row">
                    <div class="col g-4">
                    <center><label class="titulos">Registro Comprobante</label></center>
                    </div>
                </div>
                  
                <div class="row" style="float: rigt;"> 
                    <div class="col g-4 float-right">
                        <div>F. Emision</div>
                            <input type="date" class="form-control text-center">
                    </div> 
                    <div class="col g-4 float-right">
                        <div>Hora Emision</div>
                        <input type="time" class="form-control text-center">
                    </div>
                    <div class="col g-4">
                        <div>F. Entrega</div>
                        <div class="input-group g-4">
                            <input type="date" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>">
                        </div>    
                    </div>  
                </div>    

               
              <!--  <div class="row" style="float: right;">
                    <div class="col g-4 mb-3">
                        <div>Orden de compra</div>
                        <div class="input-group g-4">
                            <input type="text" class="form-control">
                            <a class="btn btn-success">
                                <i class="icon-magnifying-glass" title="agregar derecha"></i>
                            </a>
                        </div>
                    </div>
                </div>-->
               
                <!--<div class="g-4">
                    <table id="tbmaterialmolde" class="table table-sm">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col">ORDEN COMPRA</th>
                                <th class="thtitulo" scope="col">FECHA</th>
                            </tr>
                        </thead>
                        <tbody id="tbdmaterialmolde">
                        </tbody>
                    </table>
                </div>-->
                <div class="row" >
                     <div class="col g-4">
                        <div>Personal</div>
                        <div class="input-group g-4">
                            <input type="text" class="form-control" id="txtcompcodpers" style="display: none;">
                            <input type="text" class="form-control" id="txtcomppersonal" placeholder="BUSCAR PERSONAL">
                        </div>    
                    </div>
                </div>

               
                <div class="row" >
                    
                    <div class="col g-4">
                        <div>comprobante</div>
                        <select class="form-select">
                            <option selected>Tipo  Comprobante</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div> 
                    <div class="col g-4">
                        <div>F. pago</div>
                        <select class="form-select">
                            <option selected>Forma Pago</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>    
                <div class="row" >
                    <div class="col g-4">
                        <div>Moneda</div>
                        <select class="form-select">
                            <option selected>Moneda</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div> 
                    <div class="col g-4">
                        <div>Tipo cambio</div>
                        <input type="number" class="form-control">
                    </div> 
                </div>
                <div class="row">
                    <div class="col g-4">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" id="texobservacion" rows="3"></textarea>
                    </div>    
                </div>
                <div class="row" >
                     <div class="col g-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtcompcodPro" style="display: none;">
                            <input type="text" class="form-control" id="txtcompprod" placeholder="BUSCAR PRODUCTO">
                            <a class="btn btn-success" id="addproducto" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                                <i class="icon-shopping-basket" title="agregar derecha"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="row" >
                    <div class="col g-4">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" placeholder="CANTIDAD"></input>
                    </div>  
                     <div class="col g-4">
                         <label class="form-label">Precio</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtpersonalmolde" placeholder="PRECIO">
                        </div>
                    </div>
                    <div class="col g-4">
                        <label class="form-label">Nro serie</label>
                        <input type="text" style="text-transform: uppercase;"  class="form-control" placeholder="NRO SERIE"></input>
                    </div>  
                </div>
                <div class="row mb-3" style="float: right;">
                    <div class="col-auto g-4">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left">
                                <i class="icon-plus" title="Limpiar Formulario"></i>
                        </button>
                    </div>
                </div>
                <div class="g-4">
                    <table id="tbmaterialmolde" class="table table-sm">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col" style="display: none;">Codigo</th>
                                <th class="thtitulo" scope="col">Nombre</th>
                                <th class="thtitulo" scope="col">N. serie</th>
                                <th class="thtitulo" scope="col">Cantidad</th>
                                <th class="thtitulo" scope="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="tbdmaterialmolde">
                        </tbody>
                    </table>
                </div>




                <div class="modal fade" id="mdmaterial" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title">Registrar material</h5></center>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmagregarProducto">
            <div class="row g-2">
              <div class="col">
                  <label for="formfpago" class="form-label">Nombre del Producto</label>
                  <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtnombreproducto" id="mtxtnombreproducto">
              </div>   
              <div class="col">
                      <label for="formfpago" class="form-label">Codigo Producto</label>
                      <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtcodigopro" id="mtxtcodigopro" autocomplete="off">
              </div> 
            </div>                    
            <div class="row g-2">
                <div class="col">
                  <label  for="formentrega" class="form-label">Categoria</label>
                  <select class="form-select" id="slcategoria" aria-label="Default select example">
                    <option selected>SELECCIONE CATEGORIA</option>
                  </select>
                </div>
                </div>
                  <div class="row g-2">
                    <div class="col">
                      <label for="formcantidad"  class="form-label">Unidad Medida</label>
                      <input type="text" style="text-transform:uppercase"  class="form-control"  name="mtxtunimedida" id="mtxtunimedida">
                    </div>
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Abreviatura</label>
                        <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtabreviatura" autocomplete="off" id="mtxtabreviatura">
                    </div>
                </div>
                <div class="row g-2">
                  <div class="col">
                    <label for="formpromocion" class="form-label">Peso neto</label>
                    <input type="number" class="form-control" name="mtxtneto" autocomplete="off" id="mtxtneto">
                  </div>
                  <div class="col">
                    <label for="formfpago" class="form-label">Clase</label>
                    <select class="form-select" id="slclase" aria-label="Default select example">
                      <option selected>SELECCIONE CATEGORIA</option>
                    </select>
                  </div>
                </div>
          </form>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger"  id="btncerrarprod" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" id="btnguardarprod" class="btn btn-primary">Guardar</button>
         </div>
      </div>
    </div>
  </div>
</div>

 



               <!-- <div class="row">
                    <div class="col g-4" style="margin-top: 0px">
                        <label class="thtitulo">Datos de Molde</label>
                    </div>    
                </div>  

              
                    <div class="row">
                         <div class="col" style="padding-right: 6px;">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="txtcodmolde" id="txtcodmolde" style="display: none;">
                                <input type="text" class="form-control" name="txtdesmolde" id="txtdesmolde" placeholder="Buscar Molde">
                                <a class="btn btn-success">
                                    <i class="icon-shopping-basket" title="agregar derecha"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                
              
                <div  class="row">
                    <div class="col">
                  
                        <div class="table-responsive-sm" style="overflow: scroll;height: 177px;">  
                            <table id="tbmaterialmolde" class="table table-sm">
                                <thead>
                                    <tr>
                                       <th class="thtitulo" scope="col" style="display: none;">codmaterial</th>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Cantidad</th>
                                        <th class="thtitulo" scope="col">Unidad Medida</th>
                                        <th class="thtitulo" scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdmaterialmolde">
                                </tbody>
                            </table>
                        </div>  
                    </div>     
                </div>   

                <div class="row">
                    <div class="col g-4" style="margin-top: 12px;">
                        <label class="thtitulo">Personal Involucrado</label>
                    </div>    
                </div>  
                <div class="row">
                    <div class="col g-4" style="margin-top: 10px;">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Inicio</span>
                            <input type="date" id="txtfecinipers" class="form-control">
                        </div> 
                    </div>    
                    <div class="col g-4" style="margin-top: 10px;">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fin &nbsp&nbsp&nbsp</span>
                            <input type="date" id="txtfecfinpers" class="form-control">
                        </div>
                    </div>    
                </div> 

                

                <div  class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Horas</span>
                            <input type="number" id="txthortrab" class="form-control" placeholder="a trabajar">
                        </div>
                    </div>
                    <div class="col" style="padding-left: 0px;">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Costo</span>
                            <input type="number" id="txtcosthora" class="form-control"  placeholder="x hora"> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col g-4" style="padding-right: 6px;margin-top: 0px;">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="txtcodpermolde" id="txtcodpermolde" style="display: none;">
                            <input type="text" class="form-control" id="txtpersonalmolde" placeholder="Buscar Personal">
                            <a class="btn btn-success" id="addpersonal">
                                <i class="icon-add-user" title="agregar derecha"></i>
                            </a>
                        </div>
                    </div>
                </div> 
                <div  class="row">
                    <div class="col">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" id="texobservacion" rows="3"></textarea>
                    </div>
                </div>

                <div  class="row">
                    <div class="col">
                        <div class="table-responsive" style="overflow: scroll;height: 130px;">  
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col" style="display: none;">codigo</th>
                                        <th class="thtitulo" scope="col">Personal</th>
                                        <th class="thtitulo" scope="col">F. Inicio</th>
                                        <th class="thtitulo" scope="col">F. Fin</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                        <th class="thtitulo" scope="col" style="display: none;">descripcion</th>
                                        <th class="thtitulo" scope="col" style="display: none;">hora x Trabajas</th>
                                        <th class="thtitulo" scope="col" style="display: none;">C x H</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdpersonalmolde">
                                </tbody>
                            </table>
                        </div>     
                    </div> 
                </div>-->
                <div class="row">
                    <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                    <div class="col g-4 divbotones">
                        <button  type="button" class="btn btn-primary mb-2" id="btng_molde" style="float: right;">
                        <i class="icon-save" title="Guardar datos"></i>
                        Guardar
                        </button>
                    </div> 
                </div> 
            </form>  
        </div>     
    </section>
</body>
</html>
