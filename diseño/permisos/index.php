<?php
    //require_once("../menu/index.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #f5f5f5;">
<link rel="STYLESHEET" type="text/css" href="./css/permisos.css">
<link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
<script src="../js/jquery-3.3.1.slim.min.js"></script>
<script src="../js/ajquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
<form id="frmpermisos">
<center style="padding-top: 2em;"><label>MENUS</label></center>
    <div class="main">
           <!-- <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <input class="form-control form-control" id="txtanexo" >
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                </div>
            </div>-->
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <div class="row g-3">
                        <div class="col mb-3">
                            <input class="form-control form-control" id="txtanexo" >
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                Permisos
                            </div>
                            <div class="card-body">
                                <div class="container-fluid" style="height:400px; overflow: scroll;">
                                    <ul id="tree">
                                    </ul>
                                </div>
                                <div class="row g-3 align-items-center" style="float: right;">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" id="btnguardar">Registrar</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Nuevo Menu
                        </div>
                        <div class="card-body">
                        <form >
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text"  id="txtidmenu" style="display: none;">
                                    <input type="text"  id="txtestmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtnommenu" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txturlmenu" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdactimenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rddescmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" id="btngmenus" class="btn btn-primary btn-sm mb-3">Agregar</button>
                                </div>
                            </div>    
                        </form>
                        <div style="height:297px; overflow: scroll;">
                            <table id="tbmenu" class="table table-borderless table-sm">
                                <tbody id="tbdmenu">
                                </tbody>
                            </table>
                        </div>
                            
                        </div>
                    </div>
                </div> 
            </div>    
            <div class="row mb-3">
                <div class="col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                           Nuevo sub menu
                        </div>
                        <div class="card-body">
                        <form >
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" id="txtidsubmenu" style="display: none;">   
                                    <input type="text" id="txtestsubmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtnomsubmenu" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txturlsubmenu" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdactisubmenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rddescsubmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" id="btngsubmenu" class="btn btn-primary btn-sm mb-3">Agregar</button>
                                </div>
                            </div>    
                        </form>
                        <div style="height:156px; overflow: scroll;">
                            <table id="tbsubmenu" class="table table-borderless table-sm">
                                    <tbody id="tbdsubmenu">
                                    
                                    </tbody>
                            </table>  
                        </div>    
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            Nuevo sub sub menu
                        </div>
                        <div class="card-body">
                        <form >
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" id="txtidsubsubmenu" style="display: none;">   
                                    <input type="text" id="txtestsubsubmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtsubsubnombe" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtsubsuburl" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdactisubsubmenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rddescsubsubmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" id="btngsubsubmenu" class="btn btn-primary btn-sm mb-3">Agregar</button>
                                </div>
                            </div>    
                        </form>
                            <div style="height:156px; overflow: scroll;">
                                <table id="subsubmenu" class="table table-borderless table-sm">
                                    <tbody id="tbdsubsubmenu">
                                    
                                    </tbody>
                                </table> 
                            </div>    
                        </div>
                    </div>
                </div>   
            </div>

       <!-- <div class="container-fluid">
            <ul id="tree">
            </ul>

        </div>-->
       
    </form>
        <script src="./js/jsconfiguracion.js"></script>
        <script src="./js/jsqueryThree.js"></script>
        <script>
            $('#tree').checktree();
    </script>
  
                        

</body>
</html>






 