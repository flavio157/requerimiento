<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    
    <script src="../js/jsmolde.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
    <link rel="STYLESHEET" type="text/css" href="../css/responsive.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        <title>Moldes</title>
   </header>
   <section>  
        <div class="main"> 
            <form>
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <div class="row">
                    <div class="col g-3">
                    <center><label class="titulos">Registro Fabricacion de molde</label></center>
                    </div>    
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-4 g-4" style="padding-right: 6px;">
                            <input type="date" class="form-control">
                        </div> 
                        <div class="col-4 g-4" style="padding-left: 0px;">
                            <input type="date" class="form-control">
                        </div>
                    </div> 
                </div>



                <div class="row">
                    <div class="col g-4">
                        <label class="thtitulo">Datos de Molde</label>
                    </div>    
                </div>  

                <div class="mb-3">
                    <div class="row">
                        <div class="col-4 g-4" style="padding-right: 6px;">
                            <input type="text" class="form-control" name="txtcodpermolde" id="txtcodpermolde" disabled>
                        </div> 
                        <div class="col-8 g-4" style="padding-left: 0px;">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="txtpersonalmolde" placeholder="Buscar Nombre Molde">
                                <a class="btn btn-success">
                                    <i class="icon-shopping-basket" title="agregar derecha"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div  class="row">
                <div class="col">
                    <div class="col g-1 titulos materiales"><center>Material Necesario</center></div>    
                    <div class="table-responsive">  
                        <table id="tbmaterialentrega" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">Material</th>
                                    <th class="thtitulo" scope="col">Serie</th>
                                    <th class="thtitulo" scope="col">cantidad</th>
                                    <th class="thtitulo" scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody id="tdmaterialentrega">
                            </tbody>
                        </table>
                    </div>  
                    </div>     
                </div>   

                <div class="row">
                    <div class="col g-4">
                        <label class="thtitulo">Personal Involucrado</label>
                    </div>    
                </div>  
                <div class="mb-3">
                    <div class="row">
                        <div class="col-4 g-4" style="padding-right: 6px;">
                            <input type="text" class="form-control" name="txtcodpermolde" id="txtcodpermolde" disabled>
                        </div> 
                        <div class="col-8 g-4" style="padding-left: 0px;">
                            <div class="input-group mb-3">
                                <!--<a class="btn btn-success">
                                    <i class="icon-users" title="Registrar Nuevo Personal"></i>
                                </a>-->
                                <input type="text" class="form-control" id="txtpersonalmolde" placeholder="Buscar Personal">
                                <a class="btn btn-success" id="addpersonal">
                                    <i class="icon-add-user" title="agregar derecha"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Descripci??n</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <!--<div class="row">
                    <div class="col g-4">
                        <label class="thtitulo">Material Solicitado</label>
                    </div>    
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-7 g-4" style="padding-right: 6px;">
                            <input type="text" class="form-control" name="txtcodigoper" id="txtcodigoper">
                        </div> 

                        <div class="col-5 g-4" style="padding-left: 0px;">
                            <div class="input-group mb-3" >
                                <input type="text" class="form-control" placeholder="Nro Serie">
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                                    <i class="icon-plus" title="Alinear a la derecha"></i>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="row">
                        <div class="col-4" style="padding-right: 0px;">
                            <label for="exampleFormControlTextarea1" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" placeholder="First name" aria-label="First name">
                        </div>
                        <div class="col-4" style="padding-left: 6px;">
                            <label for="exampleFormControlTextarea1" class="form-label">Stock</label>
                            <input type="text" class="form-control" id="stock">
                        </div>
                </div>-->

                <div  class="row">
                   <!-- <div class="col">
                        <div class="col g-1 titulos materiales"><center>Material Necesario</center></div>    
                        <div class="table-responsive">  
                            <table id="tbmaterialentrega" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">Material</th>
                                        <th class="thtitulo" scope="col">Serie</th>
                                        <th class="thtitulo" scope="col">cantidad</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tdmaterialentrega">
                                </tbody>
                            </table>
                        </div>  
                    </div> -->
                    <div class="col">  
                        <div class="col g-1 titulos materiales"><center>Personal Encargados</center>
                        </div> 
                        <div class="table-responsive">  
                            <table id="tbpersonalmolde" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="thtitulo" scope="col">Nombre del Personal</th>
                                        <th class="thtitulo" scope="col">Descripci??n</th>
                                        <th class="thtitulo" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdpersonalmolde">
                                </tbody>
                            </table>
                        </div>     
                    </div> 
                </div>
                <div class="row">
                    <div class="col g-4">
                        <button  type="button" class="btn btn-primary mb-2 pull-left">
                                <i class="icon-eraser" title="Limpiar Formulario"></i>
                            Nuevo
                        </button>
                    </div>
                    <div class="col g-4">
                        <button  type="button" class="btn btn-primary mb-2"  style="float: right;">
                        <i class="icon-save" title="Guardar datos"></i>
                        Guardar
                        </button>
                    </div> 
                </div> 
            </form>  
        </div>     
    </section>
</body>
</html>