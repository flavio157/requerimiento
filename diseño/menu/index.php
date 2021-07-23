<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
  }
  
$menu = $_SESSION["menu"];
$submenu = $_SESSION["submenu"];
$ofi = $_SESSION["ofi"];
$zon = $_SESSION["zon"];
$cod = $_SESSION["cod"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Menu</title>
	
	<link rel="stylesheet" href="../css/menu.css">
	<link rel="stylesheet" href="../fonts/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script src="../js/menu.js"></script>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>	

<header>		
		<div class="menu_barras">
			<div class="div-menu">
				<a href="#" class="bt-menu"><span class="icon-menu"></a>
			</div>
		</div>
		<nav>
			<ul>
				<?php 
					for ($i=0; $i < count($menu); $i++) { 
						if($menu[$i][2] == ''){
							echo "<li class='menupadre' id='$i'><a><span class='icon-house'></span>".$menu[$i][1]."</a>";
							echo "<ul class='children'>";
							for ($l=0; $l < count($submenu) ; $l++) { 
								if($menu[$i][0] == $submenu[$l][0]){
									echo "<li><a href='".$submenu[$l][2]."' class='url'>".$submenu[$l][1]."<span class='icon-dot'></span></a>
									</li>";
								}	
							}
							echo "</ul>";
							echo "</li>";	
						}else{
							echo "<li class='menupadre' id='$i'>
							<a href='".$menu[$i][2]."' class='url'><span class='icon-house'></span>".$menu[$i][1]."</a>";
							echo "</li>";	
						}
							
					}
				
				?>
			</ul>
		</nav>
	</header>
	<div id="central">
	

	</div>
	<?php
	/*	for ($i=0; $i < count($menu); $i++) { 
			echo "<li class='submenu' id='$i'><a><span class='icon-house'></span>".$menu[$i][1]."</a>";
			for ($l=0; $l < count($submenu) ; $l++) { 
				if($menu[$i][0] == $submenu[$l][0]){
					echo	"<ul class='children'>";
					echo		"<li><a href='".$submenu[$l][2]."'>".$submenu[$l][1]."<span class='icon-dot'></span></a></li>";
					echo	"</ul>";
				}	
			}
			"</li>";		
		}*/	

		
	/*function printe($array){
		echo('<pre>');
		print_r($array);
		echo('</pre>');
	}*/


	?>
	<!--
		<ul class='children'>
			<li><a href='../vista/vistaprueba.php'>SubElemento #1 <span class='icon-dot'></span></a></li>
		</ul>
	-->
</body>