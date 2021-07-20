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

  <title>ZXing TypeScript | Decoding from camera stream</title>
  <script type="text/javascript" src="../js/jquery-3.3.1.slim.min.js"></script>
   <script type="text/javascript" src="../js/jquery.min.js"></script>
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/normalize.css@8.0.0/normalize.css">
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/milligram@1.3.0/dist/milligram.min.css">
</head>

<body>
  <form>
      <input type="text" id="vroficina" style="display: none;" value="<?php echo $ofi?>"/>
      <input type="text" id="vrzona" style="display: none;" value="<?php echo  $zon?>"/>
      <input type="text" id="vrcodpersonal" style="display: none;" value="<?php echo  $cod?>"/>
    <main class="wrapper" style="padding-top:2em">

      <section class="container" id="demo-content">
        <div>
       <!-- <a class="button" id="startButton">Start</a>
         <a class="button" id="resetButton">Reset</a>-->
        </div>

        <div id="sourceSelectPanel" style="display:none">
          <label for="sourceSelect">Camaras del Dispositivo</label>
          <select id="sourceSelect" style="max-width:400px">
          </select>
        </div>
        
        <div>
          <video id="video" width="490" height="500" style="border: 1px solid;padding: 6px;width: 100%;"></video>
        </div>
        <label>Result:</label>
        <pre><code id="result"></code></pre>
      </section>
      <canvas id="videoCanvas"></canvas>
      

    </main>
  </form>
  <!--<script type="text/javascript" src="https://unpkg.com/@zxing/library@0.18.3-dev.7656630/umd/index.js"></script>
-->
<script type="text/javascript" src="../js/jszxing.js"></script>
<!--<script type="text/javascript" src="../js/zxing.js"></script>-->
<script type="text/javascript" src="../js/jsescaner.js"></script>
</body>

</html>
