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
<html lang="en">
<head>
        <script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <LINK REL=StyleSheet HREF="css/responsive.css" TYPE="text/css" MEDIA=screen>
        <link rel="STYLESHEET" type="text/css" href="fonts/style.css">
        <link rel="STYLESHEET" type="text/css" href="css/bootstrap.min.css">
        <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
        <script  type="text/javascript" src="./js/jsformulario.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
    <title>Document</title>
</head>
<body>
    <div class="main">
        <form class="row g-3"  id="frmcomprovante">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $_SESSION["ofi"]?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $_SESSION["zon"]?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo $_SESSION["cod"]?>"/>
                <input name="txtnombreimg" id="txtnombreimg" class="form-control" style="display: none;">
                <div id="mensajesgenerales">
                                   
                </div>
                <div class="col-12">
                    <center><label for="formTipo" class="form-label">EMPRESA</label></center>
                        <select class="form-select " name="slcempresa" id="slcempresa"  data-size="5">
                            <option value= " " selected>SELECCIONE EMPRESA</option>            
                        </select>
                </div>
                <div class="row g-2">
                    <center><label for="formTipo" class="form-label">PERSONAL</label></center>
                    <div class="col-3">
                        <input type="text" name="txtcodpersonal" id="txtcodpersonal" class="form-control" disabled=true>
                    </div>
                    <div class="col-7">
                        <input type="text" name="txtnombreper" id="txtnombreper" class="form-control" disabled=true>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-primary active btn-block" id="grabar" >
                            <i class="icon-attachment" title="Align Right"></i>
                        </a>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">TIPO</label></center>
                        <select class="form-select" name="slcdocumento" id="slcdocumento" aria-label="Default select example">
                            <option value="" selected>TIPO DE DOCUMENTO</option>
                            <option value="1">FACTURA</option>
                            <option value="2">BOLETA</option>
                            <option value="3">RECIBO POR HONORARIO</option>      
                        </select>
                    </div>
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">SERIE DOCUMENTO</label></center>
                        <input type="text" name="txtseriedocument" id="txtseriedocument" class="form-control">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">N° DOCUMENTO</label></center>
                        <input type="number" name="txtnrodocumento" id="txtnrodocumento" class="form-control">
                    </div>
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">RUC</label></center>
                        <input name="txtcod_prove" id="txtcod_prove" class="form-control" style="display: none;">
                        <input type="number" name="txtruc" id="txtruc" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <center><label for="formTipo" class="form-label">PROVEEDOR</label></center>
                     <input type="text" name="txtproveedor" id="txtproveedor" class="form-control">
                </div>
                <!--<div id="sugerencias"></div>-->
                <div class="col-12">
                    <center><label for="formTipo" class="form-label">DIRECCION DEL PROVEEDOR</label></center>
                     <input type="text" name="txtdirproveedor" id="txtdirproveedor" class="form-control">
                </div>
                
                <div class="col-12">
                    <center><label for="formTipo" class="form-label">OBSERVACION</label></center>
                     <input type="text" name="txtobservacion" id="txtobservacion" class="form-control">
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">CONCEPTO</label></center>
                        <select class="form-select" name="slcconcepto" id="slcconcepto" aria-label="Default select example">
                            <option value="" selected>SELECCIONE EMPRESA</option>      
                            <option value="00001">POST VENDEMAS</option>
                            <option value="00002">POST IZPEY</option>
                            <option value="00470" data-caja="00002">COMBUSTIBLE</option>
                            <option value="00491" data-caja="00002">SERIVIO DE TRANSPORTE</option>
                            <option value="00485" data-caja="00015">SERVICIO DE MENSAJERIA</option>
                            <option value="00522" data-caja="00008">UTILES DE LIMPIEZA</option>
                            <option value="00469" data-caja="00008">UTILES DE OFICINA</option>
                            <option value="00490" data-caja="00002">PEAJES</option>
                            <option value="00500" data-caja="00001">ESTACIONAMIENTO</option>
                            <option value="00486" data-caja="">SUMINISTROS DIVERSOS</option>               
                        </select>
                    </div>
                    <div class="col-6">
                        <center><label for="formTipo" class="form-label">MONTO</label></center>
                        <input type="number" name="txtmonto" id="txtmonto" class="form-control"> 
                    </div>
                </div>
                <div class="col-12">
                    <div class="col text-center">
                        <a class="btn btn-primary active btn-lg" id="btntomafoto">
                            <i class="icon-camera" title="Align Right"></i>
                        </a>
                    </div>

               
                      
               
                </div>
        </form>
        
    <?php include 'vista/modal_personal.php';?>
    <?php include 'vista/modal_foto.php';?>
    <?php include 'vista/modal_verfoto.php';?>

</body>




</html>