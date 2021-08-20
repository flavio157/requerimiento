<?php
$fechaactual = getdate()
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="STYLESHEET" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/jsreclamo.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="main">
        <form class="row g-3"  id="frmreclamos">
            <div class="row g-2">
                <div class="col">
                   <div  style="background: #808080;"><center>LIBRO DE RECLAMACIONES</center></div>
                    <div class="input-group border">
                        <span class="input-group-text">FECHA</span>
                        <input type="text" id="txtdiareclamo" name="txtdiareclamo"  class="form-control text-center" value="<?php echo $fechaactual["mday"]?>">
                        <input type="text" id="txtmesreclamo" name="txtmesreclamo"  class="form-control text-center" value="<?php echo $fechaactual["mon"]?>">
                        <input type="text" id="txtanoreclamo" name="txtanoreclamo"  class="form-control text-center" value="<?php echo $fechaactual["year"]?>">
                    </div>
                </div>
                <div class="col border">
                    <center>HOJA DE RECLAMACIONES</center>    
                    <center> N<sup>ro  </sup><label id="nroreclamo"> </label> </center>      
                </div>
            </div>
            <div class="col-12 border">
                <div class="input-group mb-3" style="padding-top: 5px;">
                    <span class="input-group-text">RAZON SOCIAL</span>
                    <input type="text" class="form-control" aria-label="Username">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">DIRECCION</span>
                    <input type="text" class="form-control" aria-label="Server">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">RUC</span>
                    <input type="text" class="form-control" aria-label="Username">
                    <span class="input-group-text">IDENTIFICACION</span>
                    <input type="text" class="form-control" aria-label="Username">
                </div>
            </div>
            <div class="col-12 border">
                <div >
                   1. IDENTIFICACION DEL CONSUMIDOR RECLAMANTE
                </div> 
                
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">NOMBRE</span>
                        <input type="text" class="form-control" name="txtnombrecliente" id="txtnombrecliente">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">DOMICILIO</span>
                        <input type="text" class="form-control"  name="txtdomiciliocliente" id="domiciliocliente">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">DNI:</span>
                        <input type="text" class="form-control" id="txtdni" name="txtdni">
                        <span class="input-group-text">CEDULA:</span>
                        <input type="text" class="form-control" id="txtcedula" name="txtcedula">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">TELF</span>
                        <input type="text" class="form-control" id="txttelefono" name="txttelefono">
                        <span class="input-group-text">CORREO</span>
                        <input type="text" class="form-control" id="txtcorrreo" name="txtcorreo">
                    </div>   
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">PADRE O MADRE</span>
                        <input type="text" class="form-control" placeholder="SI ES MENOR DE EDAD" id="txtnompadres" name="txtnompadres">
                    </div>   
            </div>
            <div class="col-12 border">
                <div >
                    2. IDENTIFICACION DEL BIEN CONTRATADO
                </div> 
                <div class="input-group mb-3">
                    <span class="input-group-text">PRODUCTO</span>
                    <input type="text" class="form-control"  id="txtproducto" name="txtproducto">
                    <span class="input-group-text">SERVICIO</span>
                    <input type="text" class="form-control"  id=txtservcio name="txtservicio">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">MONTO RECLAMADO</span>
                    <input type="text" class="form-control"  name="txtmonto" id="txtmonto">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">DESCRIPCION</span>
                    <input type="text" class="form-control" name="txtdescripcion" name="txtdescripcion" aria-label="Username">
                </div>
            </div>
            
            <div class="col-12 border">
                <div class="input-group mb-3">
                    <label style="padding-right: 50px;"> 3.DETALLE DE LA RECLAMACION Y PEDIDO DEL CONSUMIDOR</label>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label" for="txtreclamo">RECLAMO<sup>1</sup></label>
                    <input class="form-check-input" type="radio" name="txtreclamo" id="txtreclamo" value="1" for="txtreclamo">
                    </div>
                    <div class="form-check form-check-inline">
                    <label class="form-check-label" for="txtqueja">QUEJA<sup>2</sup></label>
                    <input class="form-check-input" type="radio" name="txtqueja" id="txtqueja" value="2" for="txtqueja">
                    </div>
                </div>
                <div class="input-group">
                    <textarea class="form-control" name="txtdetalle" id="txtdetalle" placeholder="DETALLE"></textarea>
                </div>
            </div>
            <div class="col-12 border">
                <div class="row g-2">
                    <div class="col">
                        <textarea class="form-control" name="txtpedido" id="txtpedido" placeholder="PEDIDO"></textarea> 
                    </div>
                    <div class="col">
                        <textarea class="form-control" aria-label="With textarea"></textarea>
                        <center> <label>FIRMA DEL CONSUMIDOR</label> </center>      
                    </div>
                </div>
            </div>   

            <div class="col-12 border">
                <div>
                    4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR
                </div> 
                <div class="row g-2">
                    <div class="col">
                        <div class="input-group border">
                            <span class="input-group-text">FECHA RESPUESTA</span>
                            <input type="text" name="txtdiarespuesta" id="txtdiarespuesta" placeholder="DIA" class="form-control">
                            <input type="text" name="txtmesrespuesta" id="txtmesrespuesta" placeholder="MES" class="form-control">
                            <input type="text" name="txtanorespuesta" id="txtanorespuesta" placeholder="AÑO" class="form-control">
                        </div>
                    </div>    
                    <div class="col">
                        <textarea class="form-control" aria-label="With textarea"></textarea>
                        <center> <label>FIRMA DEL PROVEEDOR</label> </center>      
                    </div>
                </div>
            </div> 
            
            <div class="col-12 border">
                <div class="row g-2">
                    <div class="col" style="font-size: 13px;">
                        <center><sup>1</sup>RECLAMO: Disconformidad relacionada a los productos o servicios</center>    
                    </div>    
                    <div class="col" style="font-size: 13px;">
                        <center><sup>2</sup>QUEJA: Disconformidad no relacionada a los productos o servicios; o, 
                            malestares o  descontentos respecto a la atencion al publico.</center>
                               
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div style="font-size: 12px;">* La formularción del reclamo no impide acudir a otras vias de solución de controversias
                    ni es requisito previo para imponer una denuncia ante el INDECOPI.
                </div>
                <div style="font-size: 12px;">* El proveedor deberá dar respuesta al reclamo en un plazo no mayor a treinta (30) dias calendario,
                     pudiendo ampliar el plazo hasta por treinta (30) dias más, previa comunicación al consumidor.   
                </div>
            </div>

            <div class="col-12">
                <div class="row g-2">
                    <div class="col  text-center">
                        <button type="button" id="btnnuevo" class="btn btn-primary">NUEVO</button>
                    </div>
                    <div class="col  text-center">
                        <button type="button" id="btnguardar" class="btn btn-primary">GUARDAR</button>
                    </div>
                </div>
            </div>
        </form>       
    </div>

</body>
</html>