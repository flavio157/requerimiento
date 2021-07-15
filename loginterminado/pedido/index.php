<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*if(!isset($_SESSION['zona'])){
    header('Location: index.php');
    exit;
} */
date_default_timezone_set('America/Lima');
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
?>

<!DOCTYPE html>
<html>
<head>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <link rel="stylesheet" type="text/css" href="../font/style.css">
        <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        <script type="text/javascript" src="../js/jslogin.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuotas</title>
</head>
<body>
<div class="mainPersonal">
            <form>
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="divtitulo">
                    <center><h5><label for="formdescripcion" class="form-label">Personal Cuota Baja</label></h5></center>
                </div>
                <div class="row">
                    <div class="col">
                        
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary personalfalta" id="personalfalta">Mostrar</a>
                    </div>
                </div>
                
                <div class="contenerdotabla">
                        <div class="table-responsive tablafrmpedidos">
                        <table id="tablacaja" class="table table-striped table-bordered dt-responsive nowrap tablacaja" style="width:100%">
                            <thead>
                                    <tr class="table-primary">
                                        <th scope="row">CODIGO</th>
                                        <th scope="row">NOMBRE</th>
                                        <th scope="row">PROMEDIO</th>
                                        <th scope="row">OFICINA</th>
                                    </tr>
                                </thead>
                                    <tbody id="tbcaja">
                                    </tbody>
                            </table>
                        </div>
                </div>
            </form>
        </div>
</body>
    
<!-- Datatable CSS -->
<link href='https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css' rel='stylesheet' type='text/css'>

<!-- jQuery Library -->

<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

</html>
