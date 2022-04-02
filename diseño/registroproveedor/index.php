<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
require_once("./menu/index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
     <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsproveedor.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/sweetalert2@11.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #f5f5f5;">
   <section>  
        <div class="main"> 
            <form id="frmgudarproveedor" name="frmgudarproveedor">
                <div class="row g-2">
                    <div class="col">
                        <center><label for="formfpago" class="form-label titulos">Registrar nuevo proveedor</label></center>
                    </div>  
                </div> 
                <div class="row g-2">
                    <div class="col">
                        <label for="formfpago" class="form-label">Nombre Proveeedor</label>
                        <input type="text" class="form-control mayu" name="mtxtnomprovee" id="mtxtnomprovee" autocomplete="off">
                    </div>  
                </div> 
                <div class="row g-2">
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Dirección</label>
                        <input type="text" class="form-control mayu" name="mtxtdirprovee" id="mtxtdirprovee" autocomplete="off">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formpromocion"  class="form-label">RUC</label>
                        <input type="text" class="form-control mayu" name="mtxtrucprovee" id="mtxtrucprovee" autocomplete="off">
                    </div>
                    <div class="col">
                        <label for="formpromocion"  class="form-label">DNI</label>
                        <input type="text" class="form-control mayu" name="mtxtdniprovee" id="mtxtdniprovee" autocomplete="off">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Telefono</label>
                        <input type="text" class="form-control mayu" name="mtxttelefprovee" id="mtxttelefprovee" autocomplete="off">
                    </div>
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Celular</label>
                        <input type="text" class="form-control mayu" name="mtxtcelprovee" id="mtxtcelprovee" autocomplete="off">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-auto">
                        <label for="formfpago" class="form-label">Estado</label>
                            <select class="form-select" id="slcestadoprovee" name="slcestadoprovee" aria-label="Default select example">
                                <option value="" >SELECCIONE ESTADO</option>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                    </div>
                </div>
            </form>
        <div class="modal-footer">
            <button type="button" id="btnguarprovee" class="btn btn-primary">Guardar</button>
        </div>
        </div>     
    </section>
</body>
</html>
