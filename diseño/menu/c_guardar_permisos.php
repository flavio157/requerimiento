<?php
require_once("../funciones/m_guardar_permisos.php");
        $tipo = $_POST["accion"];
        if($tipo == 'guardar'){
            $dt = json_decode($_POST['permisos']);
            $anexo = $_POST["anexo"];
            c_guardar_permisos::c_guardar_datos($anexo,$dt);
        }else if($tipo == 'buscar'){
            $anexo = $_POST['anexo'];
            c_guardar_permisos::c_buscar_anexo($anexo);
        }


class c_guardar_permisos 
{
    static function c_guardar_datos($anexo,$dt)
    {
        $patron = "/^([0-9])*$/";
        if(strlen($anexo) <= 4){
            if($anexo != '' && preg_match($patron,$anexo)){
                $m_permisos = new m_guardar_permisos();
                if(count($dt->permisos) > 0){
                    $c_permisos = $m_permisos->m_guardar_permisos($anexo,$dt);
                    if($c_permisos == 1)
                        print_r("DATOS GUARDADOS");
                    else
                        print_r($c_permisos);    
                }else{
                    print_r("SELECCIONE PERMISOS");
                }
            }else{
                print_r("ANEXO INVALIDO");
            }
        }else{
            print_r("ANEXO INVALIDO");
        }
    }
    
    

    static function c_buscar_anexo($anexo){
        $m_permisos = new m_guardar_permisos();
        $c_permisos = $m_permisos->m_consultar_permisos($anexo);
        $dato = array(
            'estado' => 'ok',
            'datos' => $c_permisos,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
    }


}


?>