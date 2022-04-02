<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_proveedor.php");
    $accion = $_POST['accion'];
    if($accion == 'gproveedor'){
        $proveedor = $_POST['mtxtnomprovee'];
        $direccion = $_POST['mtxtdirprovee'];
        $ruc = $_POST['mtxtrucprovee'];
        $dni = $_POST['mtxtdniprovee'];
        $telefono = $_POST['mtxttelefprovee'];
        $celular = $_POST['mtxtcelprovee'];
        $estado = $_POST['slcestadoprovee'];
        $usu = $_POST['usu'];
        c_proveedor::c_guardarproveedor($proveedor,$direccion,$ruc,$dni,$telefono,$celular,$estado,$usu);
    }
    class c_proveedor
    {
        static function c_guardarproveedor($proveedor,$direccion,$ruc,$dni,$telefono,$celular,$estado,$usu){
            if(strlen($proveedor) > 50){print_r("Error nombre del proveerdor maxino 50 caracteres"); return;}
            if(strlen($direccion) > 100){print_r("Error nombre del proveedor maxino 100 caracteres"); return;}
            if(strlen($ruc) == 0 && strlen($dni) == 0){print_r("Error ingrese RUC o DNI del proveedor"); return;}
            if(strlen($ruc) != 0){
                if(strlen($ruc) > 11 || strlen($ruc) < 11){print_r("Error RUC minimo 11 caracteres"); return;}
                if(!is_numeric($ruc)){print_r("Error RUC solo numeros");return;}
            }
            if(strlen($dni) != 0){
                if(strlen($dni) > 8 || strlen($dni) < 8){print_r("Error DNI minimo 8 caracteres"); return;}
                if(!is_numeric($dni)){print_r("Error DNI solo numeros");return;}
            }
            if(strlen($telefono) != 0){
                if(strlen($telefono) > 7){print_r("Error telefono maximo 7  digitos"); return;}
                if(strlen($telefono) < 6){print_r("Error telefono minimo 6  digitos"); return;}
                if(!is_numeric($telefono)){print_r("Error campo Telefono  solo numeros");return;}
            }

            if(strlen($celular) != 0){
                if(strlen($celular) > 9 || strlen($celular) < 9){print_r("Error Celular minimo 9 digitos"); return;}
                if(!is_numeric($celular)){print_r("Error campo Celular  solo numeros");return;}
            }
            if(strlen($estado) == 0){print_r("Error seleccione estado del personal"); return;}

            $m_proveedor = new m_proveedor();
            $c_proveedor = $m_proveedor->m_guardar_proeveedor($proveedor,$direccion,$ruc,$dni,$telefono,$celular,$estado,$usu);
            print_r($c_proveedor);
        }

    }
    



?>