<?php
function kh_getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        return $ip;
}

function f_retornar(){
$reg='<div align=center><font size=16><a href="../index.php">Regresar</a></font></div>';
echo $reg;
}

function f_regSession($anexo,$codusuario,$nombre,$oficina,$zona){
  session_start();
  $_SESSION["ane"]=$anexo;
  $_SESSION["cod"]=$codusuario;
  $_SESSION["usu"]=$nombre;
  $_SESSION["ofi"]=$oficina;
  $_SESSION["zon"]=$zona;
}
function f_DesSession(){
session_start();
unset($_SESSION["ane"]); 
unset($_SESSION["cod"]);
unset($_SESSION["usu"]);
unset($_SESSION["ofi"]);
unset($_SESSION["zon"]);
session_destroy();
}

function generarCodigo($longitud, $tipo=0) {
/**
 * Funcion para generar valores aleatorios
 * Tiene que recibir la longitud de la cadena
 * Puede recibir el tipo de codigo a devolver:
 *  1 minusculas
 *  2 mayusculas
 *  3 mayusculas y minuculas
 *  4 numeros y letras
 */

    $codigo = "";
    if($tipo==1)
        $caracteres="abcdefghijklmnopqrstuvwxyz";
    elseif($tipo==2)
        $caracteres="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    elseif($tipo==3)
        $caracteres="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    elseif($tipo==4)
        $caracteres="0123456789";
    else
        $caracteres="abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    $max=strlen($caracteres)-2;
    for($i=0;$i < $longitud;$i++)
    {
        $codigo.=$caracteres[mt_rand(0,$max)];
    }
    return $codigo;
}

function completarcontrato($contrato){
$res = str_pad($contrato, 8, '0', STR_PAD_LEFT);
return $res;
}

function returnMacAddress() {
$location = 'which arp';
$arpTable = '$location';
$arpSplitted = split("\\n",$arpTable);
$remoteIp = $GLOBALS['REMOTE_ADDR'];
foreach ($arpSplitted as $value) {
       $valueSplitted = split(" ",$value);
       foreach ($valueSplitted as $spLine) {
           if (preg_match("/$remoteIp/",$spLine)) {
               $ipFound = true;
           }
if ($ipFound) {
         reset($valueSplitted);
      foreach ($valueSplitted as $spLine) {
          if (preg_match("/[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f][:-]".
                  "[0-9a-f][0-9a-f][:-]".
                  "[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f]/i",$spLine)) {
              return $spLine;
             }
          }
     }
      $ipFound = false;
      }
     }
       return false;
    }


function retunrFechaSql($fecha){
 $dia1=substr($fecha, 0, 2);
 $mes1=substr($fecha, 3, 2);
 $ano1=substr($fecha, 6, 4);
 $fechasql=$ano1.$mes1.$dia1;
 return $fechasql;
}

function retunrFechaSqlphp($fecha){
 $ano1=substr($fecha, 0, 4);
 $mes1=substr($fecha, 5, 2);
 $dia1=substr($fecha, 8, 2);

 $fechasqlphp=$ano1.$mes1.$dia1;
 return $fechasqlphp;
}

function retunrFechaActual(){
 date_default_timezone_set('America/Lima');
 $n_dia=date("d");
 $dia=$n_dia;
 $n_mes=date("n");
 if ($n_mes >= 10){
   $mes=$n_mes;
  }else{
  $mes="0".$n_mes;
 }
 $ano=date("Y");
 
 $fecha=$dia."/".$mes."/".$ano;
 return $fecha; 
}

function retunrFechaActualphp(){
 date_default_timezone_set('America/Lima');
 $n_dia=date("d");
 $dia=$n_dia;
 $n_mes=date("n");
 if ($n_mes >= 10){
   $mes=$n_mes;
  }else{
  $mes="0".$n_mes;
 }
 $ano=date("Y");
 
 $fecha=$ano."-".$mes."-".$dia;
 
 return $fecha; 
}

function convFecSistema($fecha){
 $dia1=substr($fecha, 8, 2);
 $mes1=substr($fecha, 5, 2);
 $ano1=substr($fecha, 0, 4);
 $fecha1=$dia1."/".$mes1."/".$ano1;
 return $fecha1;
}

function convFecSistema1($fecha){
 $dia1=substr($fecha, 0, 2);
 $mes1=substr($fecha, 3, 2);
 $ano1=substr($fecha, 6, 4);
 $fechasql=$ano1."-".$mes1."-".$dia1;
 return $fechasql;
}

