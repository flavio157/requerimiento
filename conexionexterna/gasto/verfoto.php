<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="STYLESHEET" type="text/css" href="../css/lupaimg.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script src="../js/lupaimg.js" type="text/javascript"></script>
        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
        <link rel="STYLESHEET" type="text/css" href="../css/bootstrap.min.css">
        <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
        <script  type="text/javascript" src="../js/jsformulario.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
    <title>Document</title>
</head>
<body >
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
                            <button data-toggle="modal" type="button" data-target="#staticBackdrop" class="btn btn-primary" id="btnbuscarimg">BUSCAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
     </form>                
</div> 


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
      <img id="imagenrp" class="imagenrp"  width="100%"></img>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>





</body>

</html>