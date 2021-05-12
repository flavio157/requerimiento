<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['zona'])){
    header('Location: index.php');
    exit;
} 
date_default_timezone_set('America/Lima');
$fcha = date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));
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
        
        <script type="text/javascript" src="../vista/js/jsproducto.js"></script>
        <script type="text/javascript" src="../vista/js/jsfuncionesProducto.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
        
    </head>
    <body>
    <div class="main">
        <form class="row g-3"  id="frmpedidos">
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
                    <label for="formdireccion" class="form-label">DIRECCIÓN</label>
                    <input type="text" class="form-control" name="txtdireccion" id="txtdireccion" >
                </div>
                
                <div class="col-12">
                    <label for="formreferencia" class="form-label">REFERENCIA</label>
                    <input type="text" class="form-control" name="txtreferencia" id="txtreferencia" >
                </div>

                <!-- cambie el campo descripcion del formulario original 
                por el modal de ingresar productos -->
                <div class="col-12">
                    <label for="formdescripcion" class="form-label">DESCRIPCIÓN DEL PEDIDO</label>
                    <button type="button" id="DescrPedido" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#ModalProducto">
                        +
                    </button>
                   <!-- <button type="button" id="btnModiDescr" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#ModalProductoModificar">
                        MODIFICAR
                    </button>-->
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
                            <th scope="col" style='display: none;'>TOTAL</th>
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
                    <input type="text" class="form-control" name="txtcontacto" id="txtcontacto" >
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formtelefono" class="form-label">TELEFONO</label>
                        <input type="number" class="form-control" name="txttelefono" id="txttelefono">
                    </div>
                    <div class="col">
                        <label for="formcondicion" class="form-label">CONDICIÓN</label>
                        <select class="form-select" name="slccondicion" aria-label="Default select example" id="condicion">
                            <option selected value="n">Condicion</option>
                            <option value="1">Credito</option>
                            <option value="2">Contado</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">ENTREGA</label>
                        <select class="form-select" name="slcentrega" aria-label="Default select example" id="turno">
                            <option selected value="n">Seleccion Turno</option>
                            <option value="M">Mañana</option>
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
                        <label for="formentrega" class="form-label">N° CONTRATO</label>
                        <input type="number" name="txtcontrato" id="txtcontrato" class="form-control">
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
                        <input type="text" name="txtgenereado" value="100061" class="form-control" disabled=true>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col text-center ">
                    <a class="btn btn-primary btn-lg" id="grabar" >
                        <i class="fas fa-file-alt" title="Align Right"></i>
                    </a>
                   
                         <!--<button type="button" id="grabar" class="btn btn-primary mb-3">Guardar
                        
                        </button>-->
                        </div>

                        <div class="col text-center responsive">
                            <a class="btn btn-primary btn-lg " id="verPedidos">
                                <i class="fas fa-file-alt" title="Align Right"></i>
                            </a>
                        </div>

                        <div class="col text-center noresposive">
                            <a class="btn btn-primary btn-lg " id="verPedidos2">
                                <i class="fas fa-file-alt" title="Align Right"></i>
                            </a>  
                        </div>

                    <div class="col text-center">
                        <a class="btn btn-primary btn-lg" id="nuevo" >
                            <i class="fas fa-file" title="Align Right"></i>
                        </a>
                        <!--<button type="button" id="nuevo" class="btn btn-primary mb-3">NUEVO</button>-->
                    </div>
                </div>
        </form>

                   <!-- Modal1 para ingresar el pedido de producto -->
                   <div class="modal fade " id="ModalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-x2">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabel">DESCRIPCION DEL PEDIDO</h6>
                            <button type="button"  id="closemodal" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frmagregarProducto">
                                  <div id="mensaje">
                                   
                                   </div>
                                <div class="col">
                                    <label for="formfpago" class="form-label">PRODUCTO</label>
                                    <input type="text" style="text-transform:uppercase" class="form-control" name="nombreproducto" id="nombreproducto" autocomplete="off">
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
                                        <label for="formcantidad" class="form-label">CANTIDAD</label>
                                        <input type="number" class="form-control"  name="G_cantidad" id="G_cantidad" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">PRECIO</label>
                                        <input type="number" class="form-control" name="precioproducto" id="precioproducto" disabled=true>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formpromocion" class="form-label">PROMOCION</label>
                                        <input type="number" class="form-control" name="G_promocion" autocomplete="off" id="G_promocion">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">TOTAL</label>
                                        <input type="number" class="form-control" id="G_total" name="G_total" disabled=true>
                                    </div>
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                        Lista de Productos
                                        <a id="agregarProducto" class="btn btn-primary btn-sm">+</a>
                                </div>

                                <div class="table-responsive tablafrmpedidos" id="tablaproductos">
                                    <table class="table  table-striped  table-sm productosMomento" id="productosMomento">
                                        <caption>Lista de Productos</caption>
                                        <thead>
                                            <tr>
                                            <th scope="col" style="display: none;">COD_PRODUCTO</th>
                                            <th scope="col">PRODUCTO</th>
                                            <th scope="col">CANTIDAD</th>
                                            <th scope="col">PRECIO</th>
                                            <th scope="col">PROMO</th>
                                            <th scope="col" style="display: none;">TOTAL</th>
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

                <!--modal para mostrar los pedidos ya registrados el dia actual responsive -->
                <div class="modal fade" id="ModalMostrarPedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Pedidos Registrados</h5>
                            </div>
                            <div class="modal-body">

                                <div class="accordion accordion-flush" id="acordionresponsive">
                                    
                                </div>


                                <div class="table-responsive " id="tbedidosRegistrados">
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First</th>
                                            <th scope="col">Last</th>
                                            <th scope="col">Handle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                            </tr>
                                            <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            </tr>
                                            <tr>
                                            <th scope="row">3</th>
                                            <td colspan="2">Larry the Bird</td>
                                            <td>@twitter</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>





                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cerrarmodal" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
    </body>
</html>
