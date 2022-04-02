<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_guardarpersonal.php");
    $accion = $_POST['accion'];  
    if($accion == 'guardarperso') {
        $nombre = $_POST['mtxtnomperson'];
        $direccion = $_POST['mtxtdirper'];
        $dni = $_POST['mtxtdniper'];
        $cargo =$_POST['slcargpers'];
        $salario = $_POST['mtxtsalperso'];
        $area = $_POST['slareaper'];
        $departamento = $_POST['sldeparpers']; 
        $provincia = $_POST['slprovpers']; 
        $distrito = $_POST['sldistpers'];
        $telefono = $_POST['mtxttelpers'];
        $celular = $_POST['mtxtcelpers'];
        /*$cuenta = $_POST['mtxtcuenpers'];
        $titular =$_POST['mtxttitulpers'];*/
        $usuario = $_POST['usuario'];
        $fechaingreso = $_POST['mtxtfecingreso'];
        $estado = $_POST['slcestado'];
        c_guardarpersonal::c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado);
    }else if($accion == 'area'){
        c_guardarpersonal::c_lstarea('T_AREA','EST_AREA');
    }else if($accion == 'cargo'){
        c_guardarpersonal::c_lstarea('T_CARGO','EST_CARGO');
    }else if($accion == 'depa'){
        c_guardarpersonal::c_ubigeo('T_DEPARTAMENTO',"''","''");
    }else if($accion == 'provi'){
        $dato = $_POST['dato'];
        c_guardarpersonal::c_ubigeo('T_PROVINCIA','COD_DEPARTAMENTO',$dato);
    }else if($accion == 'distri'){
        $dato = $_POST['dato'];
        c_guardarpersonal::c_ubigeo('T_DISTRITO','COD_PROVINCIA',$dato);
    }else if($accion == 'lstpersonal'){
        c_guardarpersonal::c_listarpersonal();
    }else if($accion == 'buscarpersonal'){
        $codper = $_POST['personal'];
        c_guardarpersonal::c_buscarpersonal($codper);
    }else if ($accion == 'actualizar'){
        $codpersonal = $_POST['codpersonal'];
        $nombre = $_POST['mtxtnomperson'];
        $direccion = $_POST['mtxtdirper'];
        $dni = $_POST['mtxtdniper'];
        $cargo =$_POST['slcargpers'];
        $salario = $_POST['mtxtsalperso'];
        $area = $_POST['slareaper'];
        $departamento = $_POST['sldeparpers']; 
        $provincia = $_POST['slprovpers']; 
        $distrito = $_POST['sldistpers'];
        $telefono = $_POST['mtxttelpers'];
        $celular = $_POST['mtxtcelpers'];
        $usuario = $_POST['usuario'];
        $fechaingreso = $_POST['mtxtfecingreso'];
        $estado = $_POST['slcestado'];
        c_guardarpersonal::c_actualizar($codpersonal,$nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado);
    }

    class c_guardarpersonal
    {
       
        static function c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado)
        {
            $mensaje = c_guardarpersonal::validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$usuario,$fechaingreso);
           
            
            $m_personal = new m_guardarpersonal();
            if($mensaje == 1){
                $c_personal = $m_personal->m_guardarpersonal(strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
                ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado);
                $dato = array(
                    "dato" => $c_personal[0],
                    "codigo" => $c_personal[1]
                );
            }else{
                $dato = array(
                    "dato" => "",
                    "codigo" => $mensaje
                );
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
            //print_r(1);
        }

        
        static function validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$usuario,$fechaingreso){
            $numero = "/^[0-9]+$/";
            $letras = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ.,;]+$/";
            $moneda = "/^[0-9\.]+$/";
            
            $cantnombre = explode(" ", $nombre);
            $cantdireccion = explode(" ", $direccion);
           
            
            if($fechaingreso == ""){return "Error seleccione fecha de ingreso";}
            if(preg_match($numero,$dni) == 0){return "Error DNI solo numeros";}
            if(strlen($dni) > 8 ||strlen($dni) < 8 ){return "Error DNI solo 8 digitos";}
            if(count($cantnombre) < 3){return "Error minimo un nombre y dos apellidos";}
            if(strlen($nombre) > 60 ){return "Error nombre del personal sobrepaso limite de 60 caracteres";}
            if(count($cantdireccion) < 3){return "Error direccion invalido";}
            if(preg_match($letras,$nombre) == 0){return "Error solo letras en el nombre";}
            if(strlen($direccion) == 0){return "Error direccion invalido";}
            if(strlen($direccion) > 100){return "Error direccion del personal sobrepaso limite";}
            if(preg_match($moneda,$salario) == 0){return "Error salario solo numeros";}
            
            $saldo = explode(".", $salario);
            if(strlen($saldo[0]) > 7){return "Error campo cantidad, maximo 7 digitos con 2 decimales";}

            if($cargo == "00000"){return "Error seleccione cargo";}
            if($area == "00000"){return "Error seleccione area";}
            if($departamento == "00000"){return "Error seleccione departamento";}
            if($provincia == "00000"){return "Error seleccione provincia";}
            if($distrito == "00000"){return "Error seleccione distrito";}
            if($telefono != ""){
                if(preg_match($numero,$telefono) == 0){return "Error telefono solo numeros";}
            }else{
                $telefono = 'NULL';
            }
            
            if(preg_match($numero,$celular) == 0){return "Error celular solo numeros";}
            if(strlen($celular) > 9 || strlen($celular)  < 9){return "Error celular solo 9 digitos";}
            return 1;
        }

        static function c_actualizar($codpersonal,$nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado)
        {
            $mensaje = c_guardarpersonal::validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$usuario,$fechaingreso);
            if($mensaje == 1){
                $m_personal = new m_guardarpersonal();
                $c_personal = $m_personal->m_actualizarpers($codpersonal,strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
                ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado);
                $dato = array(
                    "dato" => $c_personal,
                );
            }else{
                $dato = array(
                    "dato" => $mensaje,
                );
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lstarea($tabla,$campo)
        {
            $m_personal = new m_guardarpersonal();
            $cadena = "$campo= '1'";
            $c_area = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'area' => $c_area,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        
        static function c_ubigeo($tabla,$campo,$dato)
        {
            $m_personal = new m_guardarpersonal();
            $cadena = "$campo= $dato";
            $c_area = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'area' => $c_area,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_listarpersonal(){
            $personal = array();
            $m_personal = new m_guardarpersonal();
            $c_lstpersonal = $m_personal->m_listarpersonal();
            $codpersonal = $m_personal->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
            for ($i=0; $i < count($c_lstpersonal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_lstpersonal[$i][0],
                    "label" => $c_lstpersonal[$i][5],
                    "prov" => $c_lstpersonal[$i][8],
                    "dist" => $c_lstpersonal[$i][9]));
            }
            $dato = array(
                'dato' => $personal,
                'codper' => $codpersonal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarpersonal($dato)
        {
            $m_personal = new m_guardarpersonal();
            $tabla = 'T_PERSONAL';
            $cadena = "COD_PERSONAL = '$dato'";
            $c_personal = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'personal' => $c_personal,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    }
    
?>