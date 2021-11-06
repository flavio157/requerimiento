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
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">

     <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jskardex.js"></script>
    <!--<script src="../js/bootstrap5.bundel.min.js"></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
    <script src="../js/sweetalert2@11.js"></script>
    <script src="../js/jquery-ui-autocompletar.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .ui-autocomplete.ui-front {
    max-height: 300px;
    width: 100px;
    overflow-y: auto;   
    overflow-x: hidden; 
    z-index:1100 !important;
}
</style>

<body style="background: #f5f5f5;">
   <header>
        <title>Kardex</title>
   </header>
   <section>  
        <div class="main"> 
        <form class="row g-3" id="frmrfechas" style="margin-bottom: 0px;">
            <div class="row">
                <div class="col g-4">
                    <center><label class="titulos">Kardex</label></center>
                </div>
            </div>
           <div class="col-auto" id="divfechini">
               <div class="input-group input-group mb-3" style="margin-bottom: 0px !important;">
                   <span class="input-group-text" id="inputGroup-sizing-default">F. Inicio</span>
                   <input type="date" class="form-control" id="fecini">
               </div>
           </div>
           <div class="col-auto" id="divfechfin">
               <div class="input-group input-group mb-3" style="margin-bottom: 0px !important;">
                    <span class="input-group-text" id="inputGroup-sizing-default">F. Fin &nbsp;&nbsp;&nbsp;</span>
                    <input type="date" class="form-control" id="fecfin">
                </div>
            </div>
            <div class="row g-3">
                <div class="col" id="divselect">
                    <div class="input-group input-group mb-3" style="margin-bottom: 0px !important;">
                    <input type="text" class="form-control mayu" id="txtidpro" name="txtidpro"  style="display: none;">
                        <span class="input-group-text" id="inputGroup-sizing-default">Buscar &nbsp;</span>
                        <input type="text" class="form-control mayu" id="txtkarproducto" name="txtkarproducto">
                    </div> 
                </div>
                <div class="col-auto" id="divfiltrar">
                    <button type="button" id="btnkarfiltro" class="btn btn-primary mb-3">Filtrar</button>
                </div>
            </div>
         
       </form>
            <table id="tbkardex" class="table table-sm">
                <thead>
                    <tr>
                        <th class="thtitulo" scope="col">Nro Documento</th>
                        <th class="thtitulo" scope="col">Producto</th>
                        <th class="thtitulo" scope="col">Ingreso</th>
                        <th class="thtitulo" scope="col">Salida</th>
                    </tr>
                </thead>
                <tbody id="tbdkardex">
                </tbody>
            </table>
        </div>     
    </section>
</body>
        <script src="../js/abootstrap.min.js"></script>
        <link href= "https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet" >
      
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap5.min.js"></script>
        <script src="../js/dataTables.buttons.min.js"></script>
        <script src="../js/jszip.min.js"></script>
        <script src="../js/buttons.html5.min.js"></script>
</html>

