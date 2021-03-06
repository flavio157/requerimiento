<?php
    require_once("../funciones/m_direcciones.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];

    if($accion == 'guardar'){
       $lat = $_POST['lat'] ;
       $lng = $_POST['lng'];
       $contrato = $_POST['contrato'];
       $usuario = $_POST['txtusuario'];
       $direccion = $_POST['direccion'];
       c_direcciones::guardarlatlng($contrato,$lat,$lng,$usuario,$direccion);     
    }else if($accion == 'lst'){
        $usuario = $_POST['txtusuario'];
        $oficina = $_POST['oficina'];
        c_direcciones::listarLatLng($usuario,$oficina);
    }else if($accion == 'obs'){
        $observacion = $_POST['txtobservacion'];
        $contrato = $_POST['txtcontrato'];
        c_direcciones::actualizaobservacion($observacion,$contrato);
    }else if($accion == 'puntopartida'){
        $oficina = $_POST['oficina'];
        c_direcciones::puntoPartida($oficina);
    }else if($accion == 'consultarcontrato'){
        $contrato = $_POST['contrato'];
        $usuario = $_POST['usuario'];
        c_direcciones::verificarobsevacion($usuario,$contrato);
    }


    class c_direcciones
    {
        static function guardarlatlng($contrato,$lat,$lng,$usuario,$direccion){
            $contrato = completarcontrato($contrato);
            $dir = new M_direcciones();
            $guardar = $dir->m_guardarLatlng($contrato,$lat,$lng,$usuario,$direccion);
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
                if($latlng[$i][2] != '' && $latlng[$i][3] != ''){
                    $datos = $latlng[$i][2] .','. $latlng[$i][3].','.$latlng[$i][1].','.$latlng[$i][5];
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

        static function puntoPartida($oficina){
            $dir = new M_direcciones();
            $puntopar = $dir->m_puntopartida($oficina);
            $puntos = $puntopar[1].','.$puntopar[2];
            print_r($puntos);
        }


        static function verificarobsevacion($usuario,$contrato){
            $dir = new M_direcciones();
            $observacion = $dir->m_verificarobservacion($usuario,$contrato);
            print_r($observacion[5]);
        }

    }





?>