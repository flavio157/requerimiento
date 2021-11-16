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
        $cuenta = $_POST['mtxtcuenpers'];
        $titular =$_POST['mtxttitulpers'];
        $usuario = $_POST['usuario'];
        $fechaingreso = $_POST['mtxtfecingreso'];
        $estado = $_POST['slcestado'];
        c_guardarpersonal::c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado);
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
        $cuenta = $_POST['mtxtcuenpers'];
        $titular =$_POST['mtxttitulpers'];
        $usuario = $_POST['usuario'];
        $fechaingreso = $_POST['mtxtfecingreso'];
        $estado = $_POST['slcestado'];
        c_guardarpersonal::c_actualizar($codpersonal,$nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado);
    }

    class c_guardarpersonal
    {
       
        static function c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado)
        {
            if(c_guardarpersonal::validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso) == 0){return;}
            
            $m_personal = new m_guardarpersonal();
            $c_personal = $m_personal->m_guardarpersonal(strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado);
            print_r(1);
        }

        
        static function validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso){
            $numero = "/^[0-9]+$/";
            $letras = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ.,;]+$/";
            $moneda = "/^[0-9\.]+$/";
            
            $cantnombre = explode(" ", $nombre);
            $cantdireccion = explode(" ", $direccion);
            $titularar = explode(" ",$titular);
            
            if($fechaingreso == ""){print_r("Error seleccione fecha de ingreso"); return 0;}
            if(preg_match($numero,$dni) == 0){print_r("Error DNI solo numeros"); return 0;}
            if(strlen($dni) > 8 ||strlen($dni) < 8 ){print_r("Error DNI solo 8 digitos"); return 0;}
            if(count($cantnombre) < 3){print_r("Error minimo un nombre y dos apellidos"); return 0;}
            if(strlen($nombre) > 60 ){print_r("Error nombre del personal sobrepaso limite"); return 0;}
            if(count($cantdireccion) < 3){print_r("Error direccion invalido"); return 0;}
            if(strlen($nombre) == 0){print_r("Error nombre invalido"); return 0;}
            if(preg_match($letras,$nombre) == 0){print_r("Error solo letras en el nombre"); return 0;}
            if(strlen($direccion) == 0){print_r("Error direccion invalido"); return 0;}
            if(strlen($direccion) > 100){print_r("Error direccion del personal sobrepaso limite"); return 0;}
            if(preg_match($moneda,$salario) == 0){print_r("Error salario solo numeros"); return 0;}
            if($cargo == "00000"){print_r("Error seleccione cargo"); return 0;}
            if($area == "00000"){print_r("Error seleccione area"); return 0;}
            if($departamento == "00000"){print_r("Error seleccione departamento"); return 0;}
            if($provincia == "00000"){print_r("Error seleccione provincia"); return 0;}
            if($distrito == "00000"){print_r("Error seleccione distrito"); return 0;}
            if($telefono != ""){
                if(preg_match($numero,$telefono) == 0){print_r("Error telefono solo numeros"); return 0;}
            }else{
                $telefono = 'NULL';
            }
            
            if($cuenta == ""){$cuenta = 'NULL';}
            if(preg_match($numero,$celular) == 0){print_r("Error celular solo numeros"); return;}
            if(strlen($celular) > 9 || strlen($celular)  < 9){print_r("Error celular solo 9 digitos"); return;}
            if($titular != ""){
                if(count($titularar) < 3){print_r("Error minimo un nombre y dos apellidos en titular"); return;}
                if(preg_match($letras,$titular) == 0){print_r("Error solo letras en titular"); return;}
                if(strlen($titular) > 50){print_r("Error nombre del titular muy largo"); return;}
            }else{
                $titular = 'NULL';
            }

            return 1;
        }

        static function c_actualizar($codpersonal,$nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado)
        {
            if(c_guardarpersonal::validar($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso) == 0){return;}
            $m_personal = new m_guardarpersonal();
            $c_personal = $m_personal->m_actualizarpers($codpersonal,strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso,$estado);
            print_r(1);
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
            for ($i=0; $i < count($c_lstpersonal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_lstpersonal[$i][0],
                    "label" => $c_lstpersonal[$i][5],
                    "prov" => $c_lstpersonal[$i][9],
                    "dist" => $c_lstpersonal[$i][10]));
            }
            $dato = array(
                'dato' => $personal
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