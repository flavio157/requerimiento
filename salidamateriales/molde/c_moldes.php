<?php
    require_once("m_moldes.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_moldes::filtarpersonal();
    }else if($accion == 'lstmoldes'){
        c_moldes::lstmoldes();
    }else if($accion == 'lstmateriales'){
        $dato = $_POST['dato'];
        c_moldes::lstmateriales($dato);
    }  

    class c_moldes 
    {
        static function filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_moldes();
            $wher = array(
                'EST_PERSONAL' => 'A',
            );   
            $valores = select_where($wher);
            $c_personal = $m_personal->m_buscar('T_PERSONAL',$valores);
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

        static function lstmoldes()
        {
            $personal = array();
            $m_personal = new m_moldes();
            $wher = array(
                'ESTADO' => 'A',
            );   
            $valores = select_where($wher);
            $c_personal = $m_personal->m_buscar('T_MOLDE',$valores);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => trim($c_personal[$i][1]),
                    "medida" => $c_personal[$i][2]));
            }
            $dato = array(
                'dato' => $personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
          
        } 

        static function lstmateriales($dato)
        {
            $m_personal = new m_moldes();
            $wher = array(
                'ID_MOLDE' => $dato,
            );   
            $valores = select_where($wher);
            $c_personal = $m_personal->m_buscar('V_MATERIAL_MOLDE',$valores);
            $dato = array(
                'dato' => $c_personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    }
?>