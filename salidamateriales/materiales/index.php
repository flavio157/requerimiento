<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
	<link rel="STYLESHEET" type="text/css" href="../css/responsive.css">
    <script src="../js/jsformulario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="main">
        <form>
        <div id="mensajesgenerales">                           
        </div>
        <div class="row">
            <div class="col g-3">
               <center><label class="titulos">Registro de material de salida</label></center>
            </div>    
        </div>
        <div class="row">
            <div class="col g-4">
              <label class="titulos">Personal Solicitante</label>
            </div>    
        </div>
        <div class="row g-1">
            <div class="col-3">
                <input type="text" class="form-control" name="txtcodigoper" id="txtcodigoper" disabled>
            </div>
            <div class="col-7">
                <input type="text" class="form-control" name="txtnombrepersonal" id="txtnombrepersonal" disabled>
            </div>
            <div class="col-1">
        
                <a class="btn btn-primary active btn-block" data-bs-toggle="modal" data-bs-target="#mdpersonal">
                    <i class="icon-attachment" title="Alinear a la derecha"></i>
                </a>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-10">
                <label for="exampleFormControlTextarea1" class="form-label titulos">Descripción</label>
                <textarea class="form-control" id="txtdescripcion" rows="2"></textarea>
            </div>
        </div>



        <div class="row">
            <div class="col g-4">
              <label class="titulos">Material Solicitado</label>
            </div>    
        </div>
        <div class="row g-1">
            <div class="col-7">
            <input type="text" class="form-control" name="txtcodmaterial" id="txtcodmaterial" style="display: none;">
                <input type="text" class="form-control" name="txtmaterial" id="txtmaterial" placeholder="Material">
            </div>
            <div class="col-3">
                <input type="text" class="form-control" name="txtnroserie" id="txtnroserie" placeholder="Nro Serie">
            </div>
            <div class="col-1">
                <a class="btn  btn-primary active btn-block" id="aentrega">
                    <i class="icon-attachment" title="Alinear a la derecha"></i>
                </a>
            </div>
            <div id='material' class="sugerencias"></div>
        </div>  

        <div  class="row">
            <div class="col">
                <div class="col g-1 titulos materiales"><center>Material a entregar</center></div>    
                <div class="table-responsive">  
                    <table id="tbmaterialentrega" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="titulos">Material</th>
                                <th scope="col" class="titulos">Serie</th>
                                <th scope="col" style="display: none;">Descripcion</th>
                                <th scope="col" class="titulos">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tdmaterialentrega">
                        </tbody>
                    </table>
                </div>  
            </div> 
            <div class="col">  
                <div class="col g-1 titulos materiales"><center>Materiales a devolver</center>
                </div> 
                <div class="table-responsive">  
                    <table id="tbmaterialsalida" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="titulos">Material</th>
                                <th scope="col" class="titulos">Serie</th>
                                <th scope="col" class="titulos">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbmaterial">
                        </tbody>
                    </table>
                </div>     
            </div>     
        </div>


        <!--<div class="row">
            <div class="col g-4">
               <label class="titulos">Registre material a entregar</label>
            </div>    
        </div>
        
        <div class="row g-1">
            <div class="col-6">
                <input type="text" class="form-control" name="txtmatentrega" id="txtmatentrega" placeholder="Nombre" disabled>
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="txtnroserie" id="txtnroserie" placeholder="Nro Serie">
                <input type="text" class="form-control" name="txtcodmatentrega" id="txtcodmatentrega" style="display: none;">
            </div>
            <div class="col-2">
                <input type="number" class="form-control" name="txtcantmatentrega" id="txtcantmatentrega" placeholder="Cantidad">
            </div>
            <div class="col-1">
                <a class="btn btn-primary active btn-block" id="aentrega" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                    <i class="icon-attachment" title="Alinear a la derecha"></i>
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col g-4">
              <label class="titulos">Registre material de devolución</label>
            </div>    
        </div>
        <div class="row g-1">
            <div class="col-6">
                <input type="text" class="form-control" name="txtmatdevuelto" id="txtmatdevuelto" placeholder="Nombre"  disabled>
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="txtcodmatdevuelto" id="txtcodmatdevuelto" placeholder="Codigo" disabled>
            </div>
            <div class="col-2">
                <input type="number" class="form-control" name="txtcantdevuelto" id="txtcantdevuelto" placeholder="Cantidad">
            </div>
            <div class="col-1">
                <a class="btn btn-primary active btn-block" id="amdevuelto" data-bs-toggle="modal" data-bs-target="#mdmaterial">
                    <i class="icon-attachment" title="Alinear a la derecha"></i>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col g-3">
                <label for="Descripcion">Descripción</label>
                <textarea class="form-control" id="txtdescregistro" rows="3"></textarea>
            </div>
        </div>
       

        <div class="row ">
            <div class="col g-3">
               <label class="titulos">Agregar a la tabla</label>
            </div>
        </div>
        <div class="row">
            <div class="col g-4">
                    <a id="btnagregar" class="btn btn-primary active btn-block" style="float: right;">
                        <i class="icon-plus" title="Alinear a la derecha"></i>
                    </a>
            </div>  
        </div>
        <div class="row">
            <div class="col g-4 table-responsive" id="divcontentb">
                <table id="tbmaterialsalida" class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col" class="titulos">Solicitado</th>
                        <th scope="col" class="titulos">Serie</th>
                        <th scope="col" class="titulos">Devuelto</th>
                        <th scope="col" style="display: none;">Descripcion</th>
                        <th scope="col" class="titulos">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbmaterial">
                    </tbody>
                </table>
            </div>
        </div>-->

        
        <div class="row">
            <div class="col g-4">
                <button id="btnnuevo" type="button" class="btn btn-primary mb-2 pull-left"  >Nuevo</button>
            </div>
            <div class="col g-4">
                <button id="btnguardar" type="button" class="btn btn-primary mb-2"  style="float: right;">Guardar</button>
            </div> 
        </div> 
        </form>  

        <?php 
            include("../vista/modalpersonal.php");
            include("../vista/modalmaterial.php");
        ?>
    </div>
</body>
</html>