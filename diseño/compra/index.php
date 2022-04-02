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
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
     <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jscompra.js?v=1.1.1"></script>
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
                <input type="text" id="vroficina" style="display: none;" value="<?php echo ''//$ofi ?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  ''//$zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215'//$cod;?>"/>
                <div class="row">
                    <div class="col g-4">
                    <center><label class="titulos">Registro Comprobante</label></center>
                    </div>
                </div>
                  
                <div class="row" style="float: rigt;"> 
                    <div class="col g-4 float-right">
                        <label>F. Emision</label>
                            <input type="date" id="txtcomfecemision" name="txtcomfecemision" class="form-control text-center">
                    </div> 
                    <div class="col g-4 float-right">
                        <label>Hora Emision</label>
                        <input type="time" id="txtcomhoremision" name="txtcomhoremision" class="form-control text-center">
                    </div>
                    <div class="col g-4">
                        <label>F. Entrega</label>
                        <div class="input-group g-4">
                            <input type="date" id="txtcomfecentrega" name="txtcomfecentrega" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>">
                        </div>    
                    </div>  
                </div>    
                <div class="row static">
                    <div class="col g-4">
                        <label>Personal</label>
                        <div class="input-group g-4">
                            <input type="text" class="form-control" id="txtcomcodpers" name="txtcomcodpers" style="display: none;">
                            <input type="text" class="form-control mayu" id="txtcompersonal" name="txtcompersonal" placeholder="BUSCAR PERSONAL" style="z-index:1">
                            <a class="btn btn-success static" id="addpersonal" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                                <i class="icon-add-user" title="Nuevo personal"></i>
                            </a>
                        </div>    
                    </div>
                    <div class="col g-4">
                        <label>Proveedor</label>
                        <div class="input-group g-4">
                            <input type="text" class="form-control" id="txtcodproveedor" name="txtcodproveedor" style="display: none;">
                            <input type="text" class="form-control mayu" id="txtcomprovee" name="txtcomprovee" placeholder="BUSCAR PROVEEDOR" style="z-index:1">
                            <a class="btn btn-success static" id="addpersonal" data-bs-toggle="modal" data-bs-target="#mdproveedor">
                                <i class="icon-add-user" title="Nuevo personal"></i>
                            </a>
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col g-4">
                        <label>Tipo</label>
                        <select id="slctipocompr" name="slctipocompr" class="form-select">
                            <option value="" selected>TIPO COMPROBANTE</option>
                            <option value="F">FACTURA</option>
                            <option value="B">BOLETA</option>
                            <option value="R">RECIBO</option>
                            <option value="T">TICKET</option>
                        </select>
                    </div> 
                    <div class="col g-4">
                        <label>Serie</label>
                        <input class="form-control mayu" type="text" name="txtnrocompro" id="txtnrocompro">
                    </div>
                    <div class="col g-4">
                        <label>Correlativo</label>
                        <input class="form-control" type="Number" name="txtcorrecomp" id="txtcorrecomp">
                    </div>
                </div>   
                <div class="row">
                    <div class="col g-4">
                        <label>F. pago</label>
                        <select  id="slcformpago" name="slcformpago" class="form-select">
                            <option value="" selected>FORMA DE PAGO</option>
                            <option value="E">EFECTIVO</option>
                            <option value="B">TRASNFERENCIA</option>
                            <option value="C">CHEQUE</option>
                        </select>
                    </div>
                    <div class="col g-4">
                        <label>Moneda</label>
                        <select id="slcmoneda" name="slcmoneda" class="form-select">
                            <option value="" selected>MONEDA</option>
                            <option value="S">SOLES</option>
                            <option value="D">DOLARES</option>
                        </select>
                    </div> 
                </div>  
                <div class="row">
                    <div class="col g-4">
                        <label>Tipo cambio</label>
                        <input type="number" id="txttipocambio" name="txttipocambio" class="form-control" placeholder="0.000">
                    </div> 
                    <div class="col g-4">
                        <label class="form-check-label mb-2" for="inlineRadio3">Incluye IGV</label>
                        <div class="col g-4">
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input" type="radio" name="rdnigv" id="rdnsi">
                            <label class="form-check-label" for="inlineRadio1">SI</label>
                        </div>
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input" type="radio" name="rdnigv" id="rdnno">
                            <label class="form-check-label" for="inlineRadio2">NO</label>
                        </div>
                        </div>
                    </div>
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
                            <input type="text" class="form-control mayu" id="txtcompprod" name="txtcompprod" placeholder="BUSCAR PRODUCTO">
                            <a class="btn btn-success" id="addproducto" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                                <i class="icon-shopping-basket" title="Nuevo Material"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="row" >
                    <div class="col g-4" style="margin-top: 3px;">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="txtcomcantidad" name="txtcomcantidad" placeholder="CANTIDAD"></input>
                    </div>  
                     <div class="col g-4" style="margin-top: 3px;">
                         <label class="form-label">Precio</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtcomprecio" name="txtcomprecio" placeholder="PRECIO">
                        </div>
                    </div>
                    <div class="col g-4" style="margin-top: 3px;">
                        <label class="form-label">Nro serie</label>
                        <input type="text" style="text-transform: uppercase;" id="txtcomserie" name="txtcomserie" class="form-control" placeholder="NRO SERIE"></input>
                    </div>  
                </div>

                <div class="row mb-3">
                    <div class="col g-4 divbotones" style="margin-top: 3px;">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Total</span>
                            <input type="text" class="form-control" placeholder="0.00" id="txttotalcomp" disabled>
                        </div>
                    </div>
                    <div class="col g-4 divbotones" style="margin-top: 3px;">
                        <div class="col-auto g-4">
                            <button  type="button" id="btnatproduc"  class="btn btn-primary" style="float: right;">
                                    <i class="icon-plus" title="Agregar Material"></i>
                            </button>
                        </div>
                    </div>
                </div> 
          
                <div class="g-4" class="table-responsive">
                    <table id="tbmaterialcompro" class="table table-sm">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col" style="display: none;">Codigo</th>
                                <th class="thtitulo" scope="col">Nombre</th>
                                <th class="thtitulo" scope="col">N. serie</th>
                                <th class="thtitulo" scope="col">Cantidad</th>
                                <th class="thtitulo" scope="col">Precio</th>
                                <th class="thtitulo" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbdmaterialcompro">
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
                            <input type="text"  class="form-control mayu" name="mtxtcodigopro" id="mtxtcodigopro" maxlength="6" autocomplete="off">
                        </div> 
                        <div class="col">
                            <label for="formcantidad"  class="form-label">Unidad Medida</label>
                            <input type="text"  class="form-control mayu"  name="mtxtunimedida" id="mtxtunimedida" maxlength="10" autocomplete="off">
                        </div>
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control mayu" name="mtxtnombreproducto" id="mtxtnombreproducto" autocomplete="off">
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
                                <input type="text"  class="form-control mayu" name="mtxtabreviatura" id="mtxtabreviatura" maxlength="4" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Stock minimo</label>
                                <input type="number" class="form-control mayu" name="mtxtstockmin" id="mtxtstockmin" autocomplete="off">
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
                            <option value="">SELECCIONE CLASE</option>
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


