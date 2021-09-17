<!DOCTYPE html>
<html>
<head>
 
<meta>

    <script type="text/javascript" src="./js/jquery-3.3.1.slim.min.js"></script>
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <LINK REL=StyleSheet HREF="./css/responsive.css" TYPE="text/css" MEDIA=screen>
 
        <link rel="STYLESHEET" type="text/css" href="./css/bootstrap.min.css">
        <script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="./js/jsformulario.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
    <title>Document</title>
    </head>
    <body>
        <div class="main">
        <form>
                <table class="table ">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                    <th scope="col">ver</th>
                    </tr>
                </thead>
                <tbody id="tbmaterial">
                </tbody>
                </table>
           
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">codigo Producto</label>
            <input type="text" class="form-control" id="codproducto" aria-describedby="emailHelp">
            
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Numero lote</label>
            <input type="text" class="form-control" id="numlote">
        </div>  
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">alamcen</label>
            <input type="text" class="form-control" id="almacen" aria-describedby="emailHelp">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        </form>
       
    </body>
</html>


