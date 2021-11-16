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
    <script src="./js/jsregistropersonal.js"></script>
    <script src="../js/bootstrap5.bundel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="../js/sweetalert2@11.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background: #f5f5f5;">
   <section>  
        <div class="main"> 
            <form id="frmgudarpers" name="frmgudarpers">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="row">
                    <div class="col mb-2">
                    <center><label class="titulos">Registro de personal</label></center>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formfpago" class="form-label">Fecha ingreso</label>
                        <input type="date"  class="form-control" name="mtxtfecingreso" id="mtxtfecingreso">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">DNI</label>
                        <input type="number"  class="form-control mayu" name="mtxtdniper" id="mtxtdniper" maxlength="8" autocomplete="off">
                    </div> 
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formfpago" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control mayu" name="mtxtnomperson" id="mtxtnomperson" autocomplete="off">
                        </div>  
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formpromocion"  class="form-label">Direccion</label>
                            <input type="text" class="form-control mayu" name="mtxtdirper" id="mtxtdirper" autocomplete="off">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col">
                            <label for="formcantidad"  class="form-label">Cargo</label>
                            <select class="form-select" id="slcargpers" name="slcargpers" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE CARGO</option>
                            </select>
                        </div>
                        <div class="col">
                            <label  for="formentrega" class="form-label">Area</label>
                            <select class="form-select" id="slareaper" name="slareaper" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE AREA</option>
                            </select>
                        </div>
                    </div> 
                    <div class="row g-2">
                        <div class="col">
                            <label for="formpromocion"  class="form-label">Saldo basico</label>
                            <input type="number"  class="form-control mayu" name="mtxtsalperso" id="mtxtsalperso" autocomplete="off">
                        </div>
                        <div class="col">
                                <label for="formfpago" class="form-label">Departamento</label>
                                    <select class="form-select" id="sldeparpers" name="sldeparpers" aria-label="Default select example">
                                    <option value="00000" selected>SELECCIONE DEPARTAMENTO</option>
                                </select>
                        </div>
                    </div>
                   
                        <div class="row g-2">
                            <div class="col">
                                <label for="formfpago" class="form-label">Provincia</label>
                                <select class="form-select" id="slprovpers" name="slprovpers" aria-label="Default select example">
                                <option value="00000" selected>SELECCIONE PROVINCIA</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="formfpago" class="form-label">Distrito</label>
                                <select class="form-select" id="sldistpers" name="sldistpers" aria-label="Default select example">
                                    <option value="00000" selected>SELECCIONE DISTRITO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Telefono</label>
                                <input type="number" class="form-control mayu" name="mtxttelpers" id="mtxttelpers" autocomplete="off">    
                            </div>
                            <div class="col">
                                <label for="formfpago" class="form-label">Celular</label>
                                <input type="number" class="form-control mayu" name="mtxtcelpers" id="mtxtcelpers" autocomplete="off">    
                            </div>
                        </div>

                        <div class="row g-2">
                          
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Nro Cuenta</label>
                                <input type="number" class="form-control mayu" name="mtxtcuenpers" id="mtxtcuenpers" autocomplete="off">    
                            </div>
                            <div class="col">
                                <label for="formpromocion"  class="form-label">Titular</label>
                                <input type="text" class="form-control mayu" name="mtxttitulpers" id="mtxttitulpers" autocomplete="off">
                            </div>
                        </div>
                </form>

                <div class="modal-footer">
                    <button type="button" id="btnguarpers" class="btn btn-primary">Guardar</button>
                </div>

        </div>     
    </section>
</body>
</html>
