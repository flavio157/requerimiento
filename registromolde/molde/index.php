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
    
    <script src="./js/jsmolde.js"></script>
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
            <form id="frmfabricacion">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="row">
                    <div class="col g-3">
                    <center><label class="titulos">Registro Fabricacion de molde</label></center>
                    </div>    
                </div>
                    <div class="row">
                        <div class="col g-4" >
                            <div class="input-group mb-3">
                                <span class="input-group-text">Inicio</span>
                                <input type="date" class="form-control" id="txtfechini">
                            </div> 
                        </div>    
                        <div class="col g-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Fin &nbsp&nbsp&nbsp</span>
                                <input type="date" class="form-control" id="txtfechfin">
                            </div>
                        </div>    
                    </div> 
                
                <div class="row">
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
                                        <th class="thtitulo" scope="col">U.Medida</th>
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
        </div>     
    </section>
</body>
</html>
