<?php
    require_once("../funciones/m_materialsalida.php");
    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_moldes::filtarpersonal();
    }   

    class c_moldes 
    {
        static function filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_materiasalida();
            $wher = array(
                'EST_PERSONAL' => 'A',
            );   
            $valores = select_where($wher);
            $c_personal = $m_personal->m_buscar('T_PERSONAL',$valores);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,$c_personal[$i][5]);
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
          
        } 
    }
?>