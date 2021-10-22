<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*if(!isset($_SESSION['zona'])){
    header('Location: index.php');
    exit;
} */
date_default_timezone_set('America/Lima');
$fcha = date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
?>
<html lang="en"><head>
  <meta charset="UTF-8">
  
<title>Reporte de Furgon</title>
<link rel="STYLESHEET" type="text/css" href="./css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
<!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
<script src="../js/sweetalert2@11.js"></script>


<meta name="viewport" content="width=device-width, initial-scale=1.0">
</script>
</head>
  
<body translate="no">
        <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
        <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
        <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
        <input type="text" id="vrcodcliente" style="display: none;"/>
    <div class="contenradio">
        <div class="d-flex">
            <div class="form-check form-check-inline" style="color: #fff;">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdoficinas" value="Oficinas">
                <label class="form-check-label" for="rdoficinas">General</label>
            </div>
            <div class="form-check form-check-inline" style="color: #fff;">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdvendedor" value="Vendedor">
                <label class="form-check-label" for="rdvendedor">Oficina</label>
            </div>
        </div>
    </div>
    

        <div class="main" style="padding-top: 0px;">
            <form class="row g-3" id="frmrfechas" style="margin-bottom: 0px;">
           
                <div class="col-auto" id="divfechini">
                    <div class="input-group input-group mb-3" style="margin-bottom: 0px !important;">
                        <span class="input-group-text" id="inputGroup-sizing-default">F. Inicio</span>
                        <input type="date" class="form-control" id="iniciodtfecha" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="button" id="btnfiltrar" class="btn btn-primary mb-3">Filtrar</button>
                </div>
            </form>

            <div class="col-md-12" id="divtabla">
                <div class="card">
                        <div class="card-header" >
                            REPORTE DE FURGON
                        </div>
                    <div class="card-body outer">
                        <table class="table  dt-responsive nowrap" id="tbcabecera">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Oficina</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody id="tbprincipal">
                               
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            <div class="row" id="divcomentario">
                <div class="col g-4">
                    <button  type="button" id="btnmodalcomen" class="btn btn-primary mb-2"  style="float: right;"
                             data-bs-toggle="modal" data-bs-target="#modalcomentario">
                    <i class="icon-save" title="Guardar datos"></i>Comentario</button>
                </div> 
            </div>
        </div>

        <?php
            include "./modal/modalComentario.php";
        ?>


        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="../js/ajquery.min.js"></script>
       <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/js/bootstrap.min.js"></script>-->
        <script src="../js/abootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
       <!--<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>-->
        <script src="../js/jquery.dataTables.min.js"></script>
       <!-- <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>-->
        <script src="../js/dataTables.bootstrap5.min.js"></script>
         <script src="./js/table.js"></script>
    </body>
</html>

