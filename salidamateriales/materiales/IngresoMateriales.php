<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="../css/responsive.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ingreso de Materiales</title>
</head>
<body>
    <div class="main">
        <form class="row g-3">
            <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
            <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
            <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
            <div class="row">
                <div class="col g-3" style="padding-bottom: 8px;">
                    <center><label class="titulos">Registro de Comprobante</label></center>
                </div>    
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="inputPassword4" class="form-label">Orden Compra</label>
                    <input type="text" class="form-control" id="specificSizeInputGroupUsername">
                </div>
                <div class="col-md-4">
                        <label for="inputState" class="form-label">Fecha Entrega</label>
                        <input type="date" class="form-control" >
                </div>

            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Personal</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control">
                        <span class="input-group-text" style="padding: 0px !important;" id="basic-addon2"> <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                        <i class="icon-plus" title="Alinear a la derecha"></i>
                    </a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="inputState" class="form-label">Fecha Entrega</label>
                    <input type="date" class="form-control" >
                </div>
                <div class="col-md-3">
                    <label for="inputZip" class="form-label">Tipo Comprobante</label>
                    <input type="text" class="form-control" id="inputZip">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
            
    <?php
        include "../vista/modalpersonal.php";
    ?>
        </form>    
    </div>
</body>
</html>