<?php
require_once("M_Pen_Llamada_ofi.php");
 date_default_timezone_set('America/Lima');
    $tipo = $_POST['accion'];
    $cod_operadora = $_POST['cod'];
    $oficina = $_POST['ofi'];
    $oficinalogin = $_POST['oficinalogin'];


    if($tipo == "tiempo"){
        C_Pen_LLamada::Llamadas($cod_operadora,$oficina,$oficinalogin);
    }else if ($tipo == "datos"){
        C_Pen_LLamada::Pendientes($cod_operadora,$oficina,$oficinalogin);
    }

    class C_Pen_LLamada
    {
        static function Llamadas($cod_operadora,$ofi,$oficinalogin)
        {
            $pendi = new M_Pen_Llamada_Ofi($ofi);

            $llamada = $pendi->M_LlamadasDta($cod_operadora,$oficinalogin);
            $valor = ($llamada) ? "1" : "0";

            echo json_encode($valor,JSON_FORCE_OBJECT);
        }  
        
        
        static function Pendientes($cod_operadora,$ofi,$oficinalogin){
            $hora =  date("H:i".':00', time());

            $pendi = new M_Pen_Llamada_Ofi($ofi);


            $pendientes = $pendi->M_pendiente($hora,$cod_operadora,$oficinalogin);
           
            if($pendientes != ""){
                $pendientes = '1';
            }else{
                $pendientes = '0';
            }
            echo json_encode($pendientes,JSON_FORCE_OBJECT);
        }
    }
?>