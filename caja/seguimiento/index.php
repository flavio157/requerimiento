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

<html>
    <head>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <link rel="stylesheet" type="text/css" href="../fonts/style.css">

        <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
        
       
        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        
        <script type="text/javascript" src="./js/jcaja.js"></script>
        
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
<meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
    </head>
    <body>
        <div class="contenerdotabla">
            <form class="row g-3">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="divtitulo">
                    <h5><label for="formdescripcion" class="form-label">LISTA PARA VERIFICAR CAJA</label></h5>
                </div>
                <div class="row">
                    <div class="col-auto text-right">
                            <select class="form-select mb-3" id="sloficina" aria-label="Default select example">
                                <option selected value="select">Seleccione Oficina</option>
                                <option value="SMP2">SMP2</option>
                                <option value="SMP3">SMP3</option>
                                <option value="SMP4">SMP4</option>
                                <option value="SMP5">SMP5</option>
                                <option value="SMP6">SMP6</option>
                            </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary mb-3" id="btnmostrar">Mostrar</button>
                    </div>

                    <div class="col-auto mb-3" id="divfechini">
                        <div class="input-group input-group" style="margin-bottom: 0px !important;">
                            <span class="input-group-text" id="inputGroup-sizing-default">Fecha</span>
                            <input type="date" class="form-control " id="iniciodtfecha" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                    <div class="col-auto" id="divfiltrar">
                        <button type="button" id="btncomentarios" class="btn btn-primary mb-3">ver comentario</button>
                    </div>
                </div>     
                <div class="table-responsive tablafrmpedidos">
                    <table id="tablacaja" class="table table-striped table-bordered dt-responsive nowrap tablacaja" style="width:100%">           
                        <thead>
                            <tr class="table-primary">
                                <th scope="row" style="display: none;">correlativo</th>
                                <th scope="row" style="display: none;">codpersonal</th>
                                <th scope="row">PERSONAL</th>
                                <th scope="row">MONTO</th>
                                <th scope="row">FECHA CAJA</th>
                                <th scope="row">FECHA RECIBIDO</th>
                                <th scope="row">REGISTRAR</th>
                            </tr>
                            </thead>
                            <tbody id="tbcaja">
                            </tbody>
                    </table>
                </div>
               
            </form>
            <div class="modal fade" id="mverificarcomen" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Verificar comentario</h5>
                    </div>
                    <div class="modal-body">
                        <form id="frmactucomentario">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Comentario</label>
                                <textarea class="form-control" id="txtcomentarioactua"></textarea>
                                <input type="text" id="cod_comentario" style="display: none;"/>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnactuestadocom" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
                    </div>
                    </div>
                </div>
            </div>
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