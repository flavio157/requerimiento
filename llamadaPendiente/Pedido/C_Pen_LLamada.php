<?php
require_once("M_Pen_LLamada.php");
 date_default_timezone_set('America/Lima');
    $tipo = $_POST['accion'];

    if($tipo == "tiempo"){
        C_Pen_LLamada::Llamadas();
    }else if ($tipo == "datos"){
        C_Pen_LLamada::Pendientes();
    }

    class C_Pen_LLamada
    {
        static function Llamadas()
        {
            $pendi = new M_Pen_Llamada();
            $llamada = $pendi->M_LlamadasDta();
            $valor = ($llamada) ? "1" : "0";

            echo json_encode($valor,JSON_FORCE_OBJECT);
        }  
        
        
        static function Pendientes(){
            
            $fecha = date("d")."-".date("m")."-".date("Y");
            $hora =  date("H:i".':00', time());

            $pendi = new M_Pen_Llamada();
            $pendientes = $pendi->M_pendiente($hora,$fecha);
            if($pendientes != ""){
                $pendientes = '1';
            }else{
                $pendientes = '0';
            }
            echo json_encode($pendientes,JSON_FORCE_OBJECT);
        }
    }
?>