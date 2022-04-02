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
        $nombmolde  = $_POST['nombre'];
        $medidas = $_POST['medida'];
        $fecini = $_POST['fecini'];
        $usuario = $_POST['usuario'];
        $personal = json_decode($_POST['lstpersonal']);
        $codmaterial = json_decode($_POST['codmaterial']);
        c_moldes::c_guardar($idmolde,$fecini,$usuario,$personal,$codmaterial,$nombmolde,$medidas);
    }else if($accion == 'validarpersonal'){
        $cod = $_POST['cod'];
        $nomper = $_POST['nomper'];
        $fecin = $_POST['fecin'];
        $obser = $_POST['obser'];
        c_moldes::verifidatosPersonal($cod,$nomper,$fecin,$obser);
    }else if($accion == 'lstmaterial'){
        c_moldes::c_material();
    }else if($accion == 'agremater'){
        $molde = $_POST['molde'];
        $material = $_POST['material'];
        $unidad = $_POST['unidad'];
        $cantidad  = $_POST['cantidad'];
        $usuario = $_POST['usu'];
        c_moldes::c_agregamaterial($molde,$material,$unidad,$cantidad,$usuario);
    }else if($accion == 'eliminarmaterial'){
        $molde = $_POST['molde'];
        $material = $_POST['material'];
        $clase = $_POST['clase'];
        $usu = $_POST['usu'];
        c_moldes::eliminarmaterial($molde,$material,$clase,$usu);
    }else if($accion == 'actualmater'){
        $molde = $_POST['molde'];
        $material = $_POST['material'];
        $cantidad = $_POST['cantidad'];
        $usu = $_POST['usu'];
        c_moldes::c_actualmaterial($molde,$material,$cantidad,$usu);
    }else if($accion == 'terminomolde'){
        $molde = $_POST['molde'];
        $fabricacion = $_POST['fabricacion'];
        $usuario = $_POST['usu'];
        c_moldes::c_moldefinfabric($molde,$fabricacion,$usuario);
    }else if($accion == 'verificarserie'){
        $serie = $_POST['serie'];
        c_moldes::c_verificarserie($serie);
    }

    class c_moldes 
    {
        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_moldes();
            $cadena = "EST_PERSONAL = '1'";
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
            $cadena = "ESTADO = '1'";
            $c_personal = $m_personal->m_buscar('T_MOLDE',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => trim($c_personal[$i][1]),
                    "medida" => $c_personal[$i][2],
                    "tipo" => $c_personal[$i][6]));
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 

        static function c_material()
        {
            $material = array();
            $m_personal = new m_moldes();
            $cadena = "EST_PRODUCTO = '1'";
            $c_personal = $m_personal->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($material,array(
                    "code" => $c_personal[$i][0],
                    "label" => $c_personal[$i][2],
                    "unidad" => $c_personal[$i][3]));
            }
            $dato = array(
                'dato' => $material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lstmateriales($dato)
        {
            $m_personal = new m_moldes();
            $cadena = "molde = '$dato'";
            $c_personal = $m_personal->m_buscar('V_MATERIAL_MOLDE',$cadena);
            $dato = array(
                'dato' => $c_personal,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        static function c_guardar($idmolde,$fecini,$usuario,$personal,$cod_material,$nombmolde,$medida)
        {
            $m_molde = new m_moldes();
            $cadena = "nombre = '$nombmolde' AND medidas = '$medida' AND fin_fabricacion = '0'";
            $c_buscar = $m_molde->m_buscar('V_MOLDES_FABRICACION',$cadena);
            if(count($c_buscar)>0){
                    print_r("Error el molde ya se encuentra en fabricación");
                    return;
            }
            if(c_moldes::verificarstock($cod_material) == -1){print_r("Error Material no existe"); return;}
            if(c_moldes::verificarstock($cod_material) == -2){print_r("Error stock insuficiente"); return;}
            if(c_moldes::verificarstock($cod_material) == -3){print_r("Error ingrese numero de serie del material"); return;}
            
           
            if($idmolde == ""){print_r("Error ingrese molde"); return;}
            if($fecini == ""){print_r("Error ingrese fecha inicio"); return;}
            if(count($personal->tds)==0){print_r("Error ingrese personal"); return;}
            $m_guardar = new m_moldes();
            $c_guardar = $m_guardar->m_guardar($idmolde,$fecini,$usuario,$personal,$cod_material);
            print_r($c_guardar);
        }

        static function verificarstock($cod_material)
        {   $tabla = '';
            $m_material = new m_moldes();
            foreach ($cod_material->codmat as $dato){
                    $cadena = "producto = '$dato[0]'";
                    $tabla ='V_MATERIAL_MOLDE';
                    $c_material = $m_material->m_buscar($tabla,$cadena);
                    if(count($c_material) == 0) {return -1;}  
                    if($dato[1] > $c_material[0][5]){
                        return -2;
                    } 
                    if($dato[3] == '00001'){
                        if($dato[2] == ''){return -3;}
                    }
            }
            return $c_material;
        }

        static function verifidatosPersonal($cod,$nomper,$fecin,$obser)
        {
            if($fecin == ""){
                print_r("Ingrese fecha inicio");
                return;
            }
            if($nomper == "" || $cod == ""){
                print_r("Ingrese Personal");
                return;
            }
            if(strlen(str_replace(" ", "", $obser)) < 10){print_r("Descripcion debe tener 10 caracteres"); return;}
            if(strlen($obser) > 200){print_r("Error campo observacion sobrepaso el limite de caracteres");return;}
            $pattern = "/[a-zA-Z0-9\sñáéíóúÁÉÍÓÚ.,;-]+$/";
            if(preg_match($pattern,$obser) == 0){print_r("Error descripcion invalida"); return;}
            print_r(1);
        }

        static function veridatos_molde($nombre,$medidas,$estado,$usuario)
        {
            $regex = "/[0-9\^-]+(a|c|m|x|h|l)+$/"; 
            //$regex = "/[0-9]+(a|c|m|x)/"; 
            $m_molde = new m_moldes(); 
            if(strlen($nombre) == 0){return array("Error ingrese nombre del molde",0);} 
            if(strlen($nombre) < 5){return array("Error nombre del molde minimo 5 caracteres",0);}
            if(strlen($nombre) > 100){return array("Error nombre del molde sobrepaso limite de 100 caracteres",0);}
            if(strlen($medidas) == 0){return array("Error ingrese medidas del molde",0);}  
            if(strlen($medidas) > 50){return array("Error campo medida sobrepaso el limite de 50 caracteres",0);}  
            if(preg_match($regex,$medidas) == 0){return array("Error campo medida del molde tiene formato incorrecto",0);}
            if($estado == '000'){return array("Error seleccione estado",0);}

            $cadena = "NOM_MOLDE = '$nombre' and MEDIDAS = '$medidas' and TIPO_MOLDE = 'E'";
            $c_buscar = $m_molde->m_buscar('T_MOLDE',$cadena);
            if(count($c_buscar)>0){
                return array("Error ya existe un molde con el mismo nombre y medidas",0);
            }
            return array('',1);
        }


        static function c_agregamaterial($molde,$material,$unidad,$cantidad,$usuario){
            $m_material = new m_moldes(); 
            $consulta = "molde = '$molde' and tipo = 'P'";
            $c_moldes = $m_material->m_buscar('V_MOLDES_FABRICACION ',$consulta);
            if(count($c_moldes)){print_r("Error un molde ya fabricado no se puede modificar"); return;}


            $cadena = "molde = '$molde' AND fin_fabricacion = '0' and tipo = 'E'";
            $c_buscar = $m_material->m_buscar('V_MOLDES_FABRICACION',$cadena);
            if(count($c_buscar)>0){
                    print_r("Error no se puede modificar un molde que se encuentra en fabricacion");
                    return;
            }


            if(strlen($molde) == 0){print_r("Error seleccione molde para agregar material"); return;}
            if(strlen($material) == 0){print_r("Error seleccione material"); return;}
            if(strlen($cantidad) == 0){print_r("Error ingrese cantidad del material"); return;}
            if(!is_numeric($cantidad)){print_r("Error solo numeros en cantidad por usar"); return;}
            $prec = explode(".", $cantidad);
            if(strlen($prec[0]) > 4){print_r("Error campo precio, maximo 4 digitos con 3 decimales");return;}
           
            $c_producto = $m_material->m_agregarmaterial($molde,$material,$unidad,$cantidad,$usuario);
            print_r($c_producto);   
        }

        static function eliminarmaterial($molde,$material,$clase,$usu){
            $m_material = new m_moldes();
            $consulta = "molde = '$molde' and tipo = 'P'";
            $c_moldes = $m_material->m_buscar('V_MOLDES_FABRICACION ',$consulta);
            if(count($c_moldes)){print_r("Error un molde ya fabricado no se puede modificar"); return;}
            
            $cadena = "molde = '$molde' AND fin_fabricacion = '0' and tipo = 'E'";
            $c_buscar = $m_material->m_buscar('V_MOLDES_FABRICACION',$cadena);
            if(count($c_buscar)>0){
                    print_r("Error no se puede modificar un molde que se encuentra en fabricacion");
                    return;
            }

            if($clase == '00002' || $clase == '00003'){
                $c_eliminar = $m_material->m_eliminar($molde,$material);
                print_r($c_eliminar);
            }else{
                $consulta = "ID_MOLDE ='$molde' AND COD_PRODUCTO = '$material'";
                $buscar = $m_material->m_buscar('T_MATERIALES_FABRICACION',$consulta);
                $cantidad = $buscar[0][2] - 1;
                $c_eliminar = $m_material->m_actualmaterial($molde,$material,$cantidad,$usu);
                print_r($c_eliminar);
            }
        }

        static function c_actualmaterial($molde,$material,$cantidad,$usu){
            $m_material = new m_moldes(); 
            $consulta = "molde = '$molde' and tipo = 'P'";
            $c_moldes = $m_material->m_buscar('V_MOLDES_FABRICACION ',$consulta);
            if(count($c_moldes)){print_r("Error un molde ya fabricado no se puede modificar"); return;}

            $c_actualizar = $m_material->m_actualmaterial($molde,$material,$cantidad,$usu);

            print_r($c_actualizar);
        }

        static function c_moldefinfabric($molde,$fabricacion,$usuario){
            $m_material = new m_moldes(); 
            $c_actualizar = $m_material->m_finfabricion($molde,$fabricacion,$usuario);
            print_r($c_actualizar);
        }

        static function c_verificarserie($serie){
            $m_material = new m_moldes();
            $regex = "/^[a-zA-Z0-9\-]+$/"; 
            $consulta ="NUM_SERIE = '$serie'";
            if(strlen($serie) > 20){print_r("Error nro de serie solo 20 caracteres");return;}
            if(strlen($serie) < 6){print_r("Error nro de serie nimimo 6 caracteres");return;}
            if(preg_match($regex,$serie) == 0){print_r("Error numero de serie invalido");return;}
            if(count(count_chars($serie, 1)) < 4){print_r("Error numero de serie invalido");return;}
            $conse = c_moldes::validarserieprod($serie);
            if($conse == 1){print_r("Error numero de serie invalido");return;}
            $c_serie = $m_material->m_buscar("T_DETSALIDA",$consulta); 
            if(count($c_serie) == 0){print_r(1); return;}
            else{print_r("Error numero de serie ya registrado"); return;}
        }
        
        static function validarserieprod($nroseriepro){
            $array = ['123456789','123456','1234561','1234562','1234563',
                     '1234564','987654321','abcd','abcdefa',];
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$nroseriepro);
            for ($i=0; $i < count($array); $i++) { 
                if($arr[0] == $array[$i]){
                    return 1;
                }
                if(count($arr) > 1){
                    if($arr[1] == $array[$i]){
                        return 1;     
                    } 
                } 
            }
            return 0;
        }
    }
?>