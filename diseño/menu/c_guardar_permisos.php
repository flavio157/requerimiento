<?php
require_once("../funciones/m_guardar_permisos.php");
        $tipo = $_POST["accion"];
        if($tipo == 'guardar'){
            c_guardar_permisos::c_guardar_datos();
        }else if($tipo == 'actualizar'){
            c_guardar_permisos::c_actualizar_datos();
        }else if($tipo == 'buscar'){
            $anexo = $_POST['anexo'];
            c_guardar_permisos::c_buscar_anexo($anexo);
        }


class c_guardar_permisos 
{
    static function c_guardar_datos()
    {
       $m_permisos = new m_guardar_permisos();
       $c_permisos = $m_permisos->m_guardar_permisos();  
       print_r($c_permisos);
    }

    static function c_actualizar_datos(){
        $m_permisos = new m_guardar_permisos();
        $c_permisos = $m_permisos->m_actualizar_permisos();
        print_r($c_permisos);  
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