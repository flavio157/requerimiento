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
        <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
        <link rel="STYLESHEET" type="text/css" href="../css/bootstrap.min.css">
        <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="../js/jsproductofinal.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
        
    </head>
    <body>
        <div class="main">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalpedido">
           PEDIDO
        </button>
            <?php include '../vista/Modal_Pedido.php';?>
            <?php include '../vista/Modal_IngresarProducto.php';?>
            <?php include '../vista/Modal_ListarPedidos.php';?>

        </div>
    </body>
</html>
