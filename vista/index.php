<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <LINK REL=StyleSheet HREF="./css/responsive.css" TYPE="text/css" MEDIA=screen>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,user-scalable=no">
    </head>
    <body>
        <div class="main">
        <form method="POST" action="../controlador/C_login.php">
            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Usuario</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="nombre" aria-describedby="emailHelp">
            </div>
            <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">CLAVE</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="clave">
            </div>
            <div class="col text-center">
                <button class="btn btn-primary" type="submit">Aceptar</button>
            </div>
        </form>

        </div>
    </body>
</html>
