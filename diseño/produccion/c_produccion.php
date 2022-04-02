<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_produccion.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];  
    if($accion == 'buscarxformula'){
        c_produccion::c_buscarxformula();     
    }else if($accion == 'lstitemformula'){
        $codformula = $_POST['form'];
        c_produccion::c_itemsformula($codformula);
    }else if($accion == 'stock'){
        $codprod = $_POST['stoc'];
        c_produccion::c_stock($codprod,1);
    }else if($accion == 'veristock'){
        $txtcant = $_POST['txtcant'];
        $cantxusar = $_POST['cantxusar'];
        $codpro = $_POST['codpro'];
        $tipo = $_POST['tipo'];
        c_produccion::veristock($txtcant,$cantxusar,$codpro,$tipo);
    }else if($accion == 'buscarmolde'){
        $code = $_POST['code'];
        c_produccion::c_buscarmolde($code);
    }else if($accion == 'buscarclie'){
        c_produccion::c_buscarcliente();
    }else if($accion == 'guardaclie'){
        $nombre = $_POST['txtnombcliente'];
        $dire = $_POST['txtdireccliente'];
        $correo = $_POST['txtcorreocliente'];
        $dni = $_POST['txtidenticliente'];
        $tel = $_POST['txttelefon'];
        $usu = $_POST['usu'];
        c_produccion::c_guardarclie($nombre,$dire,$correo,$dni,$tel,$usu);
    }else if($accion =='guardamolde'){
        $nombre = $_POST['txtnommolde'];
        $medidas = $_POST['txtmedmolde'];
        $usu = $_POST['usu'];
        $codcliente = $_POST['codcli'];
        c_produccion::c_guardarmolde($nombre,$medidas,$usu,$codcliente);
    }else if($accion == 'guardaprod'){
        $codform = $_POST['txtform'];
        $produc = $_POST['txtprod'];
        $sltipoprod = $_POST['sltipoprod'];
        $cliente = $_POST['txtcodclie'];
        $molde = $_POST['txtcodmolde'];
        $cavidades = $_POST['txtcavidades'];
        $pesouni = $_POST['txtpesouni'];
        $ciclo = $_POST['txtciclo'];
        $procant = $_POST['txtprodcant'];
        $inicio = $_POST['txtinicio'];
        $fin = $_POST['txtfin'];
        $estilomolde = $_POST['estilomolde'];

        $horas = $_POST['txthoras'];
        $canxturno = $_POST['canxtuno'];
        
        $tempera1 = $_POST['txttemp1'];
        $tempera2 = $_POST['txttemp2'];
        $tempera3 = $_POST['txttemp3']; 
        $tempera4 = $_POST['txttemp4'];
        $tempera5 = $_POST['txttemp5'];    
        $presexplu1 = $_POST['presexplu1'];
        $presexplu2 = $_POST['presexplu2'];
        $velexplu1 = $_POST['velexplu1'];
        $velexplu2 = $_POST['velexplu2'];
        $pisiexplu1 = $_POST['pisiexplu1'];
        $pisiexplu2 = $_POST['pisiexplu2'];
      
        $cargapres1 = $_POST['cargapres1'];
        $cargapres2 = $_POST['cargapres2'];
        $cargapres3 = $_POST['cargapres3'];
        $cargapresucc = $_POST['cargapresucc'];
        $cargavel1 = $_POST['cargavel1'];
        $cargavel2 = $_POST['cargavel2'];
        $cargavel3 = $_POST['cargavel3'];
        $cargavelsucc = $_POST['cargavelsucc'];
        $cargapisi1 = $_POST['cargapisi1'];
        $cargapisi2 = $_POST['cargapisi2'];
        $cargapisi3 = $_POST['cargapisi3'];
        $cargapisisucci = $_POST['cargapisisucci'];
        $inyecpres4 = $_POST['inyecpres4'];
        $inyecpres3 = $_POST['inyecpres3'];
        $inyecpres2 = $_POST['inyecpres2'];
        $inyecpres1 = $_POST['inyecpres1'];
        $inyecvelo4 = $_POST['inyecvelo4'];
        $inyecvelo3 = $_POST['inyecvelo3'];
        $inyecvelo2 = $_POST['inyecvelo2'];
        $inyecvelo1 = $_POST['inyecvelo1'];
        $inyecposi4 = $_POST['inyecposi4'];
        $inyecposi3 = $_POST['inyecposi3'];
        $inyecposi2 = $_POST['inyecposi2'];
        $inyecposi1 = $_POST['inyecposi1'];
        $inyectiemp = $_POST['inyectiemp'];
        $velocidad3 = $_POST['velocidad3'];
        $velocidad2 = $_POST['velocidad2'];
        $velocidad1 = $_POST['velocidad1'];
        $posicion3 = $_POST['posicion3'];
        $posicion2 = $_POST['posicion2'];
        $posicion1 = $_POST['posicion1'];
        $tiempo = $_POST['tiempo'];  
        $usu = $_POST['usu'];
        $items =json_decode($_POST['items']);
        $cambios = $_POST['modified'];
        $txttemp6 = $_POST['txttemp6'];
        $txttemp7 = $_POST['txttemp8'];
        $txttemp8 = $_POST['txttemp7'];
        $txttemp9 = $_POST['txttemp9'];

        if(!isset($_POST['slemodeexpul'])){
            $slemodeexpul = "0";
        }else{
            $slemodeexpul = $_POST['slemodeexpul'];
        }

        $botadocant = $_POST['botadocant'];
        $presexplu3 = $_POST['presexplu3'];
        $presexplu4 = $_POST['presexplu4'];
        $velexplu3 = $_POST['velexplu3'];
        $velexplu4 = $_POST['velexplu4'];
        $pisiexplu3 = $_POST['pisiexplu3'];
        $pisiexplu4 = $_POST['pisiexplu4'];
        $txtTieRetar1 = $_POST['txtTieRetar1'];
        $txtTieRetar2 = $_POST['txtTieRetar2'];
        $txtTiemActua1 = $_POST['txtTiemActua1'];
        $txtairposi1 = $_POST['txtairposi1'];
        $txtairposi2 = $_POST['txtairposi2'];
        $txtBTiemActua1 = $_POST['txtBTiemActua1'];
        $txtBirposi1 = $_POST['txtBirposi1'];
        $txtBTieRetar1 = $_POST['txtBTieRetar1'];
       
        if(!isset($_POST['slcModoActSucci'])){
            $slcModoActSucci = "0";
        }else{
            $slcModoActSucci = $_POST['slcModoActSucci'];
        }

        $carSuckBackDist = $_POST['carSuckBackDist'];
        $carSuckBackTime = $_POST['carSuckBackTime'];
        $carSKBkBefChg = $_POST['carSKBkBefChg'];
        $carTiemDesDEspC = $_POST['carTiemDesDEspC'];
        $carPosFlujoMold = $_POST['carPosFlujoMold'];
        $carTiempFlujoMo = $_POST['carTiempFlujoMo'];
        $carRetarEnfria = $_POST['carRetarEnfria'];
        $carCoolTime = $_POST['carCoolTime'];    
        

       
        $txtempuPresi1 = $_POST['txtempuPresi1'];
        $txtempuPresi2 = $_POST['txtempuPresi2'];
        $txtempuPresi3 = $_POST['txtempuPresi3'];
        $txtempuPresi4 = $_POST['txtempuPresi4'];
      
        $txtempudelay1 = $_POST['txtempudelay1'];
        $txtemputiemp1 = $_POST['txtemputiemp1'];
        $txtemputiemp2 = $_POST['txtemputiemp2'];
        $txtempupisici = $_POST['txtempupisici'];
        
        if(!isset($_POST['txtempucorreAtr'])){
            $txtempucorreAtr = "0";
        }else{
            $txtempucorreAtr = $_POST['txtempucorreAtr'];
        }
        
        $txtempuveloc1 = $_POST['txtempuveloc1'];
        $txtempuveloc2 = $_POST['txtempuveloc2'];
        $txtempuveloc3 = $_POST['txtempuveloc3'];
        $txtempuveloc4 = $_POST['txtempuveloc4'];

        
    
        $txtprecieOpnStr = $_POST['txtprecieOpnStr'];
        $txtprescierr_presio1 = $_POST['txtprescierr_presio1'];
        $txtprescierr_presio2 = $_POST['txtprescierr_presio2'];
        $txtprescierr_presio3 = $_POST['txtprescierr_presio3'];
        $txtprescierr_presio4 = $_POST['txtprescierr_presio4'];
        $txtprescierr_velo1 = $_POST['txtprescierr_velo1'];
        $txtprescierr_velo2 = $_POST['txtprescierr_velo2'];
        $txtprescierr_velo3 = $_POST['txtprescierr_velo3'];
        $txtprescierr_velo5 = $_POST['txtprescierr_velo5'];
        $txtprescierr_posic1 = $_POST['txtprescierr_posic1'];
        $txtprescierr_posic2 = $_POST['txtprescierr_posic2'];
        $txtprescierr_posic3 = $_POST['txtprescierr_posic3'];
        $txtprescierr_posic4 = $_POST['txtprescierr_posic4'];
        $txtprescierr_presi5 = $_POST['txtprescierr_presi5'];
        $txtprescierr_presi6 = $_POST['txtprescierr_presi6'];
        $txtprescierr_presi7 = $_POST['txtprescierr_presi7'];
        $txtprescierr_presi8 = $_POST['txtprescierr_presi8'];
        $txtprescierr_veloc5 = $_POST['txtprescierr_veloc5'];
        $txtprescierr_veloc6 = $_POST['txtprescierr_veloc6'];
        $txtprescierr_veloc7 = $_POST['txtprescierr_veloc7'];
        $txtprescierr_veloc8 = $_POST['txtprescierr_veloc8'];
        $txtprescierr_posic5 = $_POST['txtprescierr_posic5'];
        $txtprescierr_posic6 = $_POST['txtprescierr_posic6'];
        $txtprescierr_posic7 = $_POST['txtprescierr_posic7'];
        $txtprescierr_posic8 = $_POST['txtprescierr_posic8'];

        $txtcarriage = $_POST['txtcarriage'];
        $txtclosedd = $_POST['txtclosedd'];
        $txtcuter = $_POST['txtcuter'];
        $txthead = $_POST['txthead'];
        $txtblow = $_POST['txtblow'];
        $txttotalblo = $_POST['txttotalblo'];
        $txtblow1 = $_POST['txtblow1'];
        $txtlf = $_POST['txtlf'];
        $txtdefla = $_POST['txtdefla'];
        $txtunde = $_POST['txtunde'];
        $txtcoolin = $_POST['txtcoolin'];
        $txtlock = $_POST['txtlock'];
        $txtbottle = $_POST['txtbottle'];
        $txtcarria = $_POST['txtcarria'];
        $txtopenmoul = $_POST['txtopenmoul'];
        $txtcuter1 = $_POST['txtcuter1'];
        $txthead1 = $_POST['txthead1'];
        $txtblowpin = $_POST['txtblowpin'];
        $txttotalbl = $_POST['txttotalbl'];
        $txtdeflati = $_POST['txtdeflati'];
        $txtblopinS = $_POST['txtblopinS'];
        $txtdeflation = $_POST['txtdeflation'];
        $txtcamvaci1 = $_POST['txtcamvaci1'];
        $txtcooling = $_POST['txtcooling'];
        $txtcamvaci2 = $_POST['txtcamvaci2'];
        $txtcamvaci3 = $_POST['txtcamvaci3'];
        $modifiedLF = $_POST['modifiedLF'];
        $removebloq = $_POST['r'];

        c_produccion::c_guardarproduccion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items,$cambios,$inicio,$fin,$txttemp6,$txttemp7,$txttemp8,$txttemp9,
        $txtcarriage,$txtclosedd,$txtcuter,$txthead,$txtblow,$txttotalblo,$txtblow1,$txtlf,$txtdefla,$txtunde,
        $txtcoolin,$txtlock,$txtbottle,$txtcarria,$txtopenmoul,$txtcuter1,$txthead1,$txtblowpin,$txttotalbl,
        $txtdeflati,$txtblopinS,$txtdeflation,$txtcamvaci1,$txtcooling,$txtcamvaci2,$txtcamvaci3,$modifiedLF
        ,$estilomolde,$removebloq  ,$slemodeexpul,$botadocant,$presexplu3,$presexplu4,$velexplu3,$velexplu4,
        $pisiexplu3,$pisiexplu4,$txtTieRetar1,$txtTieRetar2,$txtTiemActua1,$txtairposi1,$txtairposi2,$txtBTiemActua1,
        $txtBirposi1,$txtBTieRetar1
        ,$slcModoActSucci,$carSuckBackDist,$carSuckBackTime,$carSKBkBefChg,$carTiemDesDEspC,$carPosFlujoMold,
        $carTiempFlujoMo,$carRetarEnfria,$carCoolTime,
    
        $txtempuPresi1,$txtempuPresi2,$txtempuPresi3,$txtempuPresi4,$txtempudelay1,$txtemputiemp1,$txtemputiemp2,$txtempupisici,
        $txtempucorreAtr,$txtempuveloc1,$txtempuveloc2,$txtempuveloc3,$txtempuveloc4,

        $txtprecieOpnStr,$txtprescierr_presio1 ,$txtprescierr_presio2 ,$txtprescierr_presio3 ,$txtprescierr_presio4 ,
        $txtprescierr_velo1 ,$txtprescierr_velo2 ,$txtprescierr_velo3,$txtprescierr_velo5 , $txtprescierr_posic1 ,
        $txtprescierr_posic2 ,$txtprescierr_posic3 ,$txtprescierr_posic4 ,$txtprescierr_presi5 ,$txtprescierr_presi6 ,
        $txtprescierr_presi7 ,$txtprescierr_presi8 ,$txtprescierr_veloc5 ,$txtprescierr_veloc6 ,$txtprescierr_veloc7 ,
        $txtprescierr_veloc8,$txtprescierr_posic5,$txtprescierr_posic6 ,
        $txtprescierr_posic7 ,$txtprescierr_posic8 ,
        $horas,$canxturno 
    );

    }else if($accion == 'externo'){
        $producto = $_POST['insumo'];
        $cantidad = $_POST['stocks'];
        c_produccion::c_guardarexterno($producto,$cantidad);
    }else if($accion == 'updateexter'){
        $producto = $_POST['upinsumo'];
        $cantidad = $_POST['upstocks'];
        $tipo = $_POST['uptipo'];
        c_produccion::c_updateexteno($producto,$cantidad,$tipo);
    }else if($accion == 'pasadas'){
            $insumo = $_POST['insumo'];
            c_produccion::c_pasadas($insumo);
    }else if($accion== 'parametros'){
        $produccion = $_POST['produccion'];
        c_produccion::c_parametros($produccion);
    }else if("confirmar"){
        $confirmacion = $_POST['codconfirmar'];
        c_produccion::c_confirmacion($confirmacion);
    }

 
    class c_produccion
    {

        static function c_parametros($produccion){
            $para = 0;
            $m_formula = new m_produccion();
            $parametros = $m_formula->m_ultimoregistro($produccion);
            if(count($parametros) > 0){$para = 1;}
            $dato = array('dato' => $parametros , 'para' => $para);
            echo json_encode($dato,JSON_FORCE_OBJECT); 
        }


        static function c_buscarxformula()
        {
            $m_producto = new m_produccion();
            $m_producto->generarxdiario();
            $producto = array();
            $cadena = "'' = ''";
            $c_producto = $m_producto->m_buscar('V_CABECERA_FORMULACION',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "prod" => $c_producto[$i][2],
                    "cant" => $c_producto[$i][4],
                    "idmolde" => $c_producto[$i][7],
                    "molde" => $c_producto[$i][8],
                    "estiM" => $c_producto[$i][11],
                    "peso" => $c_producto[$i][12],
                    "label" => trim($c_producto[$i][1]) ));
            }
            $dato = array('dato' => $producto);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_itemsformula($formula)
        {
            $m_formula = new m_produccion();
            $cadena = "formula = '$formula'";
            $c_formula = $m_formula->m_buscar('V_ITEMS_FORMULACION',$cadena);
            $dato = array('dato' => $c_formula);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
       
        static function c_stock($codprod,$tipo)
        {
            $m_producto = new m_produccion();
            $cadena = "COD_PRODUCTO = '$codprod'";
            $c_producto = $m_producto->m_buscar('T_ALMACEN_INSUMOS',$cadena);
            if($tipo == 0){return $c_producto[0][4];}
            if(count($c_producto) > 0){
                $dato = array('stock' => $c_producto[0][4]);
                echo json_encode($dato,JSON_FORCE_OBJECT);
            }
        }

        static function veristock($txtcant,$cantxusar,$codprod,$tipo)
        {
            $mensaje ='';
            if($tipo == 'P'){
                $stock = c_produccion::c_stock($codprod,0);
                if($txtcant > $stock){$mensaje = "Error no hay stock suficiente";}
            }
           
            if($mensaje != ''){$dato = array('tipo'=> 1 ,'dato' => $mensaje);}
            else{$dato = array('tipo'=> 0 ,'dato' => $txtcant);}
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarmolde($code)
        {
            $producto = array();
            $m_producto = new m_produccion();
            $cadena = "COD_CLIENTE = '$code' or TIPO_MOLDE = 'P' and ESTADO = '1'";
            $c_producto = $m_producto->m_buscar('T_MOLDE',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1]));
            }
            $dato = array('dato' => $producto);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarcliente()
        {
            $producto = array();
            $m_producto = new m_produccion();
            $cadena = "'' = ''";
            $c_producto = $m_producto->m_buscar('T_CLIENTE_MOLDE',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1]));
            }
            $dato = array('dato' => $producto);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

          static function c_guardarclie($nombre,$dire,$correo,$dni,$tel,$usu)
        {

            $mensaje = ''; $codigo = '';
            $regex = "/^[0-9]+$/";
            if(strlen($correo) != 0){
                if(filter_var($correo, FILTER_VALIDATE_EMAIL) == false)
                {$mensaje = "Error correo invalido";$codigo = 0;} 
            }
            if(strlen($tel) != 0){
                if(preg_match($regex,$tel) == 0){$mensaje = "Error solo numeros en telefono";$codigo = 0;} 
                else if(strlen($tel) > 9){$mensaje = "Error campo telefono maximo 9 digitos";$codigo = 0;}
                else if(strlen($tel) < 6){$mensaje = "Error campo telefono minimo 6 digitos";$codigo = 0;}     
                else if(count(count_chars($tel, 1)) < 4){$mensaje = "Error campo telefono invalido";$codigo = 0;}
            }

            if(strlen($nombre) == 0){$mensaje = "Error ingrese nombre del cliente";$codigo = 0;}
            else if(strlen($dire) == 0 ){$mensaje ="Error ingrese dirección del cliente";$codigo = 0;}
            else if(preg_match($regex,$dni) == 0){$mensaje ="Error solo numeros en identificacion";$codigo = 0;}
            else if(strlen($dni) == 0){$mensaje ="Error ingrese identificacion del cliente";$codigo = 0;}
            else if(strlen($dni) > 11){$mensaje ="Error campo identificacion maximo 11 digitos";$codigo = 0;}
            else if(strlen($dni) == 9){$mensaje ="Error campo identificacion 8 ó 11 digitos";$codigo = 0;}
            else if(strlen($dni) == 10){$mensaje ="Error campo identificacion 8 ó 11 digitos";$codigo = 0;}
            else if(strlen($dni) < 8){$mensaje ="Error campo identificacion minimo 8 digitos";$codigo = 0;}
            else if(count(count_chars($dni, 1)) < 3){$mensaje = "Error campo identificacion no valido";$codigo = 0;}
          
            if(strlen(trim($mensaje)) == 0){
                $m_producto = new m_produccion();
                $c_cliente = $m_producto->m_guardarcliente(strtoupper($nombre),$dire,$correo,$dni,$tel,$usu);
                if($c_cliente[0] != true){
                    $mensaje = $c_cliente[0]; 
                    $codigo = '';
                }else{
                    $mensaje = $c_cliente[0]; 
                    $codigo = $c_cliente[1];
                }
            }
            
            $dato = array(
                'e' => $mensaje,
                'c' => $codigo
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_guardarmolde($nombre,$medidas,$usu,$codcliente)
        {
            $mensaje = ''; $codigo = '';
            $regex = "/[0-9\^-]+(a|c|m|x|h|l)+$/"; 
            if(strlen(trim($codcliente) == 0)){$mensaje = "Error seleccione cliente"; $codigo = 0;}
            else if(strlen($nombre) == 0){$mensaje = "Error ingrese nombre del Molde"; $codigo = 0;}
            else if(strlen($medidas) == 0){$mensaje = "Error ingrese medidas del Molde"; $codigo = 0;}
            else if(preg_match($regex,$medidas) == 0){$mensaje = "Error campo medidas del molde formato incorrecto"; $codigo = 0;}
            else{
            $m_producto = new m_produccion();
            $c_molde = $m_producto->m_guardarmolde(strtoupper($nombre),$medidas,$usu,$codcliente);
                if($c_molde != true){
                    $mensaje = $c_molde; $codigo = '';
                }else{
                    $mensaje = $c_molde[0]; $codigo = $c_molde[1];
                }
            }
            $dato = array('e' =>  $mensaje,'c' =>  $codigo);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_guardarproduccion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items,$cambios,$inicio,$fin,$txttemp6,$txttemp7,$txttemp8,$txttemp9,
        $txtcarriage,$txtclosedd,$txtcuter,$txthead,$txtblow,$txttotalblo,$txtblow1,$txtlf,$txtdefla,$txtunde,
        $txtcoolin,$txtlock,$txtbottle,$txtcarria,$txtopenmoul,$txtcuter1,$txthead1,$txtblowpin,$txttotalbl,
        $txtdeflati,$txtblopinS,$txtdeflation,$txtcamvaci1,$txtcooling,$txtcamvaci2,$txtcamvaci3,$modifiedLF,$estilomolde,$removebloq
        
        ,$slemodeexpul,$botadocant,$presexplu3,$presexplu4,$velexplu3,$velexplu4,
        $pisiexplu3,$pisiexplu4,$txtTieRetar1,$txtTieRetar2,$txtTiemActua1,$txtairposi1,$txtairposi2,$txtBTiemActua1,
        $txtBirposi1,$txtBTieRetar1,
        $slcModoActSucci,$carSuckBackDist,$carSuckBackTime,$carSKBkBefChg,$carTiemDesDEspC,$carPosFlujoMold,
        $carTiempFlujoMo,$carRetarEnfria,$carCoolTime,
        
        $txtempuPresi1,$txtempuPresi2,$txtempuPresi3,$txtempuPresi4,$txtempudelay1,$txtemputiemp1,$txtemputiemp2,$txtempupisici,
        $txtempucorreAtr,$txtempuveloc1,$txtempuveloc2,$txtempuveloc3,$txtempuveloc4,

        
        $txtprecieOpnStr,$txtprescierr_presio1 ,$txtprescierr_presio2 ,$txtprescierr_presio3 ,$txtprescierr_presio4 ,
        $txtprescierr_velo1 ,$txtprescierr_velo2 ,$txtprescierr_velo3,$txtprescierr_velo5 , $txtprescierr_posic1 ,
        $txtprescierr_posic2 ,$txtprescierr_posic3 ,$txtprescierr_posic4 ,$txtprescierr_presi5 ,$txtprescierr_presi6 ,
        $txtprescierr_presi7 ,$txtprescierr_presi8 ,$txtprescierr_veloc5 ,$txtprescierr_veloc6 ,$txtprescierr_veloc7 ,
        $txtprescierr_veloc8,$txtprescierr_posic5,$txtprescierr_posic6 ,
        $txtprescierr_posic7 ,$txtprescierr_posic8,$horas,$canxturno)
        { 
            $m_produccion = new m_produccion();

            $cadena = "estado = '0' and detenido = '0' and usuario = '$usu'";
            $control = $m_produccion->m_buscar('V_CONTROL_CALIDAD',$cadena);
            if(count($control) > 0){
                print_r("Error cierre la produccion pendiente antes de registrar otra");
                return;
            }
            //if(strlen(trim($removebloq)) == 0){ $removebloq = "B";}
           

            //$parametros = $m_produccion->m_ultimoregistro($codform);
            //if(count($parametros) > 0 && $removebloq == "B" && ($modifiedLF == 1 || $cambios == 1)){print_r("b"); return;}

            $inyeccion = array($presexplu1,$presexplu2,$velexplu1,
            $velexplu2,$pisiexplu1,$pisiexplu2,$cargapres1,$cargapres2,$cargapres3,
            $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
            $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
            $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
            $posicion1,$tiempo,$botadocant,$presexplu3,$presexplu4,$velexplu3,$velexplu4,
            $pisiexplu3,$pisiexplu4,$txtTieRetar1,$txtTieRetar2,$txtTiemActua1,$txtairposi1,$txtairposi2,$txtBTiemActua1,
            $txtBirposi1,$txtBTieRetar1,$carSuckBackDist,$carSuckBackTime,$carSKBkBefChg,$carTiemDesDEspC,$carPosFlujoMold,
            $carTiempFlujoMo,$carRetarEnfria,$carCoolTime, $txtprecieOpnStr,$txtprescierr_presio1 ,$txtprescierr_presio2 ,$txtprescierr_presio3 ,$txtprescierr_presio4 ,
            $txtprescierr_velo1 ,$txtprescierr_velo2 ,$txtprescierr_velo3,$txtprescierr_velo5 , $txtprescierr_posic1 ,
            $txtprescierr_posic2 ,$txtprescierr_posic3 ,$txtprescierr_posic4 ,$txtprescierr_presi5 ,$txtprescierr_presi6 ,
            $txtprescierr_presi7 ,$txtprescierr_presi8 ,$txtprescierr_veloc5 ,$txtprescierr_veloc6 ,$txtprescierr_veloc7 ,
            $txtprescierr_veloc8,$txtprescierr_posic5,$txtprescierr_posic6 ,
            $txtprescierr_posic7 ,$txtprescierr_posic8);

            $soplado = array($txtcarriage,$txtclosedd,$txtcuter,$txthead,$txtblow,$txttotalblo,$txtblow1,$txtlf,$txtdefla,$txtunde,
            $txtcoolin,$txtlock,$txtbottle,$txtcarria,$txtopenmoul,$txtcuter1,$txthead1,$txtblowpin,$txttotalbl,
            $txtdeflati,$txtblopinS,$txtdeflation,$txtcamvaci1,$txtcooling,$txtcamvaci2,$txtcamvaci3,$modifiedLF);

           
            $return = c_produccion::validardatosfor($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
            $inicio,$fin,
            $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$txttemp6,$txttemp7,$txttemp8,$txttemp9,
            $inyeccion, $soplado ,
            $estilomolde,$items,$horas,$canxturno);
        
            if($return == ''){
                $txttemp6 = (strlen(trim($txttemp6))== 0 ) ? 0.00 : $txttemp6;
                $txttemp7 = (strlen(trim($txttemp7))== 0 ) ? 0.00 : $txttemp7;
                $txttemp8 = (strlen(trim($txttemp8))== 0 ) ? 0.00 : $txttemp8;
                $txttemp9 = (strlen(trim($txttemp9))== 0 ) ? 0.00 : $txttemp9;
                
                    $presexplu1 = (strlen(trim($presexplu1))== 0 ) ? 0.00 : $presexplu1;
                    $presexplu2 = (strlen(trim($presexplu2))== 0 ) ? 0.00 : $presexplu2;
                    $velexplu1 = (strlen(trim($velexplu1))== 0 ) ? 0.00 : $velexplu1;
                    $velexplu2 = (strlen(trim($velexplu2))== 0 ) ? 0.00 : $velexplu2;
                    $pisiexplu1 = (strlen(trim($pisiexplu1))== 0 ) ? 0.00 : $pisiexplu1;
                    $pisiexplu2 = (strlen(trim($pisiexplu2))== 0 ) ? 0.00 : $pisiexplu2;
                    $cargapres1 = (strlen(trim($cargapres1))== 0 ) ? 0.00 : $cargapres1;
                    $cargapres2 = (strlen(trim($cargapres2))== 0 ) ? 0.00 : $cargapres2;
                    $cargapres3 = (strlen(trim($cargapres3))== 0 ) ? 0.00 : $cargapres3;
                    $cargapresucc = (strlen(trim($cargapresucc))== 0 ) ? 0.00 : $cargapresucc;
                    $cargavel1 = (strlen(trim($cargavel1))== 0 ) ? 0.00 : $cargavel1;
                    $cargavel2 = (strlen(trim($cargavel2))== 0 ) ? 0.00 : $cargavel2;
                    $cargavel3 = (strlen(trim($cargavel3))== 0 ) ? 0.00 : $cargavel3;
                    $cargavelsucc = (strlen(trim($cargavelsucc))== 0 ) ? 0.00 : $cargavelsucc;
                    $cargapisi1 = (strlen(trim($cargapisi1))== 0 ) ? 0.00 : $cargapisi1;
                    $cargapisi2 = (strlen(trim($cargapisi2))== 0 ) ? 0.00 : $cargapisi2;
                    $cargapisi3 = (strlen(trim($cargapisi3))== 0 ) ? 0.00 : $cargapisi3;
                    $cargapisisucci = (strlen(trim($cargapisisucci))== 0 ) ? 0.00 : $cargapisisucci;
                    $inyecpres4 = (strlen(trim($inyecpres4))== 0 ) ? 0.00 : $inyecpres4;
                    $inyecpres3 = (strlen(trim($inyecpres3))== 0 ) ? 0.00 : $inyecpres3;
                    $inyecpres2 = (strlen(trim($inyecpres2))== 0 ) ? 0.00 : $inyecpres2;
                    $inyecpres1 = (strlen(trim($inyecpres1))== 0 ) ? 0.00 : $inyecpres1;
                    $inyecvelo4 = (strlen(trim($inyecvelo4))== 0 ) ? 0.00 : $inyecvelo4;
                    $inyecvelo3 = (strlen(trim($inyecvelo3))== 0 ) ? 0.00 : $inyecvelo3;
                    $inyecvelo2 = (strlen(trim($inyecvelo2))== 0 ) ? 0.00 : $inyecvelo2;
                    $inyecvelo1 = (strlen(trim($inyecvelo1))== 0 ) ? 0.00 : $inyecvelo1;
                    $inyecposi4 = (strlen(trim($inyecposi4))== 0 ) ? 0.00 : $inyecposi4;
                    $inyecposi3 = (strlen(trim($inyecposi3))== 0 ) ? 0.00 : $inyecposi3;
                    $inyecposi2 = (strlen(trim($inyecposi2))== 0 ) ? 0.00 : $inyecposi2;
                    $inyecposi1 = (strlen(trim($inyecposi1))== 0 ) ? 0.00 : $inyecposi1;
                    $inyectiemp = (strlen(trim($inyectiemp))== 0 ) ? 0.00 : $inyectiemp;
                    $velocidad3 = (strlen(trim($velocidad3))== 0 ) ? 0.00 : $velocidad3;
                    $velocidad2 = (strlen(trim($velocidad2))== 0 ) ? 0.00 : $velocidad2;
                    $velocidad1 = (strlen(trim($velocidad1))== 0 ) ? 0.00 : $velocidad1;
                    $posicion3 = (strlen(trim($posicion3))== 0 ) ? 0.00 : $posicion3;
                    $posicion2 = (strlen(trim($posicion2))== 0 ) ? 0.00 : $posicion2;
                    $posicion1 = (strlen(trim($posicion1))== 0 ) ? 0.00 : $posicion1;
                    $tiempo = (strlen(trim($tiempo))== 0 ) ? 0.00 : $tiempo;
                
                    $txtcarriage = (strlen(trim($txtcarriage))== 0 ) ? 0.00 : $txtcarriage;
                    $txtclosedd = (strlen(trim($txtclosedd))== 0 ) ? 0.00 : $txtclosedd;
                    $txtcuter = (strlen(trim($txtcuter))== 0 ) ? 0.00 : $txtcuter;
                    $txthead = (strlen(trim($txthead))== 0 ) ? 0.00 : $txthead;
                    $txtblow = (strlen(trim($txtblow))== 0 ) ? 0.00 : $txtblow;
                    $txttotalblo = (strlen(trim($txttotalblo))== 0 ) ? 0.00 : $txttotalblo;
                    $txtblow1 = (strlen(trim($txtblow1))== 0 ) ? 0.00 : $txtblow1;
                    $txtlf = (strlen(trim($txtlf))== 0 ) ? 0.00 : $txtlf;
                    $txtdefla = (strlen(trim($txtdefla))== 0 ) ? 0.00 : $txtdefla;
                    $txtunde = (strlen(trim($txtunde))== 0 ) ? 0.00 : $txtunde;
                    $txtcoolin = (strlen(trim($txtcoolin))== 0 ) ? 0.00 : $txtcoolin;
                    $txtlock = (strlen(trim($txtlock))== 0 ) ? 0.00 : $txtlock;
                    $txtbottle = (strlen(trim($txtbottle))== 0 ) ? 0.00 : $txtbottle;
                    $txtcarria = (strlen(trim($txtcarria))== 0 ) ? 0.00 : $txtcarria;
                    $txtopenmoul = (strlen(trim($txtopenmoul))== 0 ) ? 0.00 : $txtopenmoul;
                    $txtcuter1 = (strlen(trim($txtcuter1))== 0 ) ? 0.00 : $txtcuter1;
                    $txthead1 = (strlen(trim($txthead1))== 0 ) ? 0.00 : $txthead1;
                    $txtblowpin = (strlen(trim($txtblowpin))== 0 ) ? 0.00 : $txtblowpin;
                    $txttotalbl = (strlen(trim($txttotalbl))== 0 ) ? 0.00 : $txttotalbl;

                    $txtdeflati = (strlen(trim($txtdeflati))== 0 ) ? 0.00 : $txtdeflati;
                    $txtblopinS = (strlen(trim($txtblopinS))== 0 ) ? 0.00 : $txtblopinS;
                    $txtdeflation = (strlen(trim($txtdeflation))== 0 ) ? 0.00 : $txtdeflation;
                    $txtcamvaci1 = (strlen(trim($txtcamvaci1))== 0 ) ? 0.00 : $txtcamvaci1;
                    $txtcooling = (strlen(trim($txtcooling))== 0 ) ? 0.00 : $txtcooling;

                    $txtcamvaci2 = (strlen(trim($txtcamvaci2))== 0 ) ? 0.00 : $txtcamvaci2;
                    $txtcamvaci3 = (strlen(trim($txtcamvaci3))== 0 ) ? 0.00 : $txtcamvaci3;

                    $botadocant = (strlen(trim($botadocant))== 0 ) ? 0.00 : $botadocant;
                    $presexplu3 = (strlen(trim($presexplu3))== 0 ) ? 0.00 : $presexplu3;
                    $presexplu4 = (strlen(trim($presexplu4))== 0 ) ? 0.00 : $presexplu4;
                    $velexplu3 = (strlen(trim($velexplu3))== 0 ) ? 0.00 : $velexplu3;
                    $velexplu4 = (strlen(trim($velexplu4))== 0 ) ? 0.00 : $velexplu4;
                    $pisiexplu3 = (strlen(trim($pisiexplu3))== 0 ) ? 0.00 : $pisiexplu3;
                    $pisiexplu4 = (strlen(trim($pisiexplu4))== 0 ) ? 0.00 : $pisiexplu4;
                    $txtTieRetar1 = (strlen(trim($txtTieRetar1))== 0 ) ? 0.00 : $txtTieRetar1;
                    $txtTieRetar2 = (strlen(trim($txtTieRetar2))== 0 ) ? 0.00 : $txtTieRetar2;
                    $txtTiemActua1 = (strlen(trim($txtTiemActua1))== 0 ) ? 0.00 : $txtTiemActua1;
                    $txtairposi1 = (strlen(trim($txtairposi1))== 0 ) ? 0.00 : $txtairposi1;
                    $txtairposi2 = (strlen(trim($txtairposi2))== 0 ) ? 0.00 : $txtairposi2;  
                    $txtBTiemActua1 = (strlen(trim($txtBTiemActua1))== 0 ) ? 0.00 : $txtBTiemActua1;  
                    $txtBirposi1 = (strlen(trim($txtBirposi1))== 0 ) ? 0.00 : $txtBirposi1;  
                    $txtBTieRetar1 = (strlen(trim($txtBTieRetar1))== 0 ) ? 0.00 : $txtBTieRetar1;  
                    $carSuckBackDist = (strlen(trim($carSuckBackDist))== 0 ) ? 0.00 : $carSuckBackDist;  
                    $carSuckBackTime = (strlen(trim($carSuckBackTime))== 0 ) ? 0.00 : $carSuckBackTime;
                    $carSKBkBefChg = (strlen(trim($carSKBkBefChg))== 0 ) ? 0.00 : $carSKBkBefChg;  
                    $carTiemDesDEspC = (strlen(trim($carTiemDesDEspC))== 0 ) ? 0.00 : $carTiemDesDEspC;  
                    $carPosFlujoMold = (strlen(trim($carPosFlujoMold))== 0 ) ? 0.00 : $carPosFlujoMold;
                    $carTiempFlujoMo = (strlen(trim($carTiempFlujoMo))== 0 ) ? 0.00 : $carTiempFlujoMo;    
                    $carRetarEnfria = (strlen(trim($carRetarEnfria))== 0 ) ? 0.00 : $carRetarEnfria;      
                    $carCoolTime = (strlen(trim($carCoolTime))== 0 ) ? 0.00 : $carCoolTime;

                    $txtempuPresi1 = (strlen(trim($txtempuPresi1))== 0 ) ? 0.00 : $txtempuPresi1; 
                    $txtempuPresi2 = (strlen(trim($txtempuPresi2))== 0 ) ? 0.00 : $txtempuPresi2;   
                    $txtempuPresi3 = (strlen(trim($txtempuPresi3))== 0 ) ? 0.00 : $txtempuPresi3;
                    $txtempuPresi4 = (strlen(trim($txtempuPresi4))== 0 ) ? 0.00 : $txtempuPresi4;
                    $txtempudelay1 = (strlen(trim($txtempudelay1))== 0 ) ? 0.00 : $txtempudelay1;
                    $txtemputiemp1 = (strlen(trim($txtemputiemp1))== 0 ) ? 0.00 : $txtemputiemp1;
                    $txtemputiemp2 = (strlen(trim($txtemputiemp2))== 0 ) ? 0.00 : $txtemputiemp2;
                    $txtempupisici = (strlen(trim($txtempupisici))== 0 ) ? 0.00 : $txtempupisici;
                    $txtempucorreAtr = (strlen(trim($txtempucorreAtr))== 0 ) ? 0.00 : $txtempucorreAtr;
                    $txtempuveloc1 = (strlen(trim($txtempuveloc1))== 0 ) ? 0.00 : $txtempuveloc1;
                    $txtempuveloc2 = (strlen(trim($txtempuveloc2))== 0 ) ? 0.00 : $txtempuveloc2;
                    $txtempuveloc3 = (strlen(trim($txtempuveloc3))== 0 ) ? 0.00 : $txtempuveloc3;
                    $txtempuveloc4 = (strlen(trim($txtempuveloc4))== 0 ) ? 0.00 : $txtempuveloc4;

                    $txtprecieOpnStr = (strlen(trim($txtprecieOpnStr))== 0 ) ? 0.00 : $txtprecieOpnStr;
                    $txtprescierr_presio1 = (strlen(trim($txtprescierr_presio1))== 0 ) ? 0.00 : $txtprescierr_presio1;
                    $txtprescierr_presio2 = (strlen(trim($txtprescierr_presio2))== 0 ) ? 0.00 : $txtprescierr_presio2;
                    $txtprescierr_presio3 = (strlen(trim($txtprescierr_presio3))== 0 ) ? 0.00 : $txtprescierr_presio3;
                    $txtprescierr_presio4 = (strlen(trim($txtprescierr_presio4))== 0 ) ? 0.00 : $txtprescierr_presio4;
                    $txtprescierr_velo1 = (strlen(trim($txtprescierr_velo1))== 0 ) ? 0.00 : $txtprescierr_velo1;
                    $txtprescierr_velo2 = (strlen(trim($txtprescierr_velo2))== 0 ) ? 0.00 : $txtprescierr_velo2;
                    $txtprescierr_velo3 = (strlen(trim($txtprescierr_velo3))== 0 ) ? 0.00 : $txtprescierr_velo3;
                    $txtprescierr_velo5 = (strlen(trim($txtprescierr_velo5))== 0 ) ? 0.00 : $txtprescierr_velo5;
                    $txtprescierr_posic1 = (strlen(trim($txtprescierr_posic1))== 0 ) ? 0.00 : $txtprescierr_posic1;
                    $txtprescierr_posic2 = (strlen(trim($txtprescierr_posic2))== 0 ) ? 0.00 : $txtprescierr_posic2;
                    $txtprescierr_posic3 = (strlen(trim($txtprescierr_posic3))== 0 ) ? 0.00 : $txtprescierr_posic3;
                    $txtprescierr_posic4 = (strlen(trim($txtprescierr_posic4))== 0 ) ? 0.00 : $txtprescierr_posic4;
                    $txtprescierr_presi5 = (strlen(trim($txtprescierr_presi5))== 0 ) ? 0.00 : $txtprescierr_presi5;
                    $txtprescierr_presi6 = (strlen(trim($txtprescierr_presi6))== 0 ) ? 0.00 : $txtprescierr_presi6;
                    $txtprescierr_presi7 = (strlen(trim($txtprescierr_presi7))== 0 ) ? 0.00 : $txtprescierr_presi7;
                    $txtprescierr_presi8 = (strlen(trim($txtprescierr_presi8))== 0 ) ? 0.00 : $txtprescierr_presi8;
                    $txtprescierr_veloc5 = (strlen(trim($txtprescierr_veloc5))== 0 ) ? 0.00 : $txtprescierr_veloc5;
                    $txtprescierr_veloc6 = (strlen(trim($txtprescierr_veloc6))== 0 ) ? 0.00 : $txtprescierr_veloc6;
                    $txtprescierr_veloc7 = (strlen(trim($txtprescierr_veloc7))== 0 ) ? 0.00 : $txtprescierr_veloc7;
                    $txtprescierr_veloc8 = (strlen(trim($txtprescierr_veloc8))== 0 ) ? 0.00 : $txtprescierr_veloc8;
                    $txtprescierr_posic5 = (strlen(trim($txtprescierr_posic5))== 0 ) ? 0.00 : $txtprescierr_posic5;
                    $txtprescierr_posic6 = (strlen(trim($txtprescierr_posic6))== 0 ) ? 0.00 : $txtprescierr_posic6;
                    $txtprescierr_posic7 = (strlen(trim($txtprescierr_posic7))== 0 ) ? 0.00 : $txtprescierr_posic7;
                    $txtprescierr_posic8 = (strlen(trim($txtprescierr_posic8))== 0 ) ? 0.00 : $txtprescierr_posic8;
                    

                $c_formulacion = $m_produccion->m_guardarformulacion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
                $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
                $velexplu2,$pisiexplu1,$pisiexplu2,$cargapres1,$cargapres2,$cargapres3,
                $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
                $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
                $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
                $posicion1,$tiempo,$usu,$items,$cambios,$inicio,$fin,$txttemp6,$txttemp7,$txttemp8,$txttemp9,
                $txtcarriage,$txtclosedd,$txtcuter,$txthead,$txtblow,$txttotalblo,$txtblow1,$txtlf,$txtdefla,$txtunde,
                $txtcoolin,$txtlock,$txtbottle,$txtcarria,$txtopenmoul,$txtcuter1,$txthead1,$txtblowpin,$txttotalbl,
                $txtdeflati,$txtblopinS,$txtdeflation,$txtcamvaci1,$txtcooling,$txtcamvaci2,$txtcamvaci3,$modifiedLF

                ,$slemodeexpul,$botadocant,$presexplu3,$presexplu4,$velexplu3,$velexplu4,
                $pisiexplu3,$pisiexplu4,$txtTieRetar1,$txtTieRetar2,$txtTiemActua1,$txtairposi1,$txtairposi2,$txtBTiemActua1,
                $txtBirposi1,$txtBTieRetar1,
                $slcModoActSucci,$carSuckBackDist,$carSuckBackTime,$carSKBkBefChg,$carTiemDesDEspC,$carPosFlujoMold,
                $carTiempFlujoMo,$carRetarEnfria,$carCoolTime,
                
                $txtempuPresi1,$txtempuPresi2,$txtempuPresi3,$txtempuPresi4,$txtempudelay1,$txtemputiemp1,$txtemputiemp2,$txtempupisici,
                $txtempucorreAtr,$txtempuveloc1,$txtempuveloc2,$txtempuveloc3,$txtempuveloc4,
                
                $txtprecieOpnStr,$txtprescierr_presio1 ,$txtprescierr_presio2 ,$txtprescierr_presio3 ,$txtprescierr_presio4 ,
                $txtprescierr_velo1 ,$txtprescierr_velo2 ,$txtprescierr_velo3,$txtprescierr_velo5 , $txtprescierr_posic1 ,
                $txtprescierr_posic2 ,$txtprescierr_posic3 ,$txtprescierr_posic4 ,$txtprescierr_presi5 ,$txtprescierr_presi6 ,
                $txtprescierr_presi7 ,$txtprescierr_presi8 ,$txtprescierr_veloc5 ,$txtprescierr_veloc6 ,$txtprescierr_veloc7 ,
                $txtprescierr_veloc8,$txtprescierr_posic5,$txtprescierr_posic6 ,
                $txtprescierr_posic7 ,$txtprescierr_posic8,$horas,$canxturno
            );
                print_r($c_formulacion);
            }else{print_r($return);}
           
        }


        static function validardatosfor($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $inicio,$fin,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$txttemp6,$txttemp7,$txttemp8,$txttemp9,
        $inyeccion,$soplado,$estilomolde,$items,$horas)
        {
            $m_produccion = new m_produccion();
            if(strlen(trim($produc)) == 0){return "Error seleccione formula";}
            if($sltipoprod == 'E'){
                if(strlen(trim($cliente)) == 0){return "Error seleccione cliente para formula";}
            }
            if(strlen(trim($molde)) == 0){return "Error seleccione molde para la formula";}
            if(strlen(trim($cavidades)) == 0){return "Error ingrese cavidades formula";}
            if(strlen($cavidades) > 20){return "Error cavidades no puede se mayor a 20 caracteres";}
            if(strlen(trim($ciclo)) == 0){return "Error ingrese ciclo formula";}
            if(strlen($ciclo) > 20){return "Error ciclo no puede se mayor a 20 caracteres";}
            if(strlen(trim($pesouni)) == 0){return "Error ingrese peso unitario del material";}
            if(strlen($pesouni) > 20){return "Error peso unitario no puede se mayor a 20 caracteres";}
            $cantidad = explode(".", $procant);

            if(strlen(trim($horas)) == 0){return "Error horas por turno";}
            if(!is_numeric($horas)){return "Error solo numero en horas por turno";}

            if($inicio == ""){return "Error ingrese fecha de inicion";}
            if($fin == ""){return  "Error ingrese fecha fin";}

            $fecha_inicio = strtotime($inicio);
            $fecha_fin = strtotime($fin);
            if($fecha_inicio > $fecha_fin ){
                return "Errro fecha fin no puede ser menor a fecha de inicio";
            }
            if(strlen($cantidad[0]) > 7){return "Error campo cantidad, maximo 7 digitos";}
            if(!is_numeric($procant)){return "Error solo numeros en cantidad de la formula".$procant; }


            //temperatura
            if(strlen(trim($tempera1)) == 0){return "Error ingrese temperatura";}
            if(!is_numeric($tempera1)){return "Error solo numeros en temperatura";}
            if(strlen(trim($tempera2)) == 0){return "Error ingrese temperatura";}
            if(!is_numeric($tempera2)){return "Error solo numeros en temperatura";}
            if(strlen(trim($tempera3)) == 0){return "Error ingrese temperatura";}
            if(!is_numeric($tempera3)){return "Error solo numeros en temperatura";}
            if(strlen(trim($tempera4)) == 0){ return "Error ingrese temperatura";}
            if(!is_numeric($tempera4)){return "Error solo numeros en temperatura";}
            if(strlen(trim($tempera5)) == 0){ return "Error ingrese temperatura";}
            if(!is_numeric($tempera5)){return "Error solo numeros en temperatura";}
            if($estilomolde == "S"){
                if(!is_numeric($txttemp6)){return "Error solo numeros en temperatura";}
                if(strlen(trim($txttemp6)) == 0){return "Error ingrese temperatura";}
                if(!is_numeric($txttemp7)){return "Error solo numeros en temperatura";}
                if(strlen(trim($txttemp7)) == 0){return "Error ingrese temperatura";}
                if(!is_numeric($txttemp8)){return "Error solo numeros en temperatura";}
                if(strlen(trim($txttemp8)) == 0){return "Error ingrese temperatura";}
                if(!is_numeric($txttemp9)){return "Error solo numeros en temperatura";}
                if(strlen(trim($txttemp9)) == 0){return "Error ingrese temperatura";}
                
                for ($i=0; $i < count($soplado) ; $i++) { 
                    if(strlen(trim($soplado[$i])) == 0){return "Error ingrese parametros de Timer LF";}
                    if(!is_numeric($soplado[$i])){return "Error solo numeros en parametros de Timer LF";}
                    if(c_produccion::cantidigito($soplado[$i])){return "Error maximo solo 5 digitos en Timer LF";}
                }
            }

            if($estilomolde == "I"){
                for ($i=0; $i < count($inyeccion) ; $i++) { 
                    if(strlen(trim($inyeccion[$i])) == 0){return "Error ingrese parametros de producción";}
                    if(!is_numeric($inyeccion[$i])){return "Error solo numeros en parametros de producción";}
                    if(c_produccion::cantidigito($inyeccion[$i])){return "Error maximo solo 5 digitos en parametros de producción";}
                }
            }
       
            $cadena = "COD_FORMULACION = '$codform' AND EST_FORMULACION = '1'";
            $c_itemformula = $m_produccion->m_buscar("T_FORMULACION_ITEM",$cadena);
            $cadena2 = "formula = '$codform'";
            $c_cabecera = $m_produccion->m_buscar("V_CABECERA_FORMULACION",$cadena2);
            for ($i=0; $i < count($c_itemformula); $i++) { 
                $total = 0;
                foreach ($items->tds as $dato){
                    $cadenstock = "COD_PRODUCTO = '$dato[1]'";
                    $stock = $m_produccion->m_buscar("T_ALMACEN_INSUMOS",$cadenstock);
                    if($dato[2] > $stock[0][4] && $dato[3] != 'E'){
                        return "Error stock insuficiente ";
                        break;
                    }
                    if($c_itemformula[$i][1] == $dato[1]){
                        $total += $dato[2];
                    }
                }
                $procant1 = $procant * $c_itemformula[$i][2];
                $procant1  = $procant1 / $c_cabecera[0][4];
              
                $procant1 = sprintf("%0.3f",$procant1);
                $total = sprintf("%0.3f",$total);  
                if($total != $procant1){
                    return "Error las cantidades no son iguales";
                   break;
                }
            }
            return '';
        }
        
       static function cantidigito($procant)
       {
            $cantidad = explode(".", $procant);
            if(strlen($cantidad[0]) > 7){return true;}
            else{return false;}
       }

       static function c_guardarexterno($codpro,$cantidad)
       {
           $m_produccion = new m_produccion();
           $c_produccion = $m_produccion->m_galmancen_exter($codpro,$cantidad);
           $dato = array('dato' => $c_produccion);
           echo json_encode($dato,JSON_FORCE_OBJECT);
       }
        
       static function c_updateexteno($codpro ,$cantidad,$tipo){
            $m_produccion = new m_produccion();
            $c_produccion = $m_produccion->m_updateexteno($codpro,$cantidad);
            print_r($c_produccion);
       }

       static function c_pasadas($insumo)
       {
            $m_producto = new m_produccion();
            $cadena = "producto = '$insumo'";
            $c_producto = $m_producto->m_buscar('V_INSUMOS_PASADAS',$cadena);
            $dato = array(
                'dato' => $c_producto, 
            );
           
       }

       static function c_confirmacion($confirmacion){
            $m_produccion = new m_produccion();
            $c_produccion = $m_produccion->m_confirmacion($confirmacion);
            $dato = array(
                "d" => $c_produccion,
                "b" =>  "D"
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
       }
}
?>