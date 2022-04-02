<?php

header('Content-Type: text/html; charset=UTF-8');

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    
    <script src="./js/jsmolde.js"></script>
    <link rel="stylesheet" type="text/css" href="../fonts/style.css">
    <link rel="stylesheet" type="text/css" href="./css/responsive.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #f5f5f5;">
   <header>
        <title>Registro de fabricacion</title>
   </header>
   <section>  
        <div class="main"> 
            <form id="frmfabricacion">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo $cod?>"/>
                    
                    <div class="row">
                        <div class="col mb-3">
                         <center><label class="titulos">Registro Fabricacion de molde</label></center>
                        </div>    
                    </div>

                    <div class="row align-items-center">
                        <div class="col-auto mb-3">
                            <label class="form-label">Fecha inicio</label>
                        </div>
                        <div class="col-auto mb-3">
                            <input type="date" class="form-control" id="txtfechini" value="<?php echo $fcha;?>"
                            min = "<?php echo date("Y-m-d");?>"
                            max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 30 days"));?>">
                        </div>
                    </div> 


                    <div class="row">
                        <div class="col">
                            <center><label class="titulos">Datos del molde</label></center>
                        </div>    
                    </div>
                    <div class="row">
                         <div class="col">
                            <label for="formpromocion"  class="form-label">Nombre molde</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="txtcodmolde" id="txtcodmolde" style="display: none;">
                                <input type="text" class="form-control" name="txttipomolde" id="txttipomolde" style="display: none;">
                                <input type="text" class="form-control" name="txtmedidas" id="txtmedidas" style="display: none;">
                                <input type="text" class="form-control mayu" name="txtdesmolde" id="txtdesmolde" placeholder="Buscar Molde">
                                <!--<a class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#mdagregarmolde" id="button-addon1">
                                        <i class='icon-new-message' title='Agregar molde'></i>
                                </a>-->
                            </div>
                         </div>
                    </div> 
                    
                    <div class="row">
                        <div class="col-md ">
                            <label for="formpromocion"  class="form-label">Material</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="txtcodmater" id="txtcodmater" style="display: none;">
                                <input type="text" class="form-control" name="txtunidadmater" id="txtunidadmater" style="display: none;">
                                <input type="text" class="form-control mayu" name="txtdesmater" id="txtdesmater" placeholder="Buscar Material">
                              
                            </div>
                         </div>
                        <div class="col ">
                            <label class="form-label">Cantidad por usar</label>
                            <input type="Number" class="form-control" id="txtcantidadmaterial" name="txtcantidadmaterial"  autocomplete="off">    
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col g-3 ">
                            <a class="btn btn-primary" type="button" id="btnagregarmater" style="float: right;">
                                <i class='icon-add-to-list' title='Agregar molde'></i>
                            </a>
                        </div>
                    </div>
                    
                <div  class="row">
                    <div class="col">
                        <div class="table-responsive-sm" style="overflow: scroll;height: 165px;">  
                            <table id="tbmaterialmolde" class="table table-sm">
                                <thead>
                                    <tr>
                                       <th class="thtitulo" scope="col" style="display: none;">codmaterial</th>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Serie</th>
                                        <th class="thtitulo" scope="col">Cantidad</th>
                                        <!--<th class="thtitulo" scope="col">U.Medida</th>-->
                                        <th class="thtitulo" scope="col">Stock</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdmaterialmolde">
                                </tbody>
                            </table>
                        </div>  
                    </div>     
                </div>   

                <div class="row mb-1">
                    <div class="col" style="margin-top: 12px;">
                        <div class="col">
                            <center><label class="titulos">Personal Involucrado</label></center>
                        </div>
                    </div>    
                </div>  

                <div class="row align-items-center">
                        <div class="col-auto mb-3">
                            <label class="form-label">Fecha inicio</label>
                        </div>
                        <div class="col-auto mb-3">
                            <input type="date" id="txtfecinipers" class="form-control"  value="<?php echo $fcha;?>"
                            min = "<?php echo date("Y-m-d");?>"
                            max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 30 days"));?>"> 
                        </div>
        
                    </div> 
                <div class="row">
                    <div class="col g-4" style="margin-top: 0px;">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="txtcodpermolde" id="txtcodpermolde" style="display: none;">
                            <input type="text" class="form-control mayu" id="txtpersonalmolde" placeholder="Buscar Personal">
                            <a class="btn btn-success" id="addpersonal">
                                <i class="icon-add-user" title="agregar derecha"></i>
                            </a>
                        </div>
                    </div>
                </div> 
                <div  class="row">
                    <div class="col mb-2">
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
                                        <th class="thtitulo" scope="col">Acciones</th>
                                        <th class="thtitulo" scope="col" style="display: none;">descripcion</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdpersonalmolde">
                                </tbody>
                            </table>
                        </div>     
                    </div> 
                </div>
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

            <div class="modal fade" id="modalserie" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar numero de serie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="mbody">
                    <form>
                        <div class="mb-3">
                            <label class="col-form-label">Numero de serie</label>
                            <input type="text" class="form-control mayu" id="txtmnuserie" autocomplete="off">
                           
                        </div>
                    </form>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnagserie" class="btn btn-primary">Guardar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>     
    </section>
</body>
</html>
