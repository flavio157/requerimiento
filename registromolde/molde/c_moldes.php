<?php
    require_once("m_moldes.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_moldes::c_filtarpersonal();
    }else if($accion == 'lstmoldes'){
        c_moldes::c_lstmoldes();
    }else if($accion == 'lstmateriales'){
        $dato = $_POST['dato'];
        c_moldes::c_lstmateriales($dato);
    }else if($accion == 'guardar'){
        $idmolde = $_POST['idmolde'];
        $fecini = $_POST['fecini'];
        $fecfin = $_POST['fecfin'];
        $usuario = $_POST['usuario'];
        $personal = json_decode($_POST['lstpersonal']);
        $codmaterial = json_decode($_POST['codmaterial']);
        c_moldes::c_guardar($idmolde,$fecini,$fecfin,$usuario,$personal,$codmaterial);
    }else if($accion == 'validarpersonal'){
        $cod = $_POST['cod'];
        $nomper = $_POST['nomper'];
        $fecin = $_POST['fecin'];
        $fecfin = $_POST['fecfin'];
        $obser = $_POST['obser'];
        $hora = $_POST['hora'];
        $costo = $_POST['costo'];
        c_moldes::verifidatosPersonal($cod,$nomper,$fecin,$fecfin,$obser,$hora,$costo);
    }

    class c_moldes 
    {
        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_moldes();
            $cadena = "EST_PERSONAL = 'A'";
            $c_personal = $m_personal->m_buscar('T_PERSONAL',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => $c_personal[$i][5]));
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
          
        } 

        static function c_lstmoldes()
        {
            $personal = array();
            $m_personal = new m_moldes();
            $cadena = "ESTADO = 'A'";
            $c_personal = $m_personal->m_buscar('T_MOLDE',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => trim($c_personal[$i][1]),
                    "medida" => $c_personal[$i][2]));
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
          
        } 

        static function c_lstmateriales($dato)
        {
            $m_personal = new m_moldes();
            $cadena = "ID_MOLDE = '$dato'";
            $c_personal = $m_personal->m_buscar('V_MATERIAL_MOLDE',$cadena);
            $dato = array(
                'dato' => $c_personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_guardar($idmolde,$fecini,$fecfin,$usuario,$personal,$cod_material)
        {
            if(c_moldes::verificarstock($cod_material) == -1){print_r("Error stock insuficiente"); return;}
            if(c_moldes::verificarstock($cod_material) == -2){print_r("Error Material no existe"); return;}
            if($idmolde == ""){print_r("Error ingrese molde"); return;}
            if($fecini == ""){print_r("Error ingrese fecha inicio"); return;}
            if($fecfin == ""){print_r("Error ingrese fecha fin"); return;}
            if(count($personal->tds)==0){print_r("Error ingrese personal"); return;}
            $m_guardar = new m_moldes();
            $c_guardar = $m_guardar->m_guardar($idmolde,$fecini,$fecfin,$usuario,$personal,$cod_material);
            print_r($c_guardar);
        }

        static function verificarstock($cod_material)
        {
            $m_material = new m_moldes();
            foreach ($cod_material->codmat as $dato){
                $cadena = "COD_PRODUCTO = '$dato[0]'";
                $c_material = $m_material->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                if(count($c_material) == 0) {return -2;}
                if($dato[1] > $c_material[0][4]){
                    return -1;
                }
            }
            return $c_material;
        }

        static function verifidatosPersonal($cod,$nomper,$fecin,$fecfin,$obser,$hora,$costo)
        {
            if($fecin == "" || $fecfin == ""){
                print_r("Ingrese fecha inicio y fecha fin del molde");
                return;
            }
            if($nomper == "" || $cod == ""){
                print_r("Ingrese Personal");
                return;
            }
            if (!is_numeric($hora) || $hora == "") {
                print_r("Campo hora es invalido");
                return;
            }   
            if(!is_numeric($costo) || $costo == ""){
                print_r("Campo costo es invalido");
                return;
            }
            if(strlen(str_replace(" ", "", $obser)) < 10){print_r("Descripcion debe tener 10 caracteres"); return;}
            $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
            if(preg_match($pattern,$obser) == 0){print_r("Error descripcion invalida"); return;}
            print_r(1);
        }
    }
?>