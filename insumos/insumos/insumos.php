<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <script src="../js/jsformulario.js" ></script>
    <LINK REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><h4>Control de Insumos</h4></center>
    <div class="main">
        <form class="row">
            <div class="col-auto"><!--datetime-local-->
                <label>Fecha inicio</label>
            </div>
            <div class="col-auto"><!--datetime-local-->
                <input id="fech_ini" class="form-control" type="date">
            </div>
            <div class="col-auto"><!--datetime-local-->
                <label>Fecha final</label>
            </div>
            <div class="col-auto">
                 <input id="fech_fin" class="form-control" type="date">
            </div>
            <div class="col-auto">
                <button type="button"  id="btnfiltrar" class="btn btn-primary mb-3">confirmar</button>
            </div>
        </form>
        <div class="table-responsive tbinsumo">
            <table id="tbinsumo" class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">salida</th>
                <th scope="col">Ingreso</th>
                <th scope="col">Total</th> 
                </tr>
            </thead>
            <tbody id="tdinsumo">

            </tbody>
            </table>
        </div>   
    </div>
</div>
</div>   
</body>
</html>