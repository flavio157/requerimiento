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


<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="ZXing for JS">

  <title>Lector de Codigo de barras</title>
  <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
   <script type="text/javascript" src="../js/jquery.min.js"></script>
   <link REL=StyleSheet HREF="../css/responsive.css" TYPE="text/css" MEDIA=screen>
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/normalize.css@8.0.0/normalize.css">
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/milligram@1.3.0/dist/milligram.min.css">
</head>
<style>
  #contentcanvas{
   
    position: relative;

  }

</style>


<body>
  <div >
    <form>
        <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
        <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
        <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
      <main class="wrapper" style="padding-top:2em;width: 500px;min-height: 500px"> 

        <section class="container" id="demo-content">
          <div id="sourceSelectPanel" style="display:none">
            <label for="sourceSelect">Camaras del Dispositivo</label>
            <select id="sourceSelect" style="max-width:400px">
            </select>
          </div>
          
          <div id="contentcanvas" style="width:500px">
        <!-- <canvas id="videoCanvas" width="600" height="300"></canvas>-->
            <video class="dstImg" id="video"  style="width: 100%;"></video>
          
          </div>
          <label>Resultado:</label>
          <pre><code id="result"></code></pre>
        
        </section>
      
     
    

      </main>
    </form>
  </div>

 
  <!--top:50px;left: 50px;-->
  <!--<script type="text/javascript" src="https://unpkg.com/@zxing/library@0.18.3-dev.7656630/umd/index.js"></script>
-->

<script type="text/javascript" src="../js/jszxing.js"></script>
<!--<script type="text/javascript" src="../js/jslienzo.js"></script>-->
<script type="text/javascript" src="../js/jsescaner.js"></script>
</body>

</html>
