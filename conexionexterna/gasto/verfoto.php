<!DOCTYPE html>
<html lang="en">
<head>
        <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
        <link rel="STYLESHEET" type="text/css" href="../css/bootstrap.min.css">
        <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
        <script  type="text/javascript" src="../js/jsformulario.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">

    <title>Document</title>
</head>
<body>
    <div class="divtitulo">
         <h5><label for="formdescripcion" class="form-label">BUSCAR IMAGEN</label></h5>
    </div>
<div class="mostrarimg">
        <form>
                <div class="contenedortxt">
                    <div class="mb-3 contenerdortxtbuscar">
                        <input type="text" name="txtbuscarfoto" id="txtbuscarfoto" class="form-control" placeholder="número de contrato">
                    </div>
                    <div class="contenedorboton">
                        <div class="mb-3">
                            <div class="gap-2 divbtn col-6 mx-auto">
                                    <div class="col divbtnmostrar">
                                        <button class="btn btn-primary" id="btnbuscarimg">BUSCAR</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>    

                <div class="contenerdoimg">
                        <div class="table-responsive tablafrmpedidos">
                            <img id="imgElem" class="img-thumbnail"></img>
                        </div>
                </div>

                </form>                
</div> 
</body>
</html>