function AdelantarFecha($fecha){

if(date("l")=="Monday"){
  $nuevafecha = strtotime ('-2 day' , strtotime ($fecha)) ;
  $nuevafecha = date ( 'Y-m-j' ,$nuevafecha);
 }
else{
 $nuevafecha = strtotime ( '-1 day' , strtotime ($fecha)) ;
 $nuevafecha = date ('Y-m-j' , $nuevafecha);
} 

$tmpdia=substr($nuevafecha, 8, 2);
$tmpmes=substr($nuevafecha, 5, 2);
$tmpano=substr($nuevafecha, 0, 4);

if($tmpdia <= 9 ){
 if(strlen($tmpdia)==2){
  $newdia=$tmpdia;
 }else{
  $newdia="0".$tmpdia;
 }
}else{
 $newdia=$tmpdia;
}

if($tmpmes <= 9 ){
 if(strlen($tmpmes)==2){
  $newmes=$tmpmes;
 }else{
  $newmes="0".$tmpmes;
 }
}else{
 $newmes=$tmpmes;
}

$newano=$tmpano;

$newfecha=$newano."-".$newmes."-".$newdia;

 return $newfecha;
  //return $newmes;

}

function AdelantarFecha1($fecha){
 $nuevafecha = strtotime ( '+1 day' , strtotime ($fecha)) ;
 $nuevafecha = date ('Y-m-j' , $nuevafecha);


$tmpdia=substr($nuevafecha, 8, 2);
$tmpmes=substr($nuevafecha, 5, 2);
$tmpano=substr($nuevafecha, 0, 4);

if($tmpdia <= 9 ){
 if(strlen($tmpdia)==2){
  $newdia=$tmpdia;
 }else{
  $newdia="0".$tmpdia;
 }
}else{
 $newdia=$tmpdia;
}

if($tmpmes <= 9 ){
 if(strlen($tmpmes)==2){
  $newmes=$tmpmes;
 }else{
  $newmes="0".$tmpmes;
 }
}else{
 $newmes=$tmpmes;
}

$newano=$tmpano;

$newfecha=$newano."-".$newmes."-".$newdia;

 return $newfecha;

}

function AdelantarFecha2($fecha){
 $nuevafecha = strtotime ( '+2 day' , strtotime ($fecha)) ;
 $nuevafecha = date ('Y-m-j' , $nuevafecha);


$tmpdia=substr($nuevafecha, 8, 2);
$tmpmes=substr($nuevafecha, 5, 2);
$tmpano=substr($nuevafecha, 0, 4);

if($tmpdia <= 9 ){
 if(strlen($tmpdia)==2){
  $newdia=$tmpdia;
 }else{
  $newdia="0".$tmpdia;
 }
}else{
 $newdia=$tmpdia;
}

if($tmpmes <= 9 ){
 if(strlen($tmpmes)==2){
  $newmes=$tmpmes;
 }else{
  $newmes="0".$tmpmes;
 }
}else{
 $newmes=$tmpmes;
}

$newano=$tmpano;

$newfecha=$newano."-".$newmes."-".$newdia;

 return $newfecha;

}


function compararFechas($primera, $segunda) {
  $valoresPrimera = explode ("/", $primera);   
  $valoresSegunda = explode ("/", $segunda); 
  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 
  $diaSegunda   = $valoresSegunda[0];  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[2];
  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     
  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es válida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es válida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  } 
}

function completarFecha($cfini){
$uno =stripos($cfini,'/'); 
$dos =strrpos($cfini,'/');

$fidia=substr($cfini,0,$uno);
$fimes=substr($cfini,$uno+1,($dos-$uno)-1);
$fiano=substr($cfini,$dos+1,4);

if (strlen($fidia)==2){
 $xfidia=$fidia;
}else{
 $xfidia="0".$fidia;
}

if (strlen($fimes)==2){
 $xfimes=$fimes;
}else{
 $xfimes="0".$fimes;
}

$fini=$xfidia."/".$xfimes."/".$fiano;

return $fini;
}

function validarFecha($fecha,$opcion){
 if($opcion=='2'){
  $pos = strpos($fecha,"/");
  if(($pos !== false) and (strlen($fecha)=='10'))
  {
   return true;
  }else{
   return false;
  }
 }else{
  return true;
 }

}

function RestriccionOficina($total,$permiso,$tgeneral){
 if($total == 0){
  if($permiso==1){
   $pase="1";
  }else{
   $pase="0";
  }  
 }else{ 
  if($tgeneral >= 21){
   $pase="1";
  }else{
   if($permiso==1){
    $pase="1";
   }else{
    $pase="0";
   }
  }
 }
 return $pase;
}




    function observacionProducto($dataproductos)
    {
        $observacion = "";
        foreach ($dataproductos->arrayproductos as $dato){
            if(isset($dato->cod_producto)){
                $observacion.= $dato->nombre."/ ";
              }  
        }
        return $observacion;  
    }


    function TotalProducto($dataproductos)
    {
        $producto = 0;
        $promocion = 0;
        foreach ($dataproductos->arrayproductos as $dato){
            if(isset($dato->cod_producto)){
                $producto += intval($dato->cantidad);
                $promocion += intval($dato->promocion);
              }  
        }
        $total = $producto + $promocion;
        return $total; 

    }
  ?>