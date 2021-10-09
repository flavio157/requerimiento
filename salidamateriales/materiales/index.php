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
    <meta charset="UTF-8">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	<link rel="STYLESHEET" type="text/css" href="../css/responsive.css">
    <script src="../js/jsformulario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="main">
        <form id="frmmatsalida">
        <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
        <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
        <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
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
        <div class="row g-1">
            <div class="col-3">
                <input type="text" class="form-control" name="txtcodigoper" id="txtcodigoper" disabled>
            </div>
            <div class="col-7">
                <input type="text" class="form-control" name="txtnombrepersonal" id="txtnombrepersonal" disabled>
            </div>
            <div class="col-1">
                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                    <i class="icon-plus" title="Alinear a la derecha"></i>
                </a>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-10">
                <label for="exampleFormControlTextarea1" class="form-label thtitulo">Descripción</label>
                <textarea class="form-control" id="txtdescripcion" rows="2"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col g-4">
              <label class="thtitulo">Material Solicitado</label>
            </div>    
        </div>
        <div class="row g-1">
            <div class="col-7">
            <input type="text" class="form-control" name="txtcodmaterial" id="txtcodmaterial" style="display: none;">
                <input type="text" class="form-control" name="txtmaterial" id="txtmaterial" placeholder="Material">
            </div>
            <div class="col-3">
                <input type="text" class="form-control" name="txtseriematerial" id="txtseriematerial" placeholder="Nro Serie">
            </div>
            <div class="col-1">
                <a class="btn  btn-info" id="aentrega">
                    <i class="icon-plus" title="Alinear a la derecha"></i>
                </a>
            </div>
            <div id='material' class="sugerencias"></div>
        </div>  
        <div class="row">
            <div class="col g-4">
            </div>    
        </div>
        <div class="row g-1">
            <div class="col-4">
                <label class="thtitulo">Cantidad</label>
                <input type="text" class="form-control" name="txtcanmaterial" id="txtcanmaterial" placeholder="cantidad">
            </div>
            <div class="col-4">
                <label class="thtitulo">Stock</label>
                <input type="text" class="form-control" name="txtstckmaterial" id="txtstckmaterial" disabled>
            </div>
        </div>

        <div  class="row">
            <div class="col">
                <div class="col g-1 titulos materiales"><center>Material a entregar</center></div>    
                <div class="table-responsive">  
                    <table id="tbmaterialentrega" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col">Material</th>
                                <th class="thtitulo" scope="col">Serie</th>
                                <th class="thtitulo" scope="col">cantidad</th>
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
                <div class="table-responsive">  
                    <table id="tbmaterialsalida" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="thtitulo" scope="col">Material</th>
                                <th class="thtitulo" scope="col">Serie</th>
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
                <button id="btnnuevo" type="button" class="btn btn-primary mb-2 pull-left"  >Nuevo</button>
            </div>
            <div class="col g-4">
                <button id="btnguardar" type="button" class="btn btn-primary mb-2"  style="float: right;">Guardar</button>
            </div> 
        </div> 
        </form>  

        <?php 
            include("../vista/modalpersonal.php");
            include("../vista/modalmaterial.php");
        ?>
    </div>
</body>
</html>