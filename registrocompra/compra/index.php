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
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jscompra.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
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
            <form id="frmcomprobante">
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
                            <input type="date" id="txtcomfecemision" name="txtcomfecemision" class="form-control text-center">
                    </div> 
                    <div class="col g-4 float-right">
                        <div>Hora Emision</div>
                        <input type="time" id="txtcomhoremision" name="txtcomhoremision" class="form-control text-center">
                    </div>
                    <div class="col g-4">
                        <div>F. Entrega</div>
                        <div class="input-group g-4">
                            <input type="date" id="txtcomfecentrega" name="txtcomfecentrega" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>">
                        </div>    
                    </div>  
                </div>    
                <div class="row" >
                     <div class="col g-4">
                        <div>Personal</div>
                        <div class="input-group g-4">
                            <input type="text" class="form-control" id="txtcomcodpers" name="txtcomcodpers" style="display: none;">
                            <input type="text" class="form-control" id="txtcompersonal" name="txtcompersonal" placeholder="BUSCAR PERSONAL">
                        </div>    
                    </div>
                </div>

               
                <div class="row" >
                    
                    <div class="col g-4">
                        <div>comprobante</div>
                        <select id="slctipocompr" name="slctipocompr" class="form-select">
                            <option value="" selected>Tipo  Comprobante</option>
                            <option value="1">Factura</option>
                            <option value="2">Boleta</option>
                            <option value="3">Nota de debito</option>
                            <option value="4">Nota de credito</option>
                            <option value="5">Ticket</option>
                        </select>
                    </div> 
                    <div class="col g-4">
                        <div>F. pago</div>
                        <select  id="slcformpago" name="slcformpago" class="form-select">
                            <option value="" selected>Forma Pago</option>
                            <option value="1">Depósitos en cuenta</option>
                            <option value="2">Transferencia de fondos</option>
                            <option value="3">Tarjetas de débito</option>
                            <option value="3">Tarjetas de crédito</option>
                            <option value="3">Cheques</option>
                        </select>
                    </div>
                </div>    
                <div class="row mb-3" >
                    <div class="col g-4">
                        <div>Moneda</div>
                        <select id="slcmoneda" name="slcmoneda" class="form-select">
                            <option value="" selected>Moneda</option>
                            <option value="1">Soles</option>
                            <option value="2">Dolares</option>
                        </select>
                    </div> 
                    <div class="col g-4">
                        <div>Tipo cambio</div>
                        <input type="number" id="txttipocambio" name="txttipocambio" class="form-control">
                    </div> 
                </div>
                    <div class=" form-check-inline">
                        <label class="form-check-label" for="inlineRadio3">Contiene IGV</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input" type="radio" name="rdnigv" id="rdnsi">
                        <label class="form-check-label" for="inlineRadio1">SI</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input" type="radio" name="rdnigv" id="rdnno">
                        <label class="form-check-label" for="inlineRadio2">NO</label>
                    </div>
                <div class="row">
                    <div class="col g-4">
                        <label class="form-label">Observación</label>
                        <textarea class="form-control" id="txtcompobservacion" name="txtcompobservacion" rows="3"></textarea>
                    </div>    
                </div>
                <div class="row" >
                     <div class="col g-4">
                        <div class="input-group mb-3">
                            <input type="text" id="txtcompclase" name="txtcompclase" style="display: none;">
                            <input type="text" id="txtcompcodPro" name="txtcompcodPro" style="display: none;">
                            <input type="text" class="form-control" id="txtcompprod" name="txtcompprod" placeholder="BUSCAR PRODUCTO">
                            <a class="btn btn-success" id="addproducto" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                                <i class="icon-shopping-basket" title="agregar derecha"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="row" >
                    <div class="col g-4">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="txtcomcantidad" name="txtcomcantidad" placeholder="CANTIDAD"></input>
                    </div>  
                     <div class="col g-4">
                         <label class="form-label">Precio</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtcomprecio" name="txtcomprecio" placeholder="PRECIO">
                        </div>
                    </div>
                    <div class="col g-4">
                        <label class="form-label">Nro serie</label>
                        <input type="text" style="text-transform: uppercase;" id="txtcomserie" name="txtcomserie" class="form-control" placeholder="NRO SERIE"></input>
                    </div>  
                </div>
                <div class="row mb-3" style="float: right;">
                    <div class="col-auto g-4">
                        <button  type="button" id="btnatproduc"  class="btn btn-primary mb-2 pull-left">
                                <i class="icon-plus" title="agregar productos"></i>
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

                <div class="row">
                    <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                    <div class="col g-4 divbotones">
                        <button  type="button" class="btn btn-primary mb-2" id="btng_compro" style="float: right;">
                        <i class="icon-save" title="Guardar datos"></i>
                        Guardar
                        </button>
                    </div> 
                </div> 
            </form>  
            
<div class="modal fade" id="mdmaterial" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h5 class="modal-title">Registrar nuevo material</h5></center>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmguardaprod" name="frmguardaprod">
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Codigo Producto</label>
                            <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtcodigopro" id="mtxtcodigopro" maxlength="6" autocomplete="off">
                        </div> 
                        <div class="col">
                            <label for="formcantidad"  class="form-label">Unidad Medida</label>
                            <input type="text" style="text-transform:uppercase"  class="form-control"  name="mtxtunimedida" id="mtxtunimedida" maxlength="10" autocomplete="off">
                        </div>
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Nombre del Producto</label>
                            <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtnombreproducto" id="mtxtnombreproducto">
                        </div>  
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label  for="formentrega" class="form-label">Categoria</label>
                            <select class="form-select" id="slcategoria" aria-label="Default select example">
                                <option value="" selected>SELECCIONE CATEGORIA</option>
                            </select>
                        </div>
                    </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Abreviatura</label>
                                <input type="text" style="text-transform:uppercase" class="form-control" name="mtxtabreviatura" id="mtxtabreviatura" maxlength="4" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Stock minimo</label>
                                <input type="number" style="text-transform:uppercase" class="form-control" name="mtxtstockmin" id="mtxtstockmin" autocomplete="off">
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
                            <option value="" selected>SELECCIONE CATEGORIA</option>
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
        </div>     
    </section>
</body>
</html>
