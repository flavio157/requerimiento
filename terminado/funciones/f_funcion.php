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



function nuevfech($dias,$fechaingreso){
    /* $dias = 2;*/
     date_default_timezone_set('America/Lima');
     $nvafech = explode("-",$fechaingreso);
     $fechaPriquin = '12'."-".date("m")."-".date("Y");
     $mes = (date("m") <= '9')? '0'.(date("m")-1) : (date("m")-1);
     $fechaSegquin = '27'."-".$mes."-".date("Y");
     $fechaIngOrd = $nvafech[2]."-".$nvafech[1]."-".$nvafech[0];
     $fechaInord= new DateTime($fechaIngOrd);
     $fechaPriquicena = new DateTime($fechaPriquin);
     $fechaSegquincena = new DateTime($fechaSegquin);
 
     $fechaActual = date("d")."-".date("m")."-".date("Y");
     $fecAct = new DateTime($fechaActual);
    
     $dias1 = (evaluarfechIni($fechaPriquin)) ? $dias + 1 : $dias;
     $dias2 = (evaluarfechIni($fechaSegquin)) ? $dias + 1 : $dias;
   
   
 
     if($fecAct >= $fechaPriquicena && $fechaActual <= '26'."-".date("m")."-".date("Y")){
 
         if($fechaInord >= $fechaPriquicena && 
         $fechaActual >= date("d-m-Y",strtotime($fechaIngOrd."+".$dias."days"))){ 
             
             $cantidadDias = cantidadDias($fechaInord,$fecAct->format("d-m-Y"));
             return array($fechaIngOrd,$fechaActual,$cantidadDias);
 
         }else if($fecAct >= date("d-m-Y",strtotime($fechaPriquin."+".$dias1."days")) && 
         $fechaInord <= $fechaPriquicena){
             $cantidadDias = cantidadDias($fechaPriquicena,$fecAct->format("d-m-Y"));
             return array($fechaPriquin,$fechaActual,$cantidadDias);
         }
     }else if($fecAct >= $fechaSegquincena){
        
         
         $fech= new DateTime (date("d-m-Y",strtotime($fechaIngOrd."+".$dias."days")));
         if(date("d") >= 01 && date("d") < 27){
             $fechaSegquin = '27'."-".$mes."-".date("Y");
             $fechaSegquincena = new DateTime($fechaSegquin);
         }else if(date("d") >= 27  ){
             $fechaSegquin = '27'."-".date("m")."-".date("Y");
             $fechaSegquincena = new DateTime($fechaSegquin);
         }
         $fecqui = new DateTime(date("d-m-Y",strtotime($fechaSegquin."+".$dias2."days")));
       
 
         if($fechaInord >= $fechaSegquincena &&  $fecAct >=  $fech){  
             $cantidadDias =cantidadDias($fechaInord,$fecAct->format("d-m-Y"));
             return array($fechaIngOrd,$fechaActual,$cantidadDias);
             
         }else if($fecAct >= $fecqui &&  $fechaInord <= $fechaSegquincena ){
             $cantidadDias =cantidadDias($fechaSegquincena,$fechaActual );
             return array($fechaSegquincena,$fechaActual,$cantidadDias);
         }
     }
 }



function evaluarfechIni($fechaIngOrd){
    if(date('l',strtotime($fechaIngOrd)) == 'Sunday'){
        return true;
    }else{
        return false;
        }   
}




function cantidadDias($fechaQuincena,$fechaActual){
    $fechaActual = new DateTime($fechaActual);
    $dias = $fechaQuincena->diff($fechaActual);
    $contador = 0;
    for ($i=1; $i <= $dias->days ; $i++) { 
        $fechfin =  date("d-m-Y",strtotime($fechaQuincena->format("d-m-Y")."+".$i."days"));
        if(date('l',strtotime($fechfin)) == 'Sunday'){
            $contador++;
        }
    }
    return $dias->days-$contador;
}


function f_Cuotas($promedioCuota,$cuotas,$dias){

    date_default_timezone_set('America/Lima');
    $fechaActual = date("d")."-".date("m")."-".date("Y");
    $mes = (date("m") <= '9')? '0'.(date("m")-1) : (date("m")-1);
    
    
    if(date("d") >= 01 && date("d") < 27){
        $fechaSegquin = '27'."-".$mes."-".date("Y");
        $fechaSegquincena = new DateTime($fechaSegquin);
    }else if(date("d") >= 27  ){
        $fechaSegquin = '27'."-".date("m")."-".date("Y");
        $fechaSegquincena = new DateTime($fechaSegquin);
    }

    if($cuotas != '0' && $cuotas != null){
        $fechaActual2 = new DateTime($fechaActual);
        $restriccion  =  new  DateTime(date("d-m-Y",strtotime($promedioCuota[0]."+".$dias."days")));
        
            if($fechaActual >= '12'."-".date("m")."-".date("Y") && 
               $fechaActual <= '26'."-".date("m")."-".date("Y") &&
               $fechaActual >= date("d-m-Y",strtotime($promedioCuota[0]."+".$dias."days")) &&
               $promedioCuota[1] < $cuotas)
            {
            
                return false ;
                /*print_r("USUARIO BLOQUEADO");*/
               
            }else if($fechaActual2 >= $fechaSegquincena && 
                    $fechaActual2 >= $restriccion &&
                    $promedioCuota[1] < $cuotas){

                return false;      
                /*echo "USUARIO BLOQUEADO";*/
                
            }else{
                return true;
                /*print_r("SIN RESTRICCION");*/
            } 
        }else{
            return false;
              /*print_r("NO SE ESPECIFICO CUOTA AL USUARIO");/*
              /*return header("Location:http://localhost:8080/requerimiento/vista/Advertencia.php");*/
        }
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

    function seguMinu($datoscdr){
        $minutos = $datoscdr / 60;
         return round($minutos,2);
     }   
 
 
     function verificarCuotaLlamadas($Cantminutos,$CantMinRequeidos){
         if($Cantminutos < $CantMinRequeidos){
             return "false";
         }else{
             return "true";
         }
     }
 
     function restarDias($fechaactual,$diasresta){
         $contador = 1;
         for($i = 1 ; $i <= $diasresta ; $i++){
             $retufch =  date("d-m-Y",strtotime($fechaactual->format("d-m-Y")."-".$i."days")); 
             if(date('l',strtotime($retufch)) == 'Sunday'){
                 $contador++;
             }
         }
         return $contador;
     }



  ?>