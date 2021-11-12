<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
require_once(".././menu/index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	 <link rel="STYLESHEET" type="text/css" href="./css/responsive.css">
     <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/ajquery.min.js"></script>
    <script src="./js/jsregistrarmaterial.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/sweetalert2@11.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #f5f5f5;">
   <section>  
        <div class="main"> 
        <form id="frmguardaprod" name="frmguardaprod">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="row">
                    <div class="col mb-2">
                    <center><label class="titulos">Registro de material</label></center>
                    </div>
                </div>
                <div class="row g-2">
                <div class="col">
                    <label for="formfpago" class="form-label">Codigo Producto</label>
                    <input type="text"  class="form-control mayu" name="mtxtcodigopro" id="mtxtcodigopro" maxlength="6" autocomplete="off">
                </div> 
                <div class="col">
                    <label for="formcantidad"  class="form-label">Unidad Medida</label>
                    <input type="text"  class="form-control mayu"  name="mtxtunimedida" id="mtxtunimedida" maxlength="10" autocomplete="off">
                </div>
                </div> 
                <div class="row g-2">
                    <div class="col">
                        <label for="formfpago" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control mayu" name="mtxtnombreproducto" id="mtxtnombreproducto" autocomplete="off">
                    </div>  
                </div> 
                <div class="row g-2">
                    <div class="col">
                        <label  for="formentrega" class="form-label">Categoria</label>
                        <select class="form-select" id="slcategoria" aria-label="Default select example">
                            <option value="" selected>SELECCIONE CATEGORIA</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Abreviatura</label>
                        <input type="text"  class="form-control mayu" name="mtxtabreviatura" id="mtxtabreviatura" maxlength="4" autocomplete="off">
                    </div>
                    <div class="col">
                        <label for="formpromocion"  class="form-label">Stock minimo</label>
                        <input type="number" class="form-control mayu" name="mtxtstockmin" id="mtxtstockmin" autocomplete="off">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formpromocion" class="form-label">Peso neto</label>
                        <input type="number" class="form-control" name="mtxtneto" autocomplete="off" id="mtxtneto">
                    </div>
                <div class="col">
                    <label for="formfpago" class="form-label">Clase</label>
                    <select class="form-select" id="slclase" aria-label="Default select example">
                        <option value="" selected>SELECCIONE CATEGORIA</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="modal-footer">
            <button type="button" id="btnguardarprod" class="btn btn-primary">Guardar</button>
        </div>
        </div>     
    </section>
</body>
</html>
