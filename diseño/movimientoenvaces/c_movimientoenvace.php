<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_movimientoenvace.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];  
    if($accion == 'buscarxproducto'){
        c_movimientoenvace::c_buscarxformula();     
    }else if($accion == 'buscarcli'){
        c_movimientoenvace::c_buscarclien();
    }else if($accion == 'guia'){
        c_movimientoenvace::c_guia();
    }else if($accion == 'guardargui'){
        $cod_guia = $_POST['lblguia'];
        $cliente = $_POST['txtcodclie'];
        $direccion = $_POST['txtdireccion'];
        $observacion = $_POST['txtobservacion'];
        $fecha = $_POST['fecha'];
        $usu = $_POST['usu'];
        $producto = json_decode($_POST['producto']);
        c_movimientoenvace::c_guardarguia($cod_guia,$cliente,$fecha,$direccion,$observacion,$usu,$producto);
    }else if($accion == 'validarpro'){
        $codenvace = $_POST['codenvace'];
        $cantidad = $_POST['cantidad'];
        c_movimientoenvace::m_validarenvaces($codenvace,$cantidad);
    }else if($accion == 'devolver'){
        $codenvace = $_POST['codenvace'];
        $cantidad = $_POST['cantidad'];
        c_movimientoenvace::m_devolver_stock($codenvace,$cantidad);
    }else if($accion == 'gcliente'){
        $cliente = $_POST['txtnombcliente'];
        $direccion = $_POST['txtdireccliente'];
        $ruc = $_POST['txtidenticliente'];
        $usu = $_POST['usu'];
        c_movimientoenvace::c_guardarclie($cliente,$direccion,$ruc,$usu);
    }
 
    class c_movimientoenvace
    {
        static function c_buscarxformula()
        {
            $m_producto = new m_movimientoenvace();
            $producto = array();
            $cadena = "'' = ''";
            $c_producto = $m_producto->m_buscar('V_STOCK_TERMINADO',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1],
                    "stock" => $c_producto[$i][5]));
            }
            $dato = array('dato' => $producto);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 

        static function c_buscarclien()
        { $cliente = array();
            $m_almacen = new m_movimientoenvace(); 
            $cadena = "''= ''";
            $c_producto = $m_almacen->m_buscar('T_CLIENTE_MOLDE',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($cliente,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1],
                    "direccion" => $c_producto[$i][2]));
            }
            $dato = array('dato' => $cliente);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
       
        static function c_guia()
        {
           $m_guia = new m_movimientoenvace();
           $c_almacen = $m_guia->m_select_generarcodigo('COD_MOVIMIENTO','T_MOVIM_ENVACE','9');
           print_r($c_almacen);
        }

        static function c_guardarguia($cod_guia,$cliente,$fecha,$direccion,$observacion,$usu,
        $producto){
            $m_guardar = new m_movimientoenvace();
            $mensaje = c_movimientoenvace::validardatos($cod_guia,$cliente,$direccion,$observacion,$producto);
            if($mensaje ==''){
                $c_guardar =$m_guardar->m_guardar($cod_guia,$cliente,$fecha,strtoupper($direccion)
                ,strtoupper($observacion),$usu,$producto);
                print_r($c_guardar);
            }else{
                print_r($mensaje);
            }
        }   

        static function validardatos($cod_guia,$cliente,$direccion,$observacion,$producto)
        {
           if(strlen(trim($cod_guia)) < 9){return "Error numero de guia invalido";} 
           if(strlen(trim($cliente)) == 0){return "Error seleccione cliente";}     
           if(strlen(trim($observacion)) == 0){return "Error ingrese observacion";} 
           if(strlen(trim($observacion)) > 200){return "Error observacion maximo 200 caracteres";} 
           if(count($producto->tds)==0){return "Error ingrese envaces";}
           return ''; 
        } 

        static function m_validarenvaces($codenvac,$cantidad){
            $m_producto = new m_movimientoenvace();
            if(strlen(trim($codenvac)) == 0){print_r("Error seleccione el envaces"); return;}
            if(strlen(trim($cantidad)) == 0){print_r("Error ingrese cantidad"); return;}
            if(!is_numeric($cantidad)){print_r("Error solo numeros en cantidad"); return;}
            $cadena = "codigo = '$codenvac'";
            $c_producto = $m_producto->m_buscar('V_STOCK_TERMINADO',$cadena);
            if(count($c_producto) > 0){
                if($cantidad > $c_producto[0][5]){
                   print_r("Error no hay suficiente stock en almacen"); return;
                }else{
                    $cantidad = $c_producto[0][5] - $cantidad;
                }
            }else{
                print_r("Error no se encontro el envace"); return;
            }
            $retu = $m_producto->m_stock($codenvac,$cantidad);
            print_r($retu);
        }

        static function m_devolver_stock($codenvac,$cantidad)
        {
            $m_producto = new m_movimientoenvace();
            $cadena = "codigo = '$codenvac'";
            $c_producto = $m_producto->m_buscar('V_STOCK_TERMINADO',$cadena);
            if(count($c_producto) == 0){
                print_r("Error no se encontro el envace"); return; 
            }
            $cantidad = $cantidad + $c_producto[0][5];
            $retu = $m_producto->m_stock($codenvac,$cantidad);
            print_r($retu);
        }
                                                   
        static function c_guardarclie($cliente,$direccion,$ruc,$usu){
            $mensaje = "";$datos = '';
            $m_guardar = new m_movimientoenvace();
            if(!is_numeric($ruc)){$mensaje = "Error solo numeros en el RUC";}
            if(strlen(trim($ruc)) > 11){$mensaje = "Error ruc maximo 11 caracteres";}
            if(strlen(trim($cliente)) == 0){$mensaje = "Error ingrese cliente";}
            if(strlen($cliente) > 50){$mensaje = "Error cliente maximo 50 caracteres";}
            if($mensaje == ''){
                $c_guardar =$m_guardar->m_guardarclie(strtoupper($cliente),
                strtoupper($direccion),$ruc,$usu);
                $datos = $c_guardar;
            }else{
                $datos = Array("0",$mensaje);
            }
            echo json_encode($datos,JSON_FORCE_OBJECT);
        }
}
?>