<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_stockproducto.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];  
    if($accion == 'buscar'){
        $formula = $_POST['formula'];
        $fecha = $_POST['fecha'];
        c_stockproducto::c_buscarprod($formula,$fecha);     
    }else if( $accion =='lstmaterial'){
        c_stockproducto::c_filtarformula();
    }

 
    class c_stockproducto
    {

        static function c_buscarprod($formula,$fecha)
        {
            $mensaje = "";
            $m_producto = new m_stockproducto();
            if(strlen(trim($formula)) > 0){$mensaje = "Error seleccione formula";}
            if(strlen(trim($fecha)) > 0){$mensaje = "Error seleccion fecha";}
            if($mensaje != ""){
                $fecha = retunrFechaSqlphp($fecha);
                $cadena ="formulacion = '$formula'
                and CAST(fecharegistro as date) = '$fecha'";
                $c_producto = $m_producto->m_buscar('V_LISTAR_PRODUCCION',$cadena);
                $dato = array('dato' => $c_producto);
            }else{
                $dato = array('dato' => "",'m' => $mensaje);
            }
          

            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtarformula()
        {
            $material = array();
            $m_personal = new m_stockproducto();
            $cadena = "'' = '' ";
            $c_material = $m_personal->m_buscar('T_FORMULACION',$cadena);
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