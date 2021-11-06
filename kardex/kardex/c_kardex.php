<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_kardex.php");

    $accion = $_POST['accion'];
    if($accion == 'producto'){
       c_kardex::c_listarproductos();
    }else if($accion == 'filtrar'){
        $fecini = $_POST['fecini'];
        $fecfin = $_POST['fecfin'];
        $id = $_POST['id'];
        $emision = strtotime($fecini);
        $entrega  = strtotime($fecfin);
        if($emision > $entrega){print_r("Error fecha fin no puede ser menor a fecha inicio"); return;}
        if($fecini == ""){print_r("Error seleccione fecha inicio");return;}
        if($fecfin == ""){print_r("Error seleccione fecha fin");return;}
        if($id == ""){print_r("Error producto invalido");return;}
        c_kardex::c_filtrarkardex($fecini,$fecfin,$id);
    }
    class c_kardex
    {
        static function c_listarproductos(){
            $producto = array();
            $m_producto = new m_kardex();
            $cadena = "EST_PRODUCTO = 'A'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][2],)
                );    
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtrarkardex($fecini,$fecfin,$id)
        {
            print_r($fecini."/".$fecfin."/".$id);
        }


        static function agrupar($original)
        {
            $result = array();
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if(trim($result[$i]['id'])==trim($t[0]))
                    {
                        $result[$i]['salida']+=$t[2];
                        $result[$i]['ingreso']+=$t[3];
                        $repeat=true;
                        break;
                    }
                }
                if($repeat==false)
                    $result[] = array('id' => $t[0],'nombre' => $t[1],'salida' => round($t[2],3) ,
                    'ingreso' => round($t[3],3));
            }
            return $result;     
        }



    }
?>