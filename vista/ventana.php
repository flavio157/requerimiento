<?php
/*if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['cod_vendedora'];
}*/
require_once("../controlador/C_Cuotas.php");
$m_cuota = new C_Controlar_Cuotas();
$estado = $_GET['enlace'];
if($estado == 0){
    $cantidad = $_GET['cantidad'];
}
/*if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit;
} */
?>

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <LINK REL=StyleSheet HREF="./css/responsive.css" TYPE="text/css" MEDIA=screen>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        
        
        <!--<script type="text/javascript" src="../vista/js/scripts.js"></script>-->
        <script type="text/javascript" src="../vista/js/jsproducto.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
        
    </head>
    <body>
    <div class="main">
        <form class="row g-3"  id="frmpedidos">
        
        <?php
                if($estado === "0"){
                    echo  '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Advertencia</strong> Todavia no alcanza la cuota esperada.'.'
                    Actualmente Usted esta en '. $cantidad .'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
           
              ?>
                <div class="col-12">
                    <label for="formTipo" class="form-label">TIPO</label>
                    <select class="form-select" name="slcdocumento" aria-label="Default select example">
                        <option selected>TIPO DE DOCUMENTO</option>
                        <option value="1">DNI</option>
                        <option value="2">RUC</option>                    
                    </select>
                </div>
                <div class="col-12">
                    <label for="formNumero" class="form-label">NUMERO</label>
                    <input type="text" class="form-control" name="txtnumero" id="formnumero" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formcliente" class="form-label">CLIENTE</label>
                    <input type="text" class="form-control" name="txtcliente" id="formcliente" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formciudad" class="form-label">CIUDAD</label>
                    <select class="form-select" name="slcciudad" aria-label="Default select example" id="Selectprovincia">
                        <option selected>SELECCIONE</option>
                        
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdistrito" class="form-label">DISTRITO</label>
                    <select class="form-select" name="slcdistrito" aria-label="Default select example" id="Selectdistro">
                        <option selected value="">SELECCIONE</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdireccion" class="form-label">DIRECCIÓN</label>
                    <input type="text" class="form-control" name="txtdireccion" id="formdireccion" placeholder="Another input placeholder">
                </div>
                
                <div class="col-12">
                    <label for="formreferencia" class="form-label">REFERENCIA</label>
                    <input type="text" class="form-control" name="txtreferencia" id="formreferencia" placeholder="Another input placeholder">
                </div>

                <!-- cambie el campo descripcion del formulario original 
                por el modal de ingresar productos -->
                <div class="col-12">
                    <label for="formdescripcion" class="form-label">DESCRIPCIÓN DEL PEDIDO</label>
                    <button type="button" id="DescrPedido" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#ModalProducto">
                        INGRESAR
                    </button>
                   <!-- <button type="button" id="btnModiDescr" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#ModalProductoModificar">
                        MODIFICAR
                    </button>-->
                </div>
                <div class="table-responsive" id="tablaproductos">
                    <table class="table" id="tabladelProducto">
                        <caption>Lista de Productos</caption>
                        <thead>
                            <tr>
                            <th scope="col" style="display: none;">COD_PRODUCTO</th>
                            <th scope="col">PRODUCTO</th>
                            <th scope="col">CANTIDAD</th>
                            <th scope="col">PRECIO</th>
                            <th scope="col">PROMOCIÓN</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody  id="tabla">
                                                
                        </tbody>
                    </table>
                </div>
                <!-- -->

                <div class="col-12">
                    <label for="formcontacto" class="form-label">CONTACTO</label>
                    <input type="text" class="form-control" name="txtcontacto" id="formGroupExampleInput2" placeholder="Another input placeholder">
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formtelefono" class="form-label">TELEFONO</label>
                        <input type="text" class="form-control" name="txttelefono" placeholder="First name" >
                    </div>
                    <div class="col">
                        <label for="formcondicion" class="form-label">CONDICIÓN</label>
                        <select class="form-select" name="slccondicion" aria-label="Default select example">
                            <option selected>Condicion</option>
                            <option value="1">Credito</option>
                            <option value="2">Contado</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">ENTREGA</label>
                        <select class="form-select" name="slcentrega" aria-label="Default select example">
                            <option selected>Seleccion Turno</option>
                            <option value="1">Mañana</option>
                            <option value="2">Tarde</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">F.PAGO</label>
                        <input type="date" name="dtfechapago" id="dtfechapago" class="form-control">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">N° CONTRATO</label>
                        <input type="text" name="txtcontrato" class="form-control" placeholder="First name">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">TELEFONO 2</label>
                        <input type="text" name="txtTelefono2" class="form-control">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">CODIGO</label>
                        <input type="text" name="txtcodigo" class="form-control">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">GENERADO</label>
                        <input type="text" name="txtgenereado" value="100061" class="form-control" disabled=true>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col text-center ">
                        <button type="button" id="grabar" class="btn btn-primary mb-3">GRABAR</button>
                    </div>
                    <div class="col text-center">
                        <button type="button" id="nuevo" class="btn btn-primary mb-3">NUEVO</button>
                    </div>
                </div>
        </form>

                   <!-- Modal1 para ingresar el pedido de producto -->
                   <div class="modal fade " id="ModalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-x2">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabel">DESCRIPCION DEL PEDIDO</h6>
                            <button type="button" id="closemodal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frmagregarProducto">
                                  <div id="mensaje">
                                   
                                   </div>
                                <div class="col">
                                    <label for="formfpago" class="form-label">PRODUCTO</label>
                                    <input type="text" class="form-control" name="nombreproducto" id="nombreproducto" autocomplete="off">
                                </div>
                                <div id="sugerencias"></div>
                                
                               
                                <div class="row g-2">
                                    <div class="col">
                                        <label  for="formentrega" class="form-label">COD. PRODUCTO</label>
                                        <input type="text" class="form-control"  id="cod_producto"  disabled=true>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">CANTIDAD</label>
                                        <input type="text" class="form-control"  name="G_cantidad" id="G_cantidad" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">PRECIO</label>
                                        <input type="text" class="form-control" name="precioproducto" id="precioproducto" disabled=true>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">PROMOCION</label>
                                        <input type="text" class="form-control" name="G_promocion" autocomplete="off" id="G_promocion">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">TOTAL</label>
                                        <input type="text" class="form-control" id="G_total" name="G_total" disabled=true>
                                    </div>
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                        Lista de Productos
                                        <a id="agregarProdcuto" class="btn btn-primary btn-sm">+</a>
                                </div>

                                <div class="table-responsive" id="tablaproductos">
                                    <table class="table  table-striped  table-sm" id="productosMomento">
                                        <caption>Lista de Productos</caption>
                                        <thead>
                                            <tr>
                                            <th scope="col" style="display: none;">COD_PRODUCTO</th>
                                            <th scope="col">PRODUCTO</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">PRECIO</th>
                                            <th scope="col">PROMOCIÓN</th>
                                            <th scope="col">TOTAL</th>
                                            <th scope="col">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="tablaModal">
                                                                
                                        </tbody>
                                    </table>
                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="agregar">Agregar</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  -->




                <!-- Modal2 para modificar el pedido del producto -->
                <div class="modal fade " id="ModalProductoModificar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-x2">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabel">DESCRIPCION DEL PEDIDO</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frmactualizarproducto">
                                    <div id="mensaje2">
                                   
                                    </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label  for="formentrega" class="form-label">COD. PRODUCTO</label>
                                        <input type="text" class="form-control" id="M_cod_producto" >
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">PRODUCTO</label>
                                        <input type="text" class="form-control" name="M_Nombreproducto" id="M_Nombreproducto" disabled=true>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">CANTIDAD</label>
                                        <input type="text" class="form-control" name="M_cantidad" id="M_cantidad">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">PRECIO</label>
                                        <input type="text" class="form-control" name="M_precioproducto" id="M_precioproducto" disabled=true>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">PROMOCION</label>
                                        <input type="text" class="form-control" name="M_promocion" id="M_promocion">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">TOTAL</label>
                                        <input type="text" class="form-control" id="M_total" name="M_total" disabled=true>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="M_modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="M_agregar">Agregar</button>
                        </div>
                        </div>
                    </div>
                </div>
                <!--  -->



        </div>
    </body>
</html>
