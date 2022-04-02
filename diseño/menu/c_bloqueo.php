<?php
    require_once("m_bloqueo.php");
    $accion = $_POST['accion'];
    if($accion == 'lstmatexdia'){
        c_bloqueo::c_material_x_dia();
    }else if($accion == 'bloquepro'){
        c_bloqueo::c_bloquProduc();
    }else if($accion == 'desbloqueo'){
        $codigo = $_POST['cod'];
        c_bloqueo::c_desbloqueo($codigo);
    }
    
    class c_bloqueo 
    {
        static function c_material_x_dia(){
            session_start();
            $material = new m_bloqueo();
            $materiales = $material->m_material_x_dia($_SESSION["cod"]);
            $dato = array(
                'dato' => $materiales
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        
        static function c_bloquProduc()
        {
            session_start();
            $material = new m_bloqueo();
            $materiales = $material->m_bloqueproduc($_SESSION["cod"]);
            print_r($materiales);
           
        }

        static function c_desbloqueo($codigo){
            $material = new m_bloqueo();
            $produccion = $material->m_desbloqueo($codigo);
            print_r($produccion);
        }
    }
?>