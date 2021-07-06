<?php
require_once("../funciones/m_empresas.php");

//date_default_timezone_set('America/Lima');
//$fecha=date("dmY");

$imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
$nom=$_GET['nombre'];

if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
//La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));

//Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
//todo el contenido lo guardamos en un archivo
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);

//Calcular un nombre único
//$nombreImagenGuardada = "foto_" . uniqid() . ".jpeg";
//$nombreImagenGuardada = '../ImagenGastos/'.$nom. ".png";

$hex = bin2hex($imagenDecodificada);
//Escribir el archivo
//file_put_contents($nombreImagenGuardada, $imagenDecodificada);
$hex = '0x'.$hex;
$estado = guardarfoto($nom,$hex);

function guardarfoto($nombre,$foto){
    
    //print_r($foto);
    $m_foto = new M_Empresas();
    $c_guardarfoto = $m_foto->m_guardarfoto($nombre,$foto); 
}


//Terminar y regresar el nombre de la foto
exit($nom);
?>

