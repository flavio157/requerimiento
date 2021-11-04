<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_furgon.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];

    if($accion == 'furgon'){
        $fecha = $_POST['fecha'];
        c_furgon::c_lsfurgon($fecha);
    }else if($accion == 'vendedor'){
        $fecini = $_POST['fechini'];
        $fecfin = $_POST['fechfin'];
        $select = $_POST['select'];
        c_furgon::c_lst_ven_furgon($fecini,$fecfin,$select);
    }else if($accion == 'guardar'){
        $fecha = $_POST['fecha'];
        $comentario = $_POST['comen'];
        $usuario = $_POST['usuario'];
        c_furgon::c_guardarcomentario($comentario,$usuario,$fecha);
    }else if($accion == 'lstcomentario'){
        $fecha = $_POST['fecha'];
        c_furgon::lstcomentarios(0,$fecha);
    }
    class c_furgon
    {
        static function c_lsfurgon($fecha)
        {
            $result = array(); 
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_lsfurgon($fecha);
         
            $agrupado = c_furgon::agruparfurgon($c_furgon,$result);
            $dato = array(
                'furgon' =>$c_furgon,
                'agrupado' => $agrupado
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lst_ven_furgon($fecini,$fecfin,$select)
        {   
            $result = array();
            $m_furgon = new m_furgon();
            $c_ven_furgon  = $m_furgon->m_lst_vend1_furgon($fecini,$fecfin,$select);
            $dato = c_furgon::agruparven($result,$c_ven_furgon);
            $c_ven_furgon2  = $m_furgon->m_lst_vend2_furgon($fecini,$fecfin,$select);    
            $dato = c_furgon::agruparven($dato,$c_ven_furgon2);
            $c_ven_furgon3  = $m_furgon->m_lst_vend3_furgon($fecini,$fecfin,$select);
            $dato = c_furgon::agruparven($dato,$c_ven_furgon3);
            $json = array(
                'json' => $dato 
            );
            echo json_encode($json,JSON_FORCE_OBJECT);
        }

        static function agruparfurgon($original,$result) 
        {
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if(trim($result[$i]['0'])==trim($t[0]))
                    {
                        $result[$i]['1']+=$t[20];
                        $repeat=true;
                        break;
                    }
                }
                if($repeat==false)
                    $result[] = array('0' => $t[0],'1' => $t[20]);
            }
            return $result;     
        }

        static function agruparven($result,$original)
        {
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if(trim($result[$i]['0'])==trim($t[0]))
                    {
                        $result[$i]['2']+=$t[2];
                        $repeat=true;
                        break;
                    }
                }
                if($repeat==false)
                    $result[] = array('0' => $t[0],'1'=>$t[1],'2' => round($t[2],2));
            }
            return $result;  
        }

        static function lstcomentarios($tipo,$fecha)
        {
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_listar_cometario($fecha);
           
            $dato = array(
                "dato" => $c_furgon
            );
            if($tipo == 0) echo json_encode($dato,JSON_FORCE_OBJECT);
            return count($c_furgon);
        }

        static function c_guardarcomentario($comentario,$usuario,$fecha){
            $count = c_furgon::c_verificar_fech_furgon($fecha);
            if($count[0][0] == ""){print_r("Error no hay furgones en fecha seleccionada");return;}
            if($fecha == ""){print_r("Error fecha invalido");return;}
            $regName = '/^(?!.*([A-Za-z])\1{2})/';
            if(strlen(str_replace(" ", "", $comentario)) < 20){print_r("Error comentario invalido"); return;}
            if(preg_match($regName,$comentario) == 0){print_r("Error comentario invalido"); return;}
            $lst = c_furgon::lstcomentarios(1,$fecha);
            if($lst == 0){
                $m_furgon = new m_furgon();
                $c_furgon = $m_furgon->m_guadarcomentario($comentario,$usuario,$fecha);
                print_r($c_furgon);
            }else{
                print_r("Ya se registro el comentario");
            }
        }

        static function c_verificar_fech_furgon($fecha){
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_verificar_fech_furgon($fecha);
            return $c_furgon;
        }

    }
 

?>