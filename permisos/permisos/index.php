<?php
   // require_once(".././menu/index.php");
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
<script src="../js/bootstrap5.bundel.min.js"></script>
<script src="../js/sweetalert2@11.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0/css/bootstrap.min.css">
<form id="frmpermisos">
<center style="padding-top: 1em;"><label>PERMISOS</label></center>
    <div class="main">
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
                       
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" id="txtidmenu2" style="display: none;">   
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
                      
                            <div class="row g-3">
                                <div class="col mb-3">
                                    
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

    <div class="modal fade" id="mdmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text"  id="txtmdidmenu" style="display: none;">
                                    <input type="text"  id="txtmdestmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtmdnommenu" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtmdurlmenu" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmdactimenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmddescmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                                </div>
                            </div>    
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cerrar</button>
                    <button type="button" id="btnmdgmenus" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="mdsubmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                        <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" id="txtmdidmenu2" style="display: none;"> 
                                    <input type="text" id="txtmdidsubmenu" style="display: none;">   
                                    <input type="text" id="txtmdestsubmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtmdnomsubmenu" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtmdurlsubmenu" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmdactisubmenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmddescsubmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                                </div>
                            </div>    
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cerrar</button>
                    <button type="button" id="btnmdgsubmenu" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="mdsubsubmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                 
                        <div class="row g-3">
                            <div class="col mb-3">
                                    <input type="text"  id="txtmdidmenu3" style="display: none;">
                                    <input type="text"  id="txtmdsubidmenu2" style="display: none;">
                                    <input type="text" id="txtmdidsubsubmenu" style="display: none;">   
                                    <input type="text" id="txtmdestsubsubmenu" style="display: none;">
                                    <input type="text" class="form-control form-control-sm" id="txtmdsubsubnombe" placeholder="Nombre del menu">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtmdsubsuburl" placeholder="url">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmdactisubsubmenu" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="rdmddescsubsubmenu" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Desactivo</label>
                                    </div>
                            </div>
                        </div>    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cerrar</button>
                    <button type="button" id="btnmdgsubsubmenu" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="./js/jsconfiguracion.js"></script>
    <script src="./js/jsqueryThree.js"></script>
    <script>
            $('#tree').checktree();
    </script>
</body>
</html>






 