<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_produccion.php");

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
        c_produccion::veristock($txtcant,$cantxusar,$codpro);
    }else if($accion == 'buscarmolde'){
        $t = $_POST['t'];
        $code = $_POST['code'];
        c_produccion::c_buscarmolde($t,$code);
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
        $produc = $_POST['txtprod'];
        $sltipoprod = $_POST['sltipoprod'];
        $cliente = $_POST['txtcodclie'];
        $molde = $_POST['txtcodmolde'];
        $cavidades = $_POST['txtcavidades'];
        $pesouni = $_POST['txtpesouni'];
        $ciclo = $_POST['txtciclo'];
        $procant = $_POST['txtprodcant'];


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
        $contrac1 = $_POST['contrac1'];
        $contrac2 = $_POST['contrac2'];
        $contrac3 = $_POST['contrac3'];
        $contrac4 = $_POST['contrac4'];
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
        c_produccion::c_guardarproduccion($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items);
    }

 
    class c_produccion
    {
        static function c_buscarxformula()
        {
            $producto = array();
            $m_producto = new m_produccion();
            $cadena = "'' = ''";
            $c_producto = $m_producto->m_buscar('V_CABECERA_FORMULACION',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "prod" => $c_producto[$i][2],
                    "cant" => $c_producto[$i][4],
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

        static function veristock($txtcant,$cantxusar,$codprod)
        {
            $mensaje ='';
            $stock = c_produccion::c_stock($codprod,0);
            if($txtcant > $stock){$mensaje = "Error no hay stock suficiente";}
            if($txtcant > $cantxusar){$mensaje = "Error cantidad por usar debe ser igual a cantidad";}
            if($txtcant < $cantxusar){$mensaje = "Error cantidad por usar debe ser igual a cantidad";}
            if($mensaje != ''){$dato = array('tipo'=> 1 ,'dato' => $mensaje);}
            else{$dato = array('tipo'=> 0 ,'dato' => $txtcant);}
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarmolde($t,$code)
        {
            $producto = array();
            $m_producto = new m_produccion();
            $cadena = "COD_CLIENTE = '$code' or TIPO_MOLDE = '$t' and ESTADO = '1'";
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
                $mensaje = $c_cliente[0]; $codigo = $c_cliente[1];
            }
            
            $dato = array('e' => $mensaje,'c' => $codigo);
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
                $mensaje = $c_molde[0]; $codigo = $c_molde[1];
            }
            $dato = array(
                'e' =>  $mensaje,
                'c' =>  $codigo
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_guardarproduccion($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items)
        {
            $m_produccion = new m_produccion();
            $return = c_produccion::validardatosfor($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
            $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
            $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
            $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
            $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
            $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
            $posicion1,$tiempo,$items);

            if($return == ''){
                $c_formulacion = $m_produccion->m_guardarformulacion($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
                $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
                $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
                $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
                $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
                $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
                $posicion1,$tiempo,$usu,$items);
                print_r($c_formulacion);
            }else{print_r($return);}
           
        }


        static function validardatosfor($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$items)
        {
         
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
            if(strlen($cantidad[0]) > 7){print_r("Error campo cantidad, maximo 7 digitos");return;}
            if(!is_numeric($procant)){return "Error solo numeros en cantidad de la formula"; }
            //temperatura
            if(strlen(trim($tempera1)) == 0){return "Error ingrese temperatura 1";}
            if(!is_numeric($tempera1)){return "Error solo numeros en temperatura 1";}
            if(c_produccion::cantidigito($tempera1)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($tempera2)) == 0){return "Error ingrese temperatura 2";}
            if(!is_numeric($tempera2)){return "Error solo numeros en temperatura 2";}
            if(c_produccion::cantidigito($tempera2)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($tempera3)) == 0){return "Error ingrese temperatura 3";}
            if(!is_numeric($tempera3)){return "Error solo numeros en temperatura 3";}
            if(c_produccion::cantidigito($tempera3)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($tempera4)) == 0){ return "Error ingrese temperatura 4";}
            if(!is_numeric($tempera4)){return "Error solo numeros en temperatura 4";}
            if(c_produccion::cantidigito($tempera4)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($tempera5)) == 0){ return "Error ingrese temperatura 5";}
            if(!is_numeric($tempera5)){return "Error solo numeros en temperatura 5";}
            if(c_produccion::cantidigito($tempera5)){return "Error maximo solo 5 digitos";}
            
            //
            //Botadores Expul.
            if(strlen(trim($presexplu1)) == 0){ return "Error ingrese presión de botadores de expulsión 1";}
            if(strlen(trim($presexplu2)) == 0){ return "Error ingrese presión de botadores de expulsión 2";}
            if(!is_numeric($presexplu1)){return "Error solo numeros en presión de botadores de expulsión 1";}
            if(!is_numeric($presexplu2)){return "Error solo numeros en presión de botadores de expulsión 2";}

            if(c_produccion::cantidigito($presexplu1)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($presexplu2)){return "Error maximo solo 5 digitos";}

            if(strlen(trim($velexplu1)) == 0){ return "Error ingrese velocidad de botadores de expulsión 1";}
            if(strlen(trim($velexplu2)) == 0){ return "Error ingrese velocidad de botadores de expulsión 2";}
            if(!is_numeric($velexplu1)){return "Error solo numeros en velocidad de botadores de expulsión 1";}
            if(!is_numeric($velexplu2)){return "Error solo numeros en velocidad de botadores de expulsión 2";}

            if(c_produccion::cantidigito($velexplu1)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($velexplu2)){return "Error maximo solo 5 digitos";}
           
            if(strlen(trim($pisiexplu1)) == 0){ return "Error ingrese pisición de botadores de expulsión 1";}
            if(strlen(trim($pisiexplu2)) == 0){ return "Error ingrese pisición de botadores de expulsión 2";}
            if(!is_numeric($pisiexplu1)){return "Error solo numeros en pisición de botadores de expulsión 1";}
            if(!is_numeric($pisiexplu2)){return "Error solo numeros en pisición de botadores de expulsión 2";}
            
            if(c_produccion::cantidigito($pisiexplu1)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($pisiexplu2)){return "Error maximo solo 5 digitos";}
            //
        
            //Botadores Contract
            if(strlen(trim($contrac1)) == 0){ return "Error ingrese botadores contrac. 2";}
            if(strlen(trim($contrac2)) == 0){ return "Error ingrese botadores contrac. 1";}
            if(!is_numeric($contrac3)){return "Error solo numeros en botadores contrac. 2";}
            if(!is_numeric($contrac4)){return "Error solo numeros en botadores contrac. 1";}
           
            if(c_produccion::cantidigito($contrac1)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($contrac2)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($contrac3)){return "Error maximo solo 5 digitos";}
            if(c_produccion::cantidigito($contrac4)){return "Error maximo solo 5 digitos";}
            //carga
            if(strlen(trim($cargapres1)) == 0){ return "Error ingrese cargar presión 1";}
            if(!is_numeric($cargapres1)){return "Error solo numeros en cargar presión 1";}
            if(c_produccion::cantidigito($cargapres1)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapres2)) == 0){ return "Error ingrese cargar presión 2";}
            if(!is_numeric($cargapres2)){return "Error solo numeros en cargar presión 2";}
            if(c_produccion::cantidigito($cargapres2)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapres3)) == 0){ return "Error ingrese cargar presión 3";}
            if(!is_numeric($cargapres3)){return "Error  solo numeros en cargar presión 3";}
            if(c_produccion::cantidigito($cargapres3)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapresucc)) == 0){ return "Error ingrese cargar presión succiona";}
            if(!is_numeric($cargapresucc)){return "Error solo numeros en cargar presión succiona";}
            if(c_produccion::cantidigito($cargapresucc)){return "Error maximo solo 5 digitos";}

            if(strlen(trim($cargavel1)) == 0){ return "Error ingrese cargar velocidad 1";}
            if(!is_numeric($cargavel1)){return "Error solo numeros en cargar velocidad 1";}
            if(c_produccion::cantidigito($cargavel1)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargavel2)) == 0){ return "Error ingrese cargar velocidad 2";}
            if(!is_numeric($cargavel2)){return "Error solo numeros en cargar velocidad 2";}
            if(c_produccion::cantidigito($cargavel2)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargavel3)) == 0){ return "Error ingrese cargar velocidad 3";}
            if(!is_numeric($cargavel3)){return "Error  solo numeros en cargar velocidad 3";}
            if(c_produccion::cantidigito($cargavel3)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargavelsucc)) == 0){ return "Error ingrese cargar velocidad succiona";}
            if(!is_numeric($cargavelsucc)){return "Error solo numeros en cargar velocidad succiona";}
            if(c_produccion::cantidigito($cargavelsucc)){return "Error maximo solo 5 digitos";}

            if(strlen(trim($cargapisi1)) == 0){ return "Error ingrese cargar posicion 1";}
            if(!is_numeric($cargapisi1)){return "Error solo numeros en cargar posicion 1";}
            if(c_produccion::cantidigito($cargapisi1)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapisi2)) == 0){ return "Error ingrese cargar posicion 2";}
            if(!is_numeric($cargapisi2)){return "Error solo numeros en cargar posicion 2";}
            if(c_produccion::cantidigito($cargapisi2)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapisi3)) == 0){ return "Error ingrese cargar posicion 3";}
            if(!is_numeric($cargapisi3)){return "Error  solo numeros en cargar posicion 3";}
            if(c_produccion::cantidigito($cargapisi3)){return "Error maximo solo 5 digitos";}
            if(strlen(trim($cargapisisucci)) == 0){ return "Error ingrese cargar posicion succiona";}
            if(!is_numeric($cargapisisucci)){return "Error solo numeros en cargar posicion succiona";}
            if(c_produccion::cantidigito($cargapisisucci)){return "Error maximo solo 5 digitos";}
            //

            //inyecion 
                if(strlen(trim($inyecpres4)) == 0){ return "Error ingrese inyeccion presión 4";}
                if(!is_numeric($inyecpres4)){return "Error solo numeros en inyeccion presión 4";}
                if(c_produccion::cantidigito($inyecpres4)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecpres3)) == 0){ return "Error ingrese inyeccion presión 3";}
                if(!is_numeric($inyecpres3)){return "Error solo numeros en inyeccion presión 3";}
                if(c_produccion::cantidigito($inyecpres3)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecpres2)) == 0){ return "Error ingrese inyeccion presión 2";}
                if(!is_numeric($inyecpres2)){return "Error  solo numeros en inyeccion presión 2";}
                if(c_produccion::cantidigito($inyecpres2)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecpres1)) == 0){ return "Error ingrese inyeccion presión 1";}
                if(!is_numeric($inyecpres1)){return "Error  solo numeros en inyeccion presión 1";}
                if(c_produccion::cantidigito($inyecpres1)){return "Error maximo solo 5 digitos";}

                if(strlen(trim($inyecvelo4)) == 0){ return "Error ingrese inyeccion velocidad 4";}
                if(!is_numeric($inyecvelo4)){return "Error solo numeros en inyeccion velocidad 4";}
                if(c_produccion::cantidigito($inyecvelo4)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecvelo3)) == 0){ return "Error ingrese inyeccion velocidad 3";}
                if(!is_numeric($inyecvelo3)){return "Error solo numeros en inyeccion velocidad 3";}
                if(c_produccion::cantidigito($inyecvelo3)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecvelo2)) == 0){ return "Error ingrese inyeccion velocidad 2";}
                if(!is_numeric($inyecvelo2)){return "Error  solo numeros en inyeccion velocidad 2";}
                if(c_produccion::cantidigito($inyecvelo2)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecvelo1)) == 0){ return "Error ingrese inyeccion velocidad 1";}
                if(!is_numeric($inyecvelo1)){return "Error  solo numeros en inyeccion velocidad 1";}
                if(c_produccion::cantidigito($inyecvelo1)){return "Error maximo solo 5 digitos";}

                if(strlen(trim($inyecposi4)) == 0){ return "Error ingrese inyeccion posición 4";}
                if(!is_numeric($inyecposi4)){return "Error solo numeros en inyeccion posición 4";}
                if(c_produccion::cantidigito($inyecposi4)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecposi3)) == 0){ return "Error ingrese inyeccion posición 3";}
                if(!is_numeric($inyecposi3)){return "Error solo numeros en inyeccion posición 3";}
                if(c_produccion::cantidigito($inyecposi3)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecposi2)) == 0){ return "Error ingrese inyeccion posición 2";}
                if(!is_numeric($inyecposi2)){return "Error  solo numeros en inyeccion posición 2";}
                if(c_produccion::cantidigito($inyecposi2)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyecposi1)) == 0){ return "Error ingrese inyeccion posición 1";}
                if(!is_numeric($inyecposi1)){return "Error  solo numeros en inyeccion posición 1";}
                if(c_produccion::cantidigito($inyecposi1)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($inyectiemp)) == 0){ return "Error ingrese inyeccion tiempo";}
                if(!is_numeric($inyectiemp)){return "Error solo numeros en inyeccion tiempo";}
                if(c_produccion::cantidigito($inyectiemp)){return "Error maximo solo 5 digitos";}
            ///

            //Presion
                if(strlen(trim($velocidad3)) == 0){ return "Error ingrese presión velocidad 3";}
                if(!is_numeric($velocidad3)){return "Error solo numeros en presión velocidad 3";}
                if(c_produccion::cantidigito($velocidad3)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($velocidad2)) == 0){ return "Error ingrese presión velocidad 2";}
                if(!is_numeric($velocidad2)){return "Error solo numeros en presión velocidad 2";}
                if(c_produccion::cantidigito($velocidad2)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($velocidad1)) == 0){ return "Error ingrese presión velocidad 1";}
                if(!is_numeric($velocidad1)){return "Error  solo numeros en presión velocidad 1";}
                if(c_produccion::cantidigito($velocidad1)){return "Error maximo solo 5 digitos";}

                if(strlen(trim($posicion3)) == 0){ return "Error ingrese presión posición 3";}
                if(!is_numeric($posicion3)){return "Error solo numeros en presión posición 3";}
                if(c_produccion::cantidigito($posicion3)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($posicion2)) == 0){ return "Error ingrese presión posición 2";}
                if(!is_numeric($posicion2)){return "Error solo numeros en presión posición 2";}
                if(c_produccion::cantidigito($posicion2)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($posicion1)) == 0){ return "Error ingrese presión posición 1";}
                if(!is_numeric($posicion1)){return "Error  solo numeros en presión posición 1";}
                if(c_produccion::cantidigito($posicion1)){return "Error maximo solo 5 digitos";}
                if(strlen(trim($tiempo)) == 0){ return "Error ingrese presión tiempo";}
                if(!is_numeric($tiempo)){return "Error solo numeros en presión tiempo";}
                if(c_produccion::cantidigito($tiempo)){return "Error maximo solo 5 digitos";}
            ///

            ///items
            foreach ($items->tds as $dato){
                if($dato[1] != $dato[2]){
                   return "Error cantidad por usar debe ser igual a cantidad del insumo";
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
        
}
?>