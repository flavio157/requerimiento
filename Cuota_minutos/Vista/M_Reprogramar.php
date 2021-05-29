<div class="modal fade" id="modalPrueba" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Llamadas Pendientes</h5>
                    </div>
                    <div class="modal-body">
                            <label>Llamadas Pendientes</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkReprogra">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Reprogramar
                                </label>
                            </div>
                            <div class="col">
                                <label for="formfpago" class="form-label">Nueva Fecha</label>
                                <input type="date" name="dtfechapago" id="dtfechapago" value="<?php echo $fcha;?>"
                                class="form-control" min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));?>"
                                max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 30 days"));?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="closed" data-dismiss="modal">Cerrar</button>
                            </div>
                    </div>
            </div>
        </div>
    </div>