<div class="modal fade" id="mdpersonal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h5 class="modal-title">Registro de nuevo personal</h5></center>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmgudarpers" name="frmgudarpers">
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Fecha Ingreso</label>
                            <input type="date"  class="form-control" name="mtxtfecingreso" id="mtxtfecingreso">
                        </div>
                        <div class="col">
                            <label for="formfpago" class="form-label">DNI</label>
                            <input type="number"  class="form-control mayu" name="mtxtdniper" id="mtxtdniper" maxlength="8" autocomplete="off">
                        </div> 
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control mayu" name="mtxtnomperson" id="mtxtnomperson" autocomplete="off">
                        </div>  
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formpromocion"  class="form-label">Direccion</label>
                            <input type="text" class="form-control mayu" name="mtxtdirper" id="mtxtdirper" autocomplete="off">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col">
                            <label  for="formentrega" class="form-label">Cargo</label>
                            <select class="form-select" id="slcargpers" name="slcargpers" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE CARGO</option>
                            </select>
                        </div>
                        <div class="col">
                            <label  for="formentrega" class="form-label">Area</label>
                            <select class="form-select" id="slareaper" name="slareaper" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE AREA</option>
                            </select>
                        </div>
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formpromocion"  class="form-label">Saldo Basico</label>
                            <input type="number"  class="form-control mayu" name="mtxtsalperso" id="mtxtsalperso" autocomplete="off">
                        </div>
                        <div class="col">
                                <label for="formfpago" class="form-label">Departamento</label>
                                    <select class="form-select" id="sldeparpers" name="sldeparpers" aria-label="Default select example">
                                    <option value="00000" selected>SELECCIONE DEPARTAMENTO</option>
                                </select>
                        </div>
                    </div>
                   
                        <div class="row g-2">
                            <div class="col">
                                <label for="formfpago" class="form-label">Provincia</label>
                                <select class="form-select" id="slprovpers" name="slprovpers" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE PROVINCIA</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="formfpago" class="form-label">Distrito</label>
                                <select class="form-select" id="sldistpers" name="sldistpers" aria-label="Default select example">
                                    <option value="00000" selected>SELECCIONE DISTRITO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Telefono</label>
                                <input type="number" class="form-control mayu" name="mtxttelpers" id="mtxttelpers" autocomplete="off">    
                            </div>
                            <div class="col">
                                <label for="formfpago" class="form-label">Celular</label>
                                <input type="number" class="form-control mayu" name="mtxtcelpers" id="mtxtcelpers" autocomplete="off">    
                            </div>
                        </div>

                        <div class="row g-2">
                          
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Nro Cuenta</label>
                                <input type="number" class="form-control mayu" name="mtxtcuenpers" id="mtxtcuenpers" autocomplete="off">    
                            </div>
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Titular</label>
                                <input type="text" class="form-control mayu" name="mtxttitulpers" id="mtxttitulpers" autocomplete="off">
                            </div>
                        </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"  id="btncerrarpers" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnguarpers" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>



    
    <div class="modal fade" id="mdproveedor" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h5 class="modal-title">Registro de nuevo proveedor</h5></center>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmgudarproveedor" name="frmgudarproveedor">
                        <div class="row g-2">
                            <div class="col">
                                <label for="formfpago" class="form-label">Nombre Proveeedor</label>
                                <input type="text" class="form-control mayu" name="mtxtnomprovee" id="mtxtnomprovee" autocomplete="off">
                            </div>  
                        </div> 
                        <div class="row g-2">
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Dirección</label>
                                <input type="text" class="form-control mayu" name="mtxtdirprovee" id="mtxtdirprovee" autocomplete="off">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="formpromocion"  class="form-label">RUC</label>
                                <input type="text" class="form-control mayu" name="mtxtrucprovee" id="mtxtrucprovee" autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="formpromocion"  class="form-label">DNI</label>
                                <input type="text" class="form-control mayu" name="mtxtdniprovee" id="mtxtdniprovee" autocomplete="off">
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"  id="btncerrarprovee" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnguarprovee" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


        </div>     
    </section>
</body>
</html>
