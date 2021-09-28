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


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
    .main{
    width:40%;
    margin:0 auto;
    padding:1em;
    border-radius: 8px;
   }

    pre code {
        color: inherit;
        word-break: normal;
    }
    pre>code {
        border-radius: 0;
        display: block;
        padding: 1rem 1.5rem;
        white-space: pre;
    }

    code{
        background: #f4f5f6;
    }

    pre{
        border-left: 0.3rem solid #9b4dca;
    }

.container{
    padding: 0px;
}
  
#contentcanvas {
  position: relative;

}

#qr-shaded-region{
    margin-bottom: 5px;
}

@media screen and (max-width:992px){
        .main{
            width:100%;
            margin:0 auto;
            padding:1em;
            border-radius: 8px;
        }
        pre{
            border-left: 0.3rem solid #9b4dca;
        }
}
</style>
<body>
    <div class="main">
        <form>
            <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
            <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
            <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
            <div class="container" id="sourceSelectPanel">
            <label>SELECCIONE CAMARA DEL DISPOSITIVO</label>
                <select class="form-select  mb-3" id="sourceSelect" aria-label="Default select example">
                    <option selected>SELECCIONE CAMARA</option>
                </select>
                <label>RESULTADO</label>
                <pre><code id="result" style="font-size: 15px;"></code></pre>
                
                            
                <div id="contentcanvas">
                    <video  id="video" class="container">
                    </video> 
                </div>
            </div>    
        </form>
        <div class="table-responsive">
            <table id="tablacodebar" class="table table-striped">
                <thead>
                    <tr>
                        <td>
                            CODIGOS ESCANEADOS
                        </td>
                    </tr>
                </thead>
                <tbody id="tbbar">
                    
                </tbody>
            </table>         
        </div>
    </div>
    <div class="modal fade" id="mdbar" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MENSAJE EMERGENTE</h5>
                <button type="button" id="close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               ¿DESEA REVISAR LOS CODIGOS ESCANEADOS?
            </div>
            <div class="modal-footer">
            <button type="button" id="btaceptar" class="btn btn-secondary">CANCELAR</button>
                <button type="button" id="btcancelar" class="btn btn-primary" data-bs-dismiss="modal">ACEPTAR</button>
                
            </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/jszxing.js"></script>
<script type="text/javascript" src="../js/jsescaner.js"></script>
</html>

