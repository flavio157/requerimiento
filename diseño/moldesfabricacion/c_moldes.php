<?php
    require_once("m_moldes.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_moldes::c_filtarpersonal();
    }else if($accion == 'lstmateriales'){
        $dato = $_POST['dato'];
        c_moldes::c_lstmateriales('molde',$dato,'V_MATERIAL_MOLDE');
    }else if($accion == 'lstfabricacion'){
        c_moldes::Moldesfabricacion();
    }else if($accion == 'lstmaterial'){
        c_moldes::c_material();
    }else if($accion == 'terminomolde'){
        $molde = $_POST['molde'];
        $fabricacion = $_POST['fabricacion'];
        $usuario = $_POST['usu'];
        c_moldes::c_moldefinfabric($molde,$fabricacion,$usuario);
    }else if($accion == 'lstpersinvolu'){
        $dato = $_POST['dato'];
        c_moldes::c_lstmateriales('fabricacion',$dato,'V_PERSONAL_FABRICACION');
    }else if($accion == 'cliente'){
        $dato = $_POST['dato'];
        c_moldes::c_lstmateriales('COD_CLIENTE',$dato,'T_CLIENTE_MOLDE');
    }

    class c_moldes 
    {
        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_moldes();
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

        static function c_material()
        {
            $material = array();
            $m_personal = new m_moldes();
            $cadena = "EST_PRODUCTO = '1'";
            $c_personal = $m_personal->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) { 
                array_push($material,array(
                    "code" => $c_personal[$i][0],
                    "label" => $c_personal[$i][2],
                    "unidad" => $c_personal[$i][3]));
            }
            $dato = array(
                'dato' => $material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_lstmateriales($campo,$dato,$tabla)
        {
            $m_personal = new m_moldes();
            $cadena = "$campo = '$dato'";
            $c_personal = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'dato' => $c_personal
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

    
        static function Moldesfabricacion()
        {
            $m_molde = new m_moldes();
            $dato = 'ESTADO = 1 AND fin_fabricacion = 0';
            $c_molde = $m_molde->m_buscar('V_MOLDES_FABRICACION',$dato);
            $dato = array(
                'dato' => $c_molde
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
    
        }
        
        static function c_moldefinfabric($molde,$fabricacion,$usuario){
            $m_material = new m_moldes(); 
            $c_actualizar = $m_material->m_finfabricion($molde,$fabricacion,$usuario);
            print_r($c_actualizar);
        }

       
      
    }
?>