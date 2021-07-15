<?php
    require_once("../funciones/m_direcciones.php");
    $accion = $_POST['accion'];

    if($accion == 'guardar'){
       $lat = $_POST['lat'] ;
       $lng = $_POST['lng'];
       $contrato = $_POST['contrato'];
       $usuario = $_POST['txtusuario'];
       c_direcciones::guardarlatlng($contrato,$lat,$lng,$usuario);     
    }else if($accion == 'lst'){
        $usuario = $_POST['txtusuario'];
        $oficina = $_POST['oficina'];
        c_direcciones::listarLatLng($usuario,$oficina);
    }else if($accion == 'obs'){
        $observacion = $_POST['txtobservacion'];
        $contrato = $_POST['txtcontrato'];
        c_direcciones::actualizaobservacion($observacion,$contrato);
    }


    class c_direcciones
    {
        static function guardarlatlng($contrato,$lat,$lng,$usuario){
            $dir = new M_direcciones();
            $guardar = $dir->m_guardarLatlng($contrato,$lat,$lng,$usuario);
            print_r($guardar);
        }


        static function listarLatLng($usuario,$oficina){
            $arraylatlng =array();
            $dir = new M_direcciones();
            $latlng = $dir->m_listarLatLng($usuario);
            $puntopar = $dir->m_puntopartida($oficina);
            
            $partida = $puntopar[1].','.$puntopar[2].',0';
            array_push($arraylatlng,$partida);
            for ($i=0; $i < count($latlng); $i++) {
                if($latlng[$i][2] != ''){
                    $datos = $latlng[$i][2] .','. $latlng[$i][3].','.$latlng[$i][1];
                    array_push($arraylatlng,$datos);
                }
            }
            array_push($arraylatlng,$partida);
            $datos  = array(
                'estado' => 'ok',
                'items' => $arraylatlng
                );
            echo json_encode($datos,JSON_FORCE_OBJECT); 
           
        }


        static function actualizaobservacion($txtobservacion,$num_contrato){
            $dir = new M_direcciones();
            $guardar = $dir->m_actualizaobservacion($txtobservacion,$num_contrato);
            print_r($guardar);
        }

    }





?>