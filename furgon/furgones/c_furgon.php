<?php
require_once("m_furgon.php");
    $accion = $_POST['accion'];
    if($accion == 'furgon'){
        $fecha = $_POST['fecha'];
        c_furgon::c_lsfurgon($fecha);
    }else if($accion == 'vendedor'){
        $fecini = $_POST['fechini'];
        $fecfin = $_POST['fechfin'];
        c_furgon::c_lst_ven_furgon($fecini,$fecfin);
    }
    class c_furgon
    {
        static function c_lsfurgon($fecha)
        {
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_lsfurgon($fecha);   //resultado de la consulta a la vista
            $agrupado = c_furgon::agruparfurgon($c_furgon);    //agrupa las oficinas y suma las cantidades del vendedor
            $dato = array(
                'furgon' => $c_furgon,
                'agrupado' => $agrupado,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lst_ven_furgon($fecini,$fecfin)
        {   
            $result = array();

            $m_furgon = new m_furgon();
            
            $c_ven_furgon  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,'COD_VEN1','NOM_VEN1','CAN_VEN1');
            $dato = c_furgon::agruparven($result,$c_ven_furgon);
           
            $c_ven_furgon2  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,'COD_VEN2','NOM_VEN2','CAN_VEN2');    
            $dato = c_furgon::agruparven($dato,$c_ven_furgon2);
           
            $c_ven_furgon3  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,'COD_VEN3','NOM_VEN3','CAN_VEN3');
            $dato = c_furgon::agruparven($dato,$c_ven_furgon3);
            $json = array(
                'json' => $dato 
            );
            echo json_encode($json,JSON_FORCE_OBJECT);
        }




        static function agruparfurgon($original) 
        {
            $result = array();
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if($result[$i]['0']==$t[0])
                    {
                        $result[$i]['1']+=$t[21];
                        $repeat=true;
                        break;
                    }
                }
                if($repeat==false)
                    $result[] = array('0' => $t[0],'1' => round($t[21],2));
            }
            return $result;     
        }

        static function agruparven($result,$original)
        {
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if($result[$i]['0']==$t[0])
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
    
    }
 

?>