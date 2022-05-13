<?php
date_default_timezone_set('America/Lima');
require_once("m_tareas.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/cod_almacenes.php");
    $accion = $_POST['accion'];
    if($accion == "personal"){
        c_tareas::c_filtarpersonal();
    }else if($accion == "gnuevatarea"){
        $nomtarea = $_POST['nomtarea'];
        $slctipotarea = $_POST['slctipotarea'];
        $usu = $_POST['usu'];
        c_tareas::c_gtareas($nomtarea,$slctipotarea,$usu);
    }else if($accion == 'sugtarea'){
        c_tareas::c_filtartareas();
    }else if($accion == 'sindevolver'){
        $codpersonal = $_POST['dato'];
        c_tareas::c_mat_sin_devolver($codpersonal);
    }else if($accion == 'gcabecera'){
        $codperson = $_POST['codperson'];
        $dtincio = $_POST['dtincio'];
        $dtfin = $_POST['dtfin'];
        $reprogramar = $_POST['reprogramar'];
        $usu = $_POST['usu'];
        c_tareas::c_guardarcab($codperson,$dtincio,$dtfin,$reprogramar,$usu);
    }

    
    class c_tareas
    {
        static function c_filtartareas()
        {
            $tareas = array();
            $m_tareas = new m_tareas();
            $cadena = "EST_TAREA = '1'";
            $c_tareas = $m_tareas->m_buscar('T_TAREAS',$cadena);
            for ($i=0; $i < count($c_tareas) ; $i++) { 
                array_push($tareas,array(
                    "code" => $c_tareas[$i][0],
                    "label" => $c_tareas[$i][1]));
            }
            $dato = array(
                'dato' => $tareas
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 

        static function c_mat_sin_devolver($cod_personal)
        {
            $material = new m_tareas();
            $cod_personal = trim($cod_personal);
            $cadena = "CODIGO_PER = '$cod_personal' and cantidad != '0'";
            $sindevolver = $material->m_buscar('V_MAT_SIN_DEVOLVER',$cadena);
            $cadena1 = "personal = '$cod_personal' and cantidad != 0";
            $dxdia =  $material->m_buscar('V_MATERIALES_X_DIA',$cadena1);

            $dato = array(
                 'dato' => $sindevolver,   
                 'dxd' => $dxdia
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_tareas();
            $cadena = "EST_PERSONAL = '1'";
            $c_personal = $m_personal->m_buscar('T_PERSONAL',$cadena);
           
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => $c_personal[$i][5]));
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 

        static function c_gtareas($nomtarea,$slctipotarea,$usu){
            $mensaje = "";
            if(strlen(trim($nomtarea)) == 0){$mensaje = "Error ingrese nombre de la nueva tarea";}
            if(strlen(trim($slctipotarea)) == 0){$mensaje ="Error seleccione si en la tarea se necesita herramienta";}
            if($mensaje != ""){
                $dato = array('c' => $mensaje);
            }else{
                $m_tareas = new m_tareas();
                $c_tareas = $m_tareas->m_gnuevatarea($nomtarea,$slctipotarea,$usu);
                if(is_array($c_tareas)){
                    $dato = array('c' => $c_tareas[0],'e' => $c_tareas[1]);
                }else{
                    $dato = array('c' => "-1");
                }
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);    
        }

        static function c_guardarcab($codperson,$dtincio,$dtfin,$reprogramar,$usu){
            $mensaje = "";
            if(strlen(trim($codperson)) == 0){$mensaje = "Error seleccione personal";}
            $count = diferenciaFechas($dtincio,$dtfin);
            if($count > 0){$mensaje = "Error la fecha fin no puede se menor a la fecha de inicio";} 
           
            if($mensaje != ""){
                $dato = array('c' => $mensaje);
            }else{
                $m_tareas = new m_tareas();
                $c_cabtarea = $m_tareas->m_guardarcab($codperson,$dtincio,$dtfin,$reprogramar,$usu);
                if(is_array($c_cabtarea)){
                    $dato = array('c' => $c_cabtarea[0],'e' => $c_cabtarea[1]);
                }else{
                    $dato = array('c' => "-1");
                }
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);    
        }

    }
?>