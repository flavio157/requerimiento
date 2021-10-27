<?php
require_once("m_comprobante.php");
    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_comprobante::c_listapersonal();
    }else if($accion == 'producto'){
        c_comprobante::c_listarproductos();
    }else if($accion == 'lstcategoria'){
        c_comprobante::c_litarcategoria('T_CATEGORIA','EST_CATEGORIA','1');
    }else if ($accion  == 'lstclase'){
        c_comprobante::c_litarcategoria('T_CLASE_MATERIAL','EST_CLASE','A');
    }else if($accion == "guardarproc"){
        $producto = $_POST['producto'];
        $oficina =  oficiona($_POST['oficina']);
        $unidad = $_POST['unidad'];
        $codigopro = $_POST['codigopro'];
        $abre = $_POST['abre'];
        $stock_minimo = $_POST['stockminimo'];
        $neto = $_POST['neto'];
        $clase = $_POST['clase'];
        $personal = $_POST['personal'];
        c_comprobante::guardarproducto($producto,$unidad,$codigopro,$abre,$neto,$clase,$personal,$stock_minimo,$oficina);
    }  
    class c_comprobante
    {
        static function c_listapersonal(){
            $personal = array();
            $m_personal = new m_comprobante();
            $cadena = "EST_PERSONAL = 'A'";
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

        static function c_listarproductos(){
            $producto = array();
            $m_producto = new m_comprobante();
            $cadena = "EST_PRODUCTO = 'A'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][2]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_litarcategoria($tabla,$campo,$dato)
        {
            $categoria = array();
            $m_categoria = new m_comprobante();
            $cadena = "$campo = '$dato'";
            $c_categoria = $m_categoria->m_buscar($tabla,$cadena);
            for ($i=0; $i < count($c_categoria) ; $i++) { 
                array_push($categoria,array(
                    "0" => $c_categoria[$i][0],
                    "1" => $c_categoria[$i][1]));
            }
            $dato = array(
                'dato' => $categoria
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function guardarproducto($producto,$unidad,$codigopro,$abre,$neto,$clase,$personal,$stock_minimo,$oficina){
            if(!ctype_alpha($unidad)){print_r("Solo se permiten letras"); return;}
            if(strlen($unidad) > 10){print_r("Unidad de medida maximo 10 caracteres"); return;}
            if(strlen($abre) > 4){print_r("Abreviatura maximo 4 caracteres"); return;}
            $material = new m_comprobante(); 
            $c_guardarprod = $material->m_guardarprod($producto,$unidad,$codigopro,$abre,$neto,$clase,$personal,$stock_minimo,$oficina);
            print_r($c_guardarprod);
        }

    }
    


?>