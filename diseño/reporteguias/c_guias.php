<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_guias.php");

    $accion = $_POST['accion'];
    if($accion == 'filtrar'){
        c_guias::c_listarecibos();
    }else if($accion == 'buscar'){
        $dato = $_POST['nro'];
        c_guias::c_buscar($dato);
    }
    class c_guias
    {
        static function c_buscar($id){
           
            $m_producto = new m_guias();
            $cadena = "COD_COMPROBANTE = '$id'";
            $c_detalle = $m_producto->m_buscar('T_DETACOMP',$id);
            $dato = Array(
                'dato' =>  $c_detalle,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        
        static function c_listarecibos()
        {
            $m_producto = new m_guias();
            $c_recibos = $m_producto->m_lstrecibos();
            $dato = Array(
                'dato' =>$c_recibos,
                'mensaje' => 'success'
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


    }
?>