<?php
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
    }else if($accion == 'oficina'){
        c_furgon::c_lst_oficina();
    }else if($accion == 'guardar'){
        $comentario = $_POST['comen'];
        $usuario = $_POST['usuario'];
        c_furgon::c_guardarcomentario($comentario,$usuario);
    }else if($accion == "lstcomentario"){
        c_furgon::lstcomentarios(0);
    }
    class c_furgon
    {
        static function c_lsfurgon($fecha)
        {
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_lsfurgon('V_LST_FURGON','FECHA',$fecha);   //resultado de la consulta a la vista
            $agrupado = c_furgon::agruparfurgon($c_furgon);    //agrupa las oficinas y suma las cantidades del vendedor
            $dato = array(
                'furgon' => $c_furgon,
                'agrupado' => $agrupado,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lst_ven_furgon($fecini,$fecfin,$select)
        {   
            $result = array();

            $m_furgon = new m_furgon();
            
            $c_ven_furgon  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,$select,'COD_VEN1','NOM_VEN1','CAN_VEN1');
            $dato = c_furgon::agruparven($result,$c_ven_furgon);
           
            $c_ven_furgon2  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,$select,'COD_VEN2','NOM_VEN2','CAN_VEN2');    
            $dato = c_furgon::agruparven($dato,$c_ven_furgon2);
           
            $c_ven_furgon3  = $m_furgon->m_lst_vend_furgon($fecini,$fecfin,$select,'COD_VEN3','NOM_VEN3','CAN_VEN3');
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
    

        static function c_lst_oficina(){
            $ofi = array();
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_lst_oficinaFurgon();
            for ($i=0;  $i < count($c_furgon) ; $i++) { 
                if($c_furgon[$i][0] != "")
                array_push($ofi,$c_furgon[$i][0]);
            }
            $dato = array(
                'dato' => $ofi,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function lstcomentarios($tipo)
        {
            $date = retunrFechaActualphp(); 
            $m_furgon = new m_furgon();
            $c_furgon = $m_furgon->m_lsfurgon('T_COMENTARIOS_FURGON','convert(date, FEC_REGISTRO)',$date);
            $dato = array(
                "dato" => $c_furgon
            );
            if($tipo == 0) echo json_encode($dato,JSON_FORCE_OBJECT);
           
            return count($c_furgon);
        }

        static function c_guardarcomentario($comentario,$usuario){
            $regName = '/^(?!.*([A-Za-z])\1{2})/';
            if(strlen(str_replace(" ", "", $comentario)) < 20){print_r("Error comentario invalida"); return;}
            if(preg_match($regName,$comentario) == 0){print_r("Error comentario invalida"); return;}
            $desc = str_replace(' ', '', $comentario);
            if(!ctype_alpha(trim($desc))){print_r("Error comentario invalida"); return;}

            $lst = c_furgon::lstcomentarios(1);
            if($lst == 0){
                $m_furgon = new m_furgon();
                $c_furgon = $m_furgon->m_guadarcomentario($comentario,$usuario);
                print_r($c_furgon);
            }else{
                print_r("Ya se registro el comentario");
            }
        }
    }
 

?>