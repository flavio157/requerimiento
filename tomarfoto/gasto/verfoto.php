<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" media="screen">
        <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/jquery-mousewheel@3.1.13"></script>
        <script type="text/javascript" src="../js/hammer.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/jquery-hammerjs@2.0.0"></script>
        <script  type="text/javascript" src="../js/imgViewer.js"></script>
        <script  type="text/javascript" src="../js/imgNotes.js"></script>
        
        
	

        <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
        <link rel="STYLESHEET" type="text/css" href="../fonts/style.css">
        <link rel="STYLESHEET" type="text/css" href="../css/bootstrap.min.css">
        <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
        <script  type="text/javascript" src="../js/jsformulario.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />

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

               
             
                 
                </form>                
</div> 


<div class="contenedor-img">
    <img id="imagen" class="img-thumbnail noresponsive img-fluid"  width="100%"></img>
</div>

<img id="imagenrp" class="img-thumbnail  responsi"  width="100%" ></img>
</body>
</html>

