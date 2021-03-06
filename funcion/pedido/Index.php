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
      
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
        
    </head>
    <body>
    <div class="main">
        <form class="row g-3"  id="frmpedidos">
                <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
                <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
                <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
                <input type="text" id="vrcodcliente" style="display: none;"/>
                <div id="mensajesgenerales">
                                   
                </div>
                <div class="col-12">
                    <label for="formTipo" class="form-label">TIPO</label>
                    <select class="form-select" name="slcdocumento" id="slcdocumento" aria-label="Default select example">
                        <option selected>TIPO DE DOCUMENTO</option>
                        <option value="DNI">DNI</option>
                        <option value="RUC">RUC</option>                    
                    </select>
                </div>
                <div class="col-12">
                    <label for="formNumero" class="form-label">NUMERO</label>
                    <input type="number" class="form-control" name="txtnumero" id="txtnumero" >
                </div>
                <div class="col-12">
                    <label for="formcliente" class="form-label">CLIENTE</label>
                    <input type="text" class="form-control" name="txtcliente" id="txtcliente" >
                </div>
                <div class="col-12">
                    <label for="formciudad" class="form-label">CIUDAD</label>
                    <select class="form-select" name="slcciudad" aria-label="Default select example" id="Selectprovincia">
                        <option selected value="s">SELECCIONE</option>
                        
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdistrito" class="form-label">DISTRITO</label>
                    <select class="form-select" name="slcdistrito" aria-label="Default select example" id="Selectdistro">
                        <option selected value="">SELECCIONE</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdireccion" class="form-label">DIRECCI??N</label>
                    <input type="text" class="form-control" name="txtdireccion" id="txtdireccion" >
                </div>
                
                <div class="col-12">
                    <label for="formreferencia" class="form-label">REFERENCIA</label>
                    <input type="text" class="form-control" name="txtreferencia" id="txtreferencia" >
                </div>

                <div class="col-12">
                    <label for="formdescripcion" class="form-label">AGREGAR PEDIDO </label>
                    
                    <a id="DescrPedido" class="btn btn-primary mb-1 active" data-bs-toggle="modal" data-bs-target="#ModalProducto">
                            <i class="icon-circle-with-plus" title="Align Right"></i>
                    </a> 
                </div>
                <div class="table-responsive tablafrmpedidos" id="tablaproductos">
                    <table class="table tabladelProducto" id="tabladelProducto">
                        <caption>Lista de Productos</caption>
                        <thead>
                            <tr>
                                <th scope="col" style="display: none;">COD_PRODUCTO</th>
                                <th scope="col">PRODUCTO</th>
                                <th scope="col">CANTIDAD</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">PROMO</th>
                            </tr>
                        </thead>
                        <tbody  id="tabla">
                                                
                        </tbody>
                    </table>
                </div>

    
                <!-- -->

                <div class="col-12">
                    <label for="formcontacto" class="form-label">CONTACTO</label>
                    <input type="text" class="form-control" name="txtcontacto" id="txtcontacto" >
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formtelefono" class="form-label">TELEFONO</label>
                        <input type="number" class="form-control" name="txttelefono" id="txttelefono">
                    </div>
                    <div class="col">
                        <label for="formcondicion" class="form-label">CONDICI??N</label>
                        <select class="form-select" name="slccondicion" aria-label="Default select example" id="condicion">
                            <option selected value="n">Condicion</option>
                            <option value="0">Credito</option>
                            <option value="1">Contado</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">ENTREGA</label>
                        <select class="form-select" name="slcentrega" aria-label="Default select example" id="turno">
                            <option selected value="n">Seleccion Turno</option>
                            <option value="M">Ma??ana</option>
                            <option value="T">Tarde</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">F.PAGO</label>
                        <input type="date" name="dtfechapago" id="dtfechapago" value="<?php echo $fcha;?>"
                         class="form-control" min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));?>"
                         max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 30 days"));?>">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">N?? CONTRATO</label>
                        <input type="text" name="txtcontrato" id="txtcontrato" class="form-control">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">TELEFONO 2</label>
                        <input type="number" name="txtTelefono2" id="txtTelefono2" class="form-control" maxlength=9>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">CODIGO</label>
                        <input type="number" name="txtcodigo" id="txtcodigo" class="form-control">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">GENERADO</label>
                        <input type="text" name="txtgenereado" id="txtgenereado" class="form-control" disabled=true>
                       
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col text-center ">
                        <a class="btn btn-primary btn-lg active" id="grabar" >
                            <i class="icon-save" title="Align Right"></i>
                        </a>
                    </div>
                   

                        <div class="col text-center responsive">
                            <a class="btn btn-primary btn-lg active" id="verPedidos">
                                <i class="icon-eye" title="Align Right"></i>
                            </a>
                        </div>

                        <div class="col text-center noresposive">
                            <a class="btn btn-primary btn-lg active" id="verPedidos2">
                                <i class="icon-eye" title="Align Right"></i>
                            </a>  
                        </div>
                </div>
        </form>

        <?php include '../vista/Modal_IngresarProducto.php';?>
        <?php include '../vista/Modal_ListarPedidos.php';?>

        </div>
    </body>
</html>
<script type="text/javascript" src="../js/jsproductofinal.js"></script>
        <script type="text/javascript" src="../js/jsproductoprecio.js"></script>
