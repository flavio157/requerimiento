
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
                            AGREGAR PRODUCTO
                            <a id="agregarProducto" class="btn btn-primary mb-1 active">
                                <i class="icon-circle-with-plus" title="Align Right"></i>
                            </a>
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
                    <button id="aceptar"> aceptar</button>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" id="cerrarmodalProducto" class="btn btn-secondary active " data-dismiss="modal">Salir</button>
                <a id="agregar" class="btn btn-primary btn-lg active">
                  <i class="icon-add-to-list" title="Align Right"></i>
                </a>
                
            </div>
        </div>
    </div>
</div>
