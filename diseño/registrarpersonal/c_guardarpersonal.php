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
        c_guardarpersonal::c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso);
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
    }

    class c_guardarpersonal
    {
       
        static function c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso)
        {
            $numero = "/^[0-9]+$/";
            $letras = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
            $moneda = "/^[0-9\.]+$/";
            
            $cantnombre = explode(" ", $nombre);
            $cantdireccion = explode(" ", $direccion);
            $titularar = explode(" ",$titular);
            
            if($fechaingreso == ""){print_r("Error seleccione fecha de ingreso"); return;}
            if(preg_match($numero,$dni) == 0){print_r("Error DNI solo numeros"); return;}
            if(strlen($dni) > 8 ||strlen($dni) < 8 ){print_r("Error DNI solo 8 digitos"); return;}
            if(count($cantnombre) < 3){print_r("Error minimo un nombre y dos apellidos"); return;}
            if(strlen($nombre) > 60 ){print_r("Error nombre del personal muy largo"); return;}
            if(count($cantdireccion) < 3){print_r("Error direccion invalido"); return;}
            if(strlen($nombre) == 0){print_r("Error nombre invalido"); return;}
            if(preg_match($letras,$nombre) == 0){print_r("Error solo letras en el nombre"); return;}
            if(strlen($direccion) == 0){print_r("Error direccion invalido"); return;}
            if(strlen($direccion) > 100){print_r("Error direccion del personal muy largo"); return;}
            if(preg_match($moneda,$salario) == 0){print_r("Error salario solo numeros"); return;}
            if($telefono != ""){
                if(preg_match($numero,$telefono) == 0){print_r("Error telefono solo numeros"); return;}
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
            $m_personal = new m_guardarpersonal();
            $c_personal = $m_personal->m_guardarpersonal(strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso);
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
    
    }
    



?>