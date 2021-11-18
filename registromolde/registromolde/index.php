<?php

header('Content-Type: text/html; charset=UTF-8');

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
    
    <script src="./js/jsregistromolde.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background: #f5f5f5;">
   <header>
        <title>Moldes</title>
   </header>
   <section>  
        <div class="main"> 
            <form id="frmregistromolde">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
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
                            <a class="btn btn-success" id="btnbuscpers" data-bs-toggle="modal" data-bs-target="#mdbusmolde">
                               <i class="icon-magnifying-glass" title="Buscar Personal"></i>
                            </a>
                        </div>
                      
                    </div>
                    <div class="col">
                        <label class="form-label">Medidas</label>
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
                </div>
                <div class="row mb-3">
                    <div class="col g-3">
                        <center><label class="titulos">Materiales para el molde</label></center>
                    </div>    
                </div>
                <div class="row mb-2">
                    <div class="col-8">
                        <input type="text" name="txtcodmaterial" id="txtcodmaterial" style="display: none;">  
                        <label for="formpromocion"  class="form-label">Material</label>
                        <input type="text" class="form-control mayu" name="txtnombmaterial" id="txtnombmaterial" autocomplete="off">    
                    </div>
                    <div class="col">
                        <label  class="form-label">U. Medida</label> 
                        <input type="text" class="form-control mayu" name="txtunimaterial" id="txtunimaterial" autocomplete="off">    
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label  class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="txtcantmaterial" id="txtcantmaterial" autocomplete="off">    
                    </div>
                    <div class="col">
                        <label class="form-label">Medida Material</label>
                        <input type="text" class="form-control" name="txtmendidmater" id="txtmendidmater" autocomplete="off">    
                    </div>
                </div>
                <div class="row mb-3">
                  
                    <div class="col g-4 divbotones" style="margin-top: 3px;">
                        <div class="col-auto g-4">
                            <button  type="button" id="btnagremater" class="btn btn-primary" style="float: right;">
                                    <i class="icon-plus" title="Agregar Material"></i>
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
                                        <th class="thtitulo" scope="col">Medidas</th>
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

            <div class="modal fade" id="mdbusmolde" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar molde</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label>Buscar molde</label>
                        <div class="col">
                          <input type="text" id="txtbuscmolde" class="form-control mayu" autocomplete="off">
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnbusmolde" class="btn btn-primary">Guardar</button>
                </div>
                </div>
            </div>
            </div>
        </div>     
    </section>
</body>
</html>
