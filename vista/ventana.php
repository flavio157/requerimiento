<?php
session_start();
require_once("../controlador/C_Cuotas.php");
$m_cuota = new C_Controlar_Cuotas();
$estado = $m_cuota->boolean;

if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit;
} else {
    // Show users the page!
}
?>

<html>
    <head>
       
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <LINK REL=StyleSheet HREF="./css/responsive.css" TYPE="text/css" MEDIA=screen>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
        
    </head>
    <body>
    <div class="main">
        <form class="row g-3" >
              <?php

                if($estado){
                    echo  '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Advertencia</strong> Todavia no alcanza la cuota esperada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
              ?>
                <div class="col-12">
                    <label for="formTipo" class="form-label">TIPO</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>TIPO DE DOCUMENTO</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="formNumero" class="form-label">NUMERO</label>
                    <input type="text" class="form-control" id="formnumero" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formcliente" class="form-label">CLIENTE</label>
                    <input type="text" class="form-control" id="formcliente" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formciudad" class="form-label">CIUDAD</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdistrito" class="form-label">DISTRITO</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="formdireccion" class="form-label">DIRECCIÓN</label>
                    <input type="text" class="form-control" id="formdireccion" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formreferencia" class="form-label">REFERENCIA</label>
                    <input type="text" class="form-control" id="formreferencia" placeholder="Another input placeholder">
                </div>
                <div class="col-12">
                    <label for="formdescripcion" class="form-label">DESCRIPCIÓN DEL PEDIDO</label>
                         <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        INGRESAR
                    </button>
                </div>
                <div class="col-12">
                    <label for="formcontacto" class="form-label">CONTACTO</label>
                    <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder">
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formtelefono" class="form-label">TELEFONO</label>
                        <input type="text" class="form-control" placeholder="First name" >
                    </div>
                    <div class="col">
                        <label for="formcondicion" class="form-label">CONDICIÓN</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">ENTREGA</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">F.PAGO</label>
                        <input type="date" class="form-control">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">N° CONTRATO</label>
                        <input type="text" class="form-control" placeholder="First name">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">TELEFONO 2</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col">
                        <label for="formentrega" class="form-label">CODIGO</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col">
                        <label for="formfpago" class="form-label">GENERADO</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col text-center ">
                        <button type="submit" class="btn btn-primary mb-3">GRABAR</button>
                    </div>
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary mb-3">NUEVO</button>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-x2">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabel">DESCRIPCION DEL PEDIDO</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">COD. PRODUCTO</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">PRODUCTO</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col">
                                        <label for="formentrega" class="form-label">PROMOCION</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="formfpago" class="form-label">TOTAL</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </form>
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div>
        </form>
        </div>
    </body>
</html>