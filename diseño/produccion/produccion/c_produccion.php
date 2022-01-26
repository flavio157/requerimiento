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
        $tipo = $_POST['tipo'];
        c_produccion::veristock($txtcant,$cantxusar,$codpro,$tipo);
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
        $codform = $_POST['txtform'];
        $produc = $_POST['txtprod'];
        $sltipoprod = $_POST['sltipoprod'];
        $cliente = $_POST['txtcodclie'];
        $molde = $_POST['txtcodmolde'];
        $cavidades = $_POST['txtcavidades'];
        $pesouni = $_POST['txtpesouni'];
        $ciclo = $_POST['txtciclo'];
        $procant = $_POST['txtprodcant'];
        $almacen = $_POST['slctipoalmacen'];

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
        $cambios = $_POST['modified'];
        c_produccion::c_guardarproduccion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $almacen,$tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items,$cambios);
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
    }else if($accion == 'lstalmacen'){
        c_produccion::lstalmacen();
    }else if($accion== 'parametros'){
        $produccion = $_POST['produccion'];
        c_produccion::c_parametros($produccion);
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


        static function lstalmacen(){
            $m_formula = new m_produccion();
            $cadena = "TIPO_ALMACEN = '1'";
            $c_almacen = $m_formula->m_buscar('T_ALMACEN',$cadena);
            $dato = array('dato' => $c_almacen);
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
                if($c_cliente != 1){
                    $mensaje = $c_cliente; $codigo = '';
                }else{
                    $mensaje = $c_cliente[0]; $codigo = $c_cliente[1];
                }
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
                if($c_molde != 1){
                    $mensaje = $c_molde; $codigo = '';
                }else{
                    $mensaje = $c_molde[0]; $codigo = $c_molde[1];
                }
            }
            
            $dato = array('e' =>  $mensaje,'c' =>  $codigo);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_guardarproduccion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $almacen,$tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items,$cambios)
        {
            $m_produccion = new m_produccion();
            $return = c_produccion::validardatosfor($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
            $almacen,array($tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
            $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
            $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
            $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
            $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
            $posicion1,$tiempo),$items);
        
            if($return == ''){
                $c_formulacion = $m_produccion->m_guardarformulacion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
                $almacen,$tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
                $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
                $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
                $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
                $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
                $posicion1,$tiempo,$usu,$items,$cambios);
                print_r($c_formulacion);
            }else{print_r($return);}
           
        }


        static function validardatosfor($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $almacen,$datos,$items)
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
            if(strlen(trim($almacen)) == 0){return "Error seleccione el almacen";}
            if(strlen($cantidad[0]) > 7){print_r("Error campo cantidad, maximo 7 digitos");return;}
            if(!is_numeric($procant)){return "Error solo numeros en cantidad de la formula"; }

            for ($i=0; $i < count($datos) ; $i++) { 
                if(strlen(trim($datos[$i])) == 0){return "Error ingrese parametros de producción";}
                if(!is_numeric($datos[$i])){return "Error solo numeros en parametros de producción";}
                if(c_produccion::cantidigito($datos[$i])){return "Error maximo solo 5 digitos en parametros de producción";}
                if($datos[$i] == 0){return "Error los parametros no pueden ser 0";}
            }
            $cadena = "COD_FORMULACION = '$codform' AND EST_FORMULACION = '1'";
            $c_itemformula = $m_produccion->m_buscar("T_FORMULACION_ITEM",$cadena);
            $cadena2 = "formula = '$codform'";
            $c_cabecera = $m_produccion->m_buscar("V_CABECERA_FORMULACION",$cadena2);
            for ($i=0; $i < count($c_itemformula); $i++) { 
                $total = 0;
            
                foreach ($items->tds as $dato){
                    $cadenstock = "COD_PRODUCTO = '$dato[0]'";
                    $stock = $m_produccion->m_buscar("T_ALMACEN_INSUMOS",$cadenstock);
                    if($dato[2] > $stock[0][4] && $dato[3] != 'E'){
                        return "Error stock insuficiente";
                        break;
                    }
                  
                    if($c_itemformula[$i][1] == $dato[0]){
                        $total += $dato[2];
                    }
                }
                
                if($total != number_format((($procant * $c_itemformula[$i][2]) / $c_cabecera[0][4]), 3, '.', '')){
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
            echo json_encode($dato,JSON_FORCE_OBJECT);
       }
}
?>