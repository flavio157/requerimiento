  <!--modal para mostrar los pedidos ya registrados el dia actual responsive -->
  <div class="modal fade" id="ModalMostrarPedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pedidos Registrados</h5>
            </div>
            <div class="modal-body">
                <div class="accordion accordion-flush" id="acordionresponsive">
                </div>

                <div class="table-responsive " id="tbpedidosRegistrados">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">N° Contrato</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">DIRECCION</th>
                            </tr>
                        </thead>
                        <tbody id="tbmostrarpedidos">
                                            
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