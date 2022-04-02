<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_stockproducto.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];  
    if($accion == 'buscar'){
        $filtro = $_POST['filtro'];
        $cod = $_POST['cod'];
        $categoria  = $_POST['categoria'];
        c_stockproducto::c_buscarprod($filtro,$cod,$categoria);     
    }else if( $accion =='lstmaterial'){
        c_stockproducto::c_filtarproducto();
    }else if($accion == 'slccategiria'){
        c_stockproducto::c_categoria();
    }

 
    class c_stockproducto
    {
        static function c_categoria(){
            $m_formula = new m_stockproducto();
            $cadena = "EST_CATEGORIA = '1'";
            $c_formula = $m_formula->m_buscar('T_CATEGORIA',$cadena);
            $dato = array('dato' => $c_formula);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarprod($filtro,$cod,$categoria)
        {
            $m_producto = new m_stockproducto();
            $filcate = ($categoria == '') ? "''=''" : "COD_CATEGORIA = '$categoria'";
           
            if($filtro == ""){
                $cadena = "'' = '' AND $filcate";
            }else if($filtro == "c"){
                $cadena = "STOCK_ACTUAL != '0' AND $filcate";
            }else if($filtro == 's'){
                $cadena = "STOCK_ACTUAL = '0' AND $filcate";
            }else if($filtro == 'p'){
                $cadena = "COD_PRODUCTO = '$cod' AND $filcate";
            }
           
            $c_producto = $m_producto->m_buscar('V_STOCK_GENERAL',$cadena);
            //$c_terminado = $m_producto->m_buscar('V_STOCK_TERMINADO',$cadena);
            
            //$array_resultante= array_merge($c_producto,$c_terminado);
            $dato = array('dato' => $c_producto);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtarproducto()
        {
            $material = array();
            $m_personal = new m_stockproducto();
            $cadena = "EST_PRODUCTO = '1' ";
            $c_material = $m_personal->m_buscar('V_STOCK_GENERAL',$cadena);
            for ($i=0; $i < count($c_material) ; $i++) { 
                array_push($material,array(
                    "code" => $c_material[$i][0],
                    "label" => $c_material[$i][1],
                    "stock" => $c_material[$i][5])
                );
            }
            $dato = array(
                'dato' => $material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 
       
}
?>