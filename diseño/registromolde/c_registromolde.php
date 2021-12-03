<?php
    require_once("m_registromolde.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];
    if($accion == 'guardar'){
        $codpro = $_POST['codpro'];
        $nombre = $_POST['nombre'];
        $cantirec = $_POST['cantirec'];
        $unidad = $_POST['unidad'];
        $cantxusar = $_POST['cantxusar'];
        $usuario = $_POST['usuario'];
        $molde = $_POST['molde'];
        $tipo = $_POST['tipo'];
        //print_r($tipo);
         c_registrarmolde::c_guardarproc($codpro,$nombre,$cantirec,$unidad,$cantxusar,$usuario,$molde,$tipo);
    }else if($accion == 'guardarmolde'){
        $cod_cliente = $_POST['txtcodcliente'];
        $codmolde = $_POST['txtcodmolde'];
        $txtnommolde = $_POST['txtnommolde'];
        $txtmedmolde = $_POST['txtmedmolde'];
        $slcestado = $_POST['slcestado'];
        $usuario = $_POST['usuario'];
        $tipomolde = $_POST['slctipomolde'];
        $productos =json_decode($_POST['material']);   
        c_registrarmolde::c_guardarmoldecompleto($txtnommolde,$txtmedmolde,$slcestado,$usuario
                        ,$productos,$cod_cliente,$tipomolde);
    }else if($accion == 'buscarmolde'){
        $dato = $_POST['dato'];
        c_registrarmolde::c_buscarmoldes($dato);
    }else if($accion == 'materialxmolde'){
        $idmolde = $_POST['molde'];
        c_registrarmolde::c_listarmateriales($idmolde);
    }else if($accion == 'actualizar'){
        $codmolde = $_POST['txtcodmolde'];
        $txtnommolde = $_POST['txtnommolde'];
        $txtmedmolde = $_POST['txtmedmolde'];
        $slcestado = $_POST['slcestado'];
        $usuario = $_POST['usuario'];
        $productos =json_decode($_POST['material']);
        $cod_cliente = $_POST['txtcodcliente'];   
        c_registrarmolde::c_actualizarmoldecompleto($codmolde,$txtnommolde,$txtmedmolde,$slcestado,$usuario,$productos,$cod_cliente);
    }else if($accion == 'elimimaterial'){
        $material =$_POST['material'];
        $molde = $_POST['molde'];
        c_registrarmolde::c_eliminarmaterial($molde,$material);
    }else if($accion == 'guarcliente'){
        $usuario = $_POST['usuario'];
        $nombre = $_POST['txtnombcliente'];
        $direccion = $_POST['txtdireccliente'];
        $identificacion = $_POST['txtidenticliente'];
        $telefono = $_POST['txttelefon'];
        $correo = $_POST['txtcorreocliente'];
        c_registrarmolde::c_guardarcliente($nombre,$direccion,$identificacion,$telefono,$correo,$usuario);
    }else if($accion == 'buscarxnombre'){
        c_registrarmolde::c_buscarxnombre();
    }else if($accion == 'buscarxidentifi'){
        c_registrarmolde::c_buscarxidentifi();
    }else if($accion == 'actucliente'){
        $codcli = $_POST['txtcodclientemodal'];
        $usuario = $_POST['usuario'];
        $nombre = $_POST['txtnombcliente'];
        $direccion = $_POST['txtdireccliente'];
        $identificacion = $_POST['txtidenticliente'];
        $telefono = $_POST['txttelefon'];
        $correo = $_POST['txtcorreocliente'];
        c_registrarmolde::c_actualizarcliente($codcli,$nombre,$direccion,$identificacion,$telefono,$correo,$usuario);
    }else if ($accion == 'buscarcliente'){
        $cod = $_POST['codigo'];
        c_registrarmolde::c_buscarcliente($cod);
    }else if($accion == 'lstmaterilas'){
        c_registrarmolde::c_lstmaterial();
    }else if($accion == 'guardarmatepropio'){
        $codpro = $_POST['codpro'];
        $nombre = $_POST['nombre'];
        $unidad = $_POST['unidad'];
        $cantxusar = $_POST['cantxusar'];
        $usuario = $_POST['usuario'];
        $molde = $_POST['molde'];
        $tipo = $_POST['tipo'];
        c_registrarmolde::c_guarcarmatepropio($codpro,$nombre,$unidad,$cantxusar,$usuario,$molde,$tipo);
    }


    class c_registrarmolde
    {
        static function c_guardarproc($codpro,$nombre,$cantirec,$unidad,$cantxusar,$usuario,$molde,$tipo){
            
            $resul = c_registrarmolde::c_verificamateri($nombre,$cantirec,$unidad,$cantxusar,$usuario,$tipo);
          
            if($resul == ''){
                $m_guarprod = new m_registrarmolde();
                $c_guarprod = $m_guarprod->m_guarproc($codpro,strtoupper($nombre),$cantirec,
                strtoupper($unidad),$cantxusar,$usuario);
                if(strlen($molde) == 0){
                    $dato = array(
                        'dato' => $c_guarprod,
                    );
                }else{
                    $m_guarprod->m_guarfabricaionmaterial($molde,$c_guarprod[1],$cantxusar,strtoupper($unidad),$usuario);
                    if($m_guarprod){
                        $tip = array('1',$c_guarprod[1]);
                        $dato = array(
                            'dato' => $tip,
                        );
                    }
                }
            }else{
                $c_guarmolde = array(false,$resul);
                $dato = array(
                    'dato' => $c_guarmolde ,
                );
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_verificamateri($nombre,$cantirec,$unidad,$cantxusar,$usuario,$tipo)
        {
            $c_guarmolde = '';
            $cantidad = "/^[0-9\.]+$/";

            if(strlen($nombre) == 0){$c_guarmolde = "Error ingrese nombre del material"; return $c_guarmolde;}
            if(strlen($nombre) > 50){$c_guarmolde = "Error nombre del material maximo 50 caracteres"; return $c_guarmolde;}
            if($tipo == 'E'){
                if(strlen($cantirec) == 0){$c_guarmolde = "Error ingrese cantidad recibida del material"; return $c_guarmolde;}
                if(strlen($cantirec) == 0){$c_guarmolde = "Error ingrese cantidad recibida del material"; return $c_guarmolde;}
                $decimal = explode(".", $cantirec);
                if(strlen($decimal[0]) > 4){$c_guarmolde ="Error campo cantidad recibida, maximo 4 digitos con 3 decimales";return $c_guarmolde;}
                if(preg_match($cantidad,$cantirec) == 0){$c_guarmolde = "Error solo numeros en cantidad recibida del material"; return $c_guarmolde;}
            }
           
            
            if(strlen($unidad) == 0){$c_guarmolde = "Error ingrese unidad de medida del material"; return $c_guarmolde;}
            if(strlen($unidad) > 3){$c_guarmolde ="Error unidad de medida maximo 3 caracteres"; return $c_guarmolde;}
            if(strlen($unidad) < 2){ $c_guarmolde = "Error Unidad de medida minimo 2 caracteres"; return $c_guarmolde;}
            if(strlen($cantxusar) == 0){$c_guarmolde = "Error ingrese campo cantidad por usar para el molde"; return $c_guarmolde;}
            $decimal = explode(".", $cantxusar);
            if(strlen($decimal[0]) > 4){$c_guarmolde = "Error campo cantidad a usar, maximo 4 digitos con 3 decimales";return $c_guarmolde;}
            if($tipo == 'E'){
                if(preg_match($cantidad,$cantxusar) == 0){$c_guarmolde = "Error solo numeros en cantidad por usar"; return $c_guarmolde;}
                if($cantxusar > $cantirec){$c_guarmolde = "Error campo cantidad por usar no puede se mayor a cantidad recibida";return $c_guarmolde;}
            }
            return  $c_guarmolde;
        }


        static function c_guardarmoldecompleto($txtnommolde,$txtmedmolde,$slcestado,$usuario,
                        $productos,$cod_cliente,$tipomolde)
        {
            //$regex = "/^[a-zA-Z0-9\^-]+$/"; 
            $regex = "/[0-9\^-]+(a|c|m|x|h|l)+$/"; 
            if(strlen($txtnommolde) == 0){print_r("Error ingrese nombre del Molde");return;}
            if(strlen($txtmedmolde) == 0){print_r("Error ingrese medidas del Molde");return;}
            if(preg_match($regex,$txtmedmolde) == 0){print_r("Error campo medidas del molde formato incorrecto");return;}
            $m_guarmolde = new m_registrarmolde();
            $c_guarmolde = $m_guarmolde->m_guardar(strtoupper($txtnommolde),$txtmedmolde,$slcestado,
            $usuario,$productos,$cod_cliente,$tipomolde);
            print_r($c_guarmolde);
        }

        static function c_buscarmoldes($dato){
            $m_producto = new m_registrarmolde();
            if(strlen($dato) == 0){
                 $c_moldes = $m_producto->m_lstmoldes();
            }else{
                $consulta = "COD_CLIENTE = '$dato'";
                $c_moldes = $m_producto->m_buscar('T_MOLDE ',$consulta);
            }
            
            $dato = array(
                'dato' => $c_moldes
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_listarmateriales($idmolde){
            $m_producto = new m_registrarmolde();
            $dato = "molde = '$idmolde'";
            $c_material = $m_producto->m_buscar('V_MATERIAL_MOLDE',$dato);
            $dato = array(
                'dato' => $c_material,
            );
           
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_actualizarmoldecompleto($codmolde,$txtnommolde,$txtmedmolde,$slcestado,$usuario,$productos,$cod_cliente){
            $m_actualizar = new m_registrarmolde();
            $c_actualizar = $m_actualizar->m_actualizamolde($codmolde,strtoupper($txtnommolde),strtoupper($txtmedmolde)
                                                            ,$slcestado,$productos,$usuario,$cod_cliente);
            print_r($c_actualizar);                                                                
        }

        static function c_eliminarmaterial($codmolde,$codpro){
           $m_eliminar = new m_registrarmolde();
           $c_eliminar = $m_eliminar->m_eliminarmolde($codmolde,$codpro);    
           print_r($c_eliminar);
        }

        static function c_guardarcliente($nombre,$direccion,$identificacion,$telfono,$correo,$usuario)
        {
            $c_guarmolde = '';
            $dato = c_registrarmolde::c_verificardatoscli($nombre,$direccion,$identificacion,$telfono,$correo,$usuario);
            if($dato == ''){
                $m_guarmolde = new m_registrarmolde();
                $cadena = "IDENTIFICACION = '$identificacion'";
                $buscaindet = $m_guarmolde->m_buscar('T_CLIENTE_MOLDE',$cadena);
                if(count($buscaindet) == 0){
                    $c_guarmolde = $m_guarmolde->m_guardarcliente(strtoupper($nombre),strtoupper($direccion),
                    $identificacion,$telfono,$correo,$usuario);
                }else{
                    $c_guarmolde = array(false,'Error ya exite un registro con la misma identificación');
                }
            }else{
                $c_guarmolde = array(false,$dato);
            }
            $dato = array(
                    'dato' => $c_guarmolde,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_verificardatoscli($nombre,$direccion,$identificacion,$telfono,$correo,$usuario)
        {
            
            $regex = "/^[0-9]+$/";
            $c_guarmolde = '';
            if(strlen($nombre) == 0){$c_guarmolde = "Error ingrese nombre"; return $c_guarmolde;}
            
            if(strlen($direccion) == 0 ){$c_guarmolde = "Error ingrese dirección";return $c_guarmolde;}
            if(preg_match($regex,$identificacion) == 0){$c_guarmolde ="Error solo numeros en identificacion";
                return $c_guarmolde;}
            if(strlen($identificacion) == 0){$c_guarmolde = "Error ingrese identificacion";return $c_guarmolde;}
            if(strlen($identificacion) > 11){$c_guarmolde = "Error campo identificacion maximo 11 digitos";return $c_guarmolde;}
            if(strlen($identificacion) == 9){$c_guarmolde = "Error campo identificacion 8 ó 11 digitos";return $c_guarmolde;}
            if(strlen($identificacion) == 10){$c_guarmolde = "Error campo identificacion 8 ó 11 digitos";return $c_guarmolde;}
            if(strlen($identificacion) < 8){$c_guarmolde = "Error campo identificacion minimo 8 digitos";return $c_guarmolde;}
            if(count(count_chars($identificacion, 1)) < 3){$c_guarmolde = "Error campo identificacion invalido";return $c_guarmolde;}

            if(strlen($telfono) != 0){
                if(preg_match($regex,$telfono) == 0){$c_guarmolde = "Error solo numeros en telefono";
                   return $c_guarmolde;} 
                if(strlen($telfono) > 9){$c_guarmolde = "Error campo telefono maximo 9 digitos";return $c_guarmolde;}
                if(strlen($telfono) < 6){$c_guarmolde = "Error campo telefono minimo 6 digitos";return $c_guarmolde;}     
                if(count(count_chars($telfono, 1)) < 4){$c_guarmolde = "Error campo telefono invalido";return $c_guarmolde;}
            } 
            if(strlen($correo) != 0){
                if(filter_var($correo, FILTER_VALIDATE_EMAIL) == false){$c_guarmolde ="Error correo invalido";
                    return $c_guarmolde;} 
            }
             
            return  $c_guarmolde;
        }


        static function c_buscarxnombre()
        {
            $producto = array();
            $m_producto = new m_registrarmolde();
            $cadena = "'' = ''";
            $c_cliente = $m_producto->m_buscar('T_CLIENTE_MOLDE',$cadena);
           
            for ($i=0; $i < count($c_cliente) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_cliente[$i][0],
                    "label" => $c_cliente[$i][1],
                    "identi" => $c_cliente[$i][3]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarxidentifi()
        {
            $producto = array();
            $m_producto = new m_registrarmolde();
            $cadena = "'' = ''";
            $c_cliente = $m_producto->m_buscar('T_CLIENTE_MOLDE',$cadena);
           
            for ($i=0; $i < count($c_cliente) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_cliente[$i][0],
                    "label" => $c_cliente[$i][3],
                    "nombre" => $c_cliente[$i][1]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_actualizarcliente($codcli,$nombre,$direccion,$identificacion,$telefono,$correo,$usuario)
        {
            $c_guarmolde = '';
            $dato = c_registrarmolde::c_verificardatoscli($nombre,$direccion,$identificacion,$telefono,$correo,$usuario);
            if($dato == ''){
                $m_guarmolde = new m_registrarmolde();
                $c_guarmolde = $m_guarmolde->m_actualizarclien($codcli,strtoupper($nombre),
                strtoupper($direccion),$identificacion,$telefono,$correo,$usuario);
            }else{
                $c_guarmolde = $dato;
            }
            $dato = array(
                    'dato' => $c_guarmolde,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarcliente($codcli){
            $m_cliente = new m_registrarmolde();
            $cadena = "COD_CLIENTE = '$codcli'";
            $c_cliente = $m_cliente->m_buscar('T_CLIENTE_MOLDE',$cadena);
            $dato = array(
                'dato' => $c_cliente,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lstmaterial(){
            $m_producto = new m_registrarmolde();
            $cadena = "EST_PRODUCTO = '1' ORDER BY DES_PRODUCTO ASC";
            $c_producto = $m_producto->m_buscar('V_BUSCAR_MATERIALES',$cadena);
            $dato = array(
                'dato' => $c_producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_guarcarmatepropio($codpro,$nombre,$unidad,$cantxusar,$usuario,$molde,$tipo){
            $resul = c_registrarmolde::c_verificamateri($nombre,'',$unidad,$cantxusar,$usuario,$tipo);
            if($resul == ''){
                $m_producto = new m_registrarmolde();
                $c_producto = $m_producto->m_guarfabricaionmaterial($molde,$codpro,$cantxusar,$unidad,$usuario);
                
                $c_guarmolde = array($c_producto,'');
                $dato = array(
                    'dato' => $c_guarmolde ,
                );
            }else{
                $c_guarmolde = array(false,$resul);
                $dato = array(
                    'dato' => $c_guarmolde ,
                );
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
           
        }

    }
?>