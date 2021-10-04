<?php
require_once("../funciones/m_materialsalida.php");
    $accion = $_POST['accion'];
    if($accion == "personal"){
        $dato = $_POST['dato'];
        c_materialesalida::c_buscarlike('T_PERSONAL','EST_PERSONAL','NOM_PERSONAL1',"''",'A',$dato,$accion,'');
    }else if($accion == "material"){
        $dato = $_POST['dato'];
        c_materialesalida::c_buscarlike('T_PRODUCTO','EST_PRODUCTO','DES_PRODUCTO','COD_CATEGORIA','A',$dato,$accion,'00003');
    }else if($accion == "sindevolver"){
        $cod_pers = $_POST['dato'];
        c_materialesalida::c_mat_sin_devolver($cod_pers);
    }else if($accion == 'guardar'){
        c_materialesalida::c_guardar();
    }

    class c_materialesalida
    {
        static function c_buscarlike($tabla,$columna1,$columna2,$columna3,$estado,$dato,$tipo,$categoria){
                $material = new m_materiasalida();
                $buscar = $material->m_buscarlike($tabla,$columna1,$columna2,$columna3,$estado,$dato,$categoria);
                if($tipo == 'personal')$lista = self::listar($buscar,0,5,0);
                else $lista = self::listar($buscar,0,2,22);
                echo $lista; 
        }  
        
        static function listar($buscar,$campo1,$campo2,$campo3){
            $html = "";
            foreach($buscar as $campos){
                $html.= '<div><a class="suggest-element" datatip="'.$campos[$campo3].'" dataid="'.$campos[$campo1].'" data="'.$campos[$campo2].'">'.$campos[$campo2].'</a></div>';
            }
            return $html;
        }

        static function c_mat_sin_devolver($cod_personal)
        {
            $material = new m_materiasalida();
            $sindevolver = $material->m_buscar($cod_personal,'V_MAT_SIN_DEVOLVER','CODIGO_PER');
            $dato = array(
                 'dato' => $sindevolver,   
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        //para verificar los si el producto tiene devolucion
        static function c_tipoclase($codpersonal,$clase,$codproducto)
        {   
            $material = new m_materiasalida();
            if($clase == '00001'){
                $material->m_buscar($codpersonal,'T_MATERIALES_SALIDA','PERSONAL_SOLICITO');
                foreach($material as $materiales){
                    if($materiales[1] == $codproducto )
                    print_r("encontro un producto que requiere devolucion");
                    else 
                    print_r("entonces entrega el producto sin que requiera devolucion saliendo un mesaje informando que
                    tiene materiales que saco del almacen");
                }
            }else if($clase == '00002'){
               //registra el material de salida
            }
        }

        static function c_verificarstock($codmaterial,$cantmaterial)
        {
            $material = new m_materiasalida();
            $materiales = $material->m_buscar($codmaterial,'T_ALMACEN_INSUMOS','COD_PRODUCTO');
            if($materiales[4] > $cantmaterial){
                //mensaje indicando que no hay stock o que entrege los materiales que tiene
                //restando todo el stock
                print_r("mensaje de que no hay stock");
            }else{
                print_r("actualiza el campo de stock descontando la cantidad de material ingresado");
            }
        }

        static function c_guardar()
        {
           $material = new m_materiasalida();
          // $materiales = $material->m_guardar('T_MATERIALES_SALIDA');
           //print_r($materiales);
        }
      
    }
?>