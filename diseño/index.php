<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/jsprueba.js"></script>
    <link rel=StyleSheet href="./css/styles.css" type="text/css" media=screen>
    <title>Login</title>
</head>
<body>

<div class="container"  style="margin-top: 46px;">
    <div id="mensajesgenerales" style="max-width: 350px;margin: 0 auto 25px;">
                                                
    </div>
    <!--<h1 class="welcome text-center">Bienvenido a  <br>"Nombre"</h1>-->
        <div class="card card-container ">
           
            <form class="form-signin" >
                <span id="reauth-email" class="reauth-email"></span>
                <p class="input_title">USUARIO</p>
                <input type="text" id="usuario" name="susuario" class="form-control login_box" autofocus>
                <p class="input_title">CONTRASEÑA</p>
                <input type="password" id="inputPassword" class="form-control login_box" >
                <div id="remember" class="checkbox">
                    <p class="input_title">PLATAFORMA</p>
                    <select class="form-select login_box" aria-label="Default select example">
                        <option selected>SELECCIONE</option>
                        <option value="1">SISTEMA 1</option>
                        <option value="2">SISTEMA 2</option>
                        <option value="3">SISTEMA 3</option>
                    </select>
                </div>
                <button class="btn btn-lg btn-primary" id='prueba'>Aceptar</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
    
</body>
</html>