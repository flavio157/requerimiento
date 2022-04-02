<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_kardex.php");

    $accion = $_POST['accion'];
    if($accion == 'producto'){
        $codalmacen = oficiona($_POST['oficina']);
       c_kardex::c_listarproductos($codalmacen);
    }else if($accion == 'filtrar'){
        $fecini = $_POST['fecini'];
        $fecfin = $_POST['fecfin'];
        $id = $_POST['id'];
        c_kardex::c_filtrarkardexI($fecini,$fecfin,$id);
    }
    class c_kardex
    {
        static function c_listarproductos($codalmacen){
            $producto = array();
            $m_producto = new m_kardex();
            $cadena = "EST_PRODUCTO = '1'";
            $c_producto = $m_producto->m_buscar('V_BUSCAR_MATERIALES',$cadena);
            
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1],
                    "stock" => $c_producto[$i][5],)
                );    
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtrarkardexI($fecini,$fecfin,$id){
            date_default_timezone_set('America/Lima');
            $inicio = strtotime($fecini);
            $fin  = strtotime($fecfin);
            $mensaje ="";
            $c_kardex="";
            if($fecini == ""){$mensaje = "Error seleccione fecha inicio";}
            else if($fecfin == ""){$mensaje = "Error seleccione fecha fin";}
            else if($inicio > $fin){ $mensaje = "Error fecha fin no puede ser menor a fecha inicio";}
            else if($id == ""){$mensaje = "Error producto invalido";}
            else{
                $m_producto = new m_kardex();
                $cadena = "CAST(fecha as date) >= '$fecini' AND CAST(fecha as date) <= '$fecfin' AND producto = '$id' ORDER BY fecha ASC";
                $c_kardex = $m_producto->m_buscar('V_KARDEX',$cadena);
                if(count($c_kardex) == 0){$mensaje = "No hay movimientos con el producto seleccionado";}
                else{
                    $mensaje = "success";   
                }
            }
            $dato = Array(
                'mensaje' =>$mensaje,
                'dato' => $c_kardex,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    }
?>