<?php

header('Content-Type: text/html; charset=UTF-8');

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="./js/jsregistromolde.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background: #f5f5f5;">
   <header>
        <title>Molde Externo</title>
   </header>
   <section>  
        <div class="main"> 
            <form id="frmregistromolde">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo 'SMP2'//$ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo '0215'//$cod?>"/>
                
                <div class="row mb-3">
                    <div class="col g-3">
                        <center><label class="titulos">Datos del Cliente</label></center>
                    </div>    
                </div>
                <div class="row mb-1">
                    <div class="col">
                        <label  class="form-label">Nombre cliente</label> 
                        <input type="text" name="txtcodcliente" id="txtcodcliente" style="display: none;">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control mayu" placeholder="Buscar por nombre o razon social" name="txtcliente" id="txtcliente" autocomplete="off">    
                            <a class="btn btn-success" id="btnbuscclien" data-bs-toggle="modal" data-bs-target="#mdclientemolde">
                               <i class="icon-users" title="Buscar Molde"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <label  class="form-label">Identificacion</label> 
                        <input type="text" class="form-control mayu" placeholder="Buscar por DNI ó RUC" name="txtidentificacion" id="txtidentificacion" autocomplete="off">    
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col g-3">
                        <center><label class="titulos">Datos del molde</label></center>
                    </div>    
                </div>
                <div class="row mb-2">
                    <div class="col-md">
                    <input type="text" name="txtcodmolde" id="txtcodmolde" style="display: none;">
                    <label for="formpromocion"  class="form-label">Nombre</label>
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control mayu" name="txtnommolde" id="txtnommolde" autocomplete="off"> 
                            <a class="btn btn-success" id="btnbuscarmoldes" data-bs-toggle="modal" data-bs-target="#mdbusmolde">
                               <i class="icon-magnifying-glass" title="Buscar Molde"></i>
                            </a>
                        </div>
                      
                    </div>
                    <div class="col-md">
                        <label class="form-label">Medidas molde</label>
                        <input type="text" class="form-control" name="txtmedmolde" id="txtmedmolde" autocomplete="off">    
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">Estado</label>
                        <select class="form-select" id="slcestado" name="slcestado">
                            <option value="" >SELECCIONE ESTADO</option>
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="formfpago" class="form-label">Tipo de Molde</label>
                        <select class="form-select" id="slctipomolde" name="slctipomolde">
                            <option value="E">Externo</option>
                            <option value="P" selected>Propio</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto">
                        <label class="form-label">Estilo de Molde</label>
                        <select class="form-select" id="slcestilo" name="slcestilo">
                            <option value="0" selected>Seleccionar Estilo</option>     
                            <option value="I">Inyección</option>
                            <option value="S">Soplado</option>
                        </select>
                    </div>
                </div>    
              
              

               
                <div class="row">
                    <div class="col">
                        <center><label class="titulos">Materiales para el molde</label></center>
                    </div>    
                </div>
                <div class="row mb-3">
                    <div class="col-auto">
                        <label for="formfpago" class="form-label">Tipo de material</label>
                        <select class="form-select" id="slctipomaterial" name="slctipomaterial">
                            <option value="E">Externo</option>
                             <option value="P" selected>Propio</option>
                        </select>
                    </div>
                </div>


                <div class="row mb-1">
                    
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Material</label>
                        <div class="input-group">
                            <input type="text"  name="txtcodmaterialexter" id="txtcodmaterialexter" style="display: none;">        
                            <input type="text" name="txttipomat" id="txttipomat" style="display: none;">
                            <input type="text" name="txtcantidad" id="txtcantidad" style="display: none;">
                            <input type="text" class="form-control mayu" name="txtmaterialexter" id="txtmaterialexter" autocomplete="off">
                            <a class="btn btn-success" id="btnlstmaterial" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                               <i class="icon-magnifying-glass" title="Buscar Molde"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col">
                            <label  class="form-label">Cantidad recibida</label> 
                            <input type="number" class="form-control mayu" name="txtcanexternorec" id="txtcanexternorec" autocomplete="off">    
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col">
                        <label  class="form-label">U. Medida</label> 
                        <input type="text" class="form-control mayu" name="txtuniextern" id="txtuniextern" autocomplete="off">    
                    </div>
                    <div class="col">
                        <label  class="form-label">Cantidad por usar</label>
                        <input type="number" class="form-control" name="txtcanexterno" id="txtcanexterno" autocomplete="off">    
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col g-4 divbotones" style="margin-top: 3px;">
                        <div class="col-auto g-4">
                            <button  type="button" id="btnagremater" class="btn btn-primary" style="float: right;">
                                    <i class="icon-add-to-list" title="Agregar Material"></i>
                            </button>
                        </div>
                    </div>
                </div> 
                <div  class="row">
                    <div class="col">
                        <div class="table-responsive-sm" style="overflow: scroll;height: 250px;">  
                            <table id="tbmaterialmolde" class="table table-sm">
                                <thead>
                                    <tr>
                                       <th class="thtitulo" scope="col" style="display: none;">codmaterial</th>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Cantidad</th>
                                        <th class="thtitulo" scope="col" style="display: none;">unidad</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdmaterialmolde">
                                </tbody>
                            </table>
                        </div>  
                    </div>     
                </div>   
               
                <div class="row">
                    <div class="col g-4 divbotones">
                        <button  type="button" id="btnnuevo"  class="btn btn-primary mb-2 pull-left ">
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

            <div class="modal fade" id="mdbusmolde" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Moldes registrados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="overflow: scroll;height: 366px;">
                            <table class="table" id="tbmoldes">
                                <thead>
                                    <tr>
                                    <th scope="col" style="display: none;">ID</th>
                                    <th scope="col" class="thtitulo">Molde</th>
                                    <th scope="col" class="thtitulo">Medidas</th>
                                    <th scope="col" style="display: none;">estado</th>
                                    <th scope="col" class="thtitulo">Tipo</th>
                                    <th scope="col" class="thtitulo">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdmoldes">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <!--<button type="button" id="btnbusmolde" class="btn btn-primary">Aceptar</button>-->
                    </div>
                    </div>
                </div>
            </div>


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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnsalircli" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btngcliemodle" class="btn btn-primary">Guardar</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="mdmaterial" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Materiales</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="overflow: scroll;height: 366px;">
                            <table class="table" id="tbmaterial">
                                <thead>
                                    <tr>
                                    <th scope="col" style="display: none;">ID</th>
                                    <th scope="col" class="thtitulo">Nombre</th>
                                    <th scope="col" class="thtitulo">Stock</th>
                                    <th scope="col" class="thtitulo">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdmaterial">

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





        </div>     
    </section>
</body>
</html>
