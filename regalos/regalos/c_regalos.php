<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_regalos.php");

    $accion = $_POST['accion'];
    if($accion == 'filtrar'){
       $zona = $_POST['zona']; 
       c_regalos:: c_filtarproducto($zona);
    }else if($accion == 'evaluar'){
        $producto = json_decode($_POST['producto']);
        c_regalos:: c_evaluacion($producto);
    }

    class c_regalos
    {
        static function c_filtarproducto($zona)
        {
            $material = array();
            $m_personal = new m_regalos();
            $c_material = $m_personal->m_buscar($zona);
            for ($i=0; $i < count($c_material) ; $i++) { 
                array_push($material,array(
                    "code" => $c_material[$i][0],
                    "label" => $c_material[$i][4],
                    "precio" => $c_material[$i][8],
                    "gramaje" => $c_material[$i][10],
                ));
            }
            $dato = array(
                'dato' => $material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_evaluacion($producto)
        {
            $cabecera = array();
            $cuerpo = array();
            $m_regalo = new m_regalos();

            if(count($producto->tds) == 0){
               print_r("Error no hay datos en la tabla");
            }else{
                foreach ($producto->tds as $cabe){
                  $datos = $m_regalo->m_evaluacion($cabe[0]);
                  
                  if(count($datos) > 0){
                    for($i = 0;$i < count($datos);$i++){
                        if(trim($datos[$i][1]) == trim($cabe[0])){
                            $dato = c_regalos::buscarPromo($cabe[0],$producto,$datos,$cuerpo,$cabe[3]);
                            $cuerpo = $dato[0];
                            array_push($cabecera,$dato[1]);
                            array_push($cabecera,array($cabe[0],$cabe[4],$cabe[1],$cabe[2],$cabe[3]));
                        } 
                    }  
                  }else{
                        if(!in_array($cabe[3],$cuerpo) ){
                            array_push($cabecera,array($cabe[0],$cabe[4],$cabe[1],$cabe[2],$cabe[3]));
                        } 
                  }  
                }
            }
         print_r($cabecera);
        }

        static function buscarPromo($promo,$producto,$c_evaluacion,$cuerpo,$prod)
        {
            foreach ($producto->tds as $cabe){
                for ($i=0; $i < count($c_evaluacion) ; $i++) {
                    if(trim($promo) == trim($c_evaluacion[$i][1]) && trim($cabe[0]) == trim($c_evaluacion[$i][4])){
                        if(!in_array($cabe[3],$cuerpo)){
                            array_push($cuerpo,$cabe[3]);
                            array_push($cuerpo,$prod);
                            return array($cuerpo,array($cabe[0],$cabe[4],$c_evaluacion[$i][6],$cabe[2],$cabe[3]));
                        }
                    }    
                }
            }
        }
    }
?>

