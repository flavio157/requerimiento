<?php
require_once("M_Pen_LLamada.php");
 date_default_timezone_set('America/Lima');
    $tipo = $_POST['accion'];
    $cod_operadora = $_POST['cod'];
    $oficina = $_POST['ofi'];

    if($tipo == "tiempo"){
        C_Pen_LLamada::Llamadas($cod_operadora,$oficina);
    }else if ($tipo == "datos"){
        C_Pen_LLamada::Pendientes($cod_operadora,$oficina);
    }

    class C_Pen_LLamada
    {
        static function Llamadas($cod_operadora,$oficina)
        {
            $pendi = new M_Pen_Llamada();
            $llamada = $pendi->M_LlamadasDta($cod_operadora,$oficina);
            $valor = ($llamada) ? "1" : "0";

            echo json_encode($valor,JSON_FORCE_OBJECT);
        }  
        
        
        static function Pendientes($cod_operadora,$oficina){
            $hora =  date("H:i".':00', time());

            $pendi = new M_Pen_Llamada();
            $pendientes = $pendi->M_pendiente($hora,$cod_operadora,$oficina);
            if($pendientes != ""){
                $pendientes = '1';
            }else{
                $pendientes = '0';
            }
            echo json_encode($pendientes,JSON_FORCE_OBJECT);
        }
    }
?>