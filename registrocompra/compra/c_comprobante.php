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
        $codpro = $_POST['codigopro'];
        $codcateg = $_POST['categoria'];
        $despro = $_POST['nomprod'];
        $unimedpro = $_POST['unidad'];
        $stockmin = $_POST['sctockmin'];
        $abre = $_POST['abre'];
        $usuregi = $_POST['usuregis'];
        $pesoneto = $_POST['neto'];
        $codclase = $_POST['clase'];
        $oficina = $_POST['oficina'];
        c_comprobante::guardarproducto($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina);
    }else if($accion == "verdatpro"){
        $codig = $_POST['codigo'];
        $product = $_POST['produ'];
        $canpro = $_POST['cant'];
        $prepro = $_POST['precio'];
        $seriepro = $_POST['serie'];
        c_comprobante::c_verdatpro($codig,$product,$canpro,$prepro,$seriepro);
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
                    "label" => $c_producto[$i][2],
                    "clase" => $c_producto[$i][16]));
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

        static function guardarproducto($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina){
            $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
            if(strlen($codpro) > 6 || strlen($codpro) < 6){print_r("Codigo producto debe tener 6 caracteres");return;}
            if(strlen($unimedpro) < 2 || strlen($unimedpro) > 10){print_r("Unidad de medida minimo 2 y maximo 4 caracteres"); return;}
            if(preg_match($pattern,$unimedpro) == 0){print_r("Unidad de medida solo letras"); return;}
            if(strlen($despro) < 6){print_r("Nombre del producto minimo 6 caracteres"); return;}
            if(preg_match($pattern,$despro) == 0){print_r("Nombre del producto solo letras"); return;}
            if(strlen($codcateg) == 0){print_r("Seleccione categoria"); return;}
            if(strlen($abre) > 4 || strlen($abre) < 2){print_r("Abreviatura minimo 2 y maximo 4 caracteres"); return;}
            if(preg_match($pattern,$abre) == 0){print_r("Abreviatura solo letras"); return;}
            if(strlen($stockmin) < 2){print_r("Stock minimo minimo 2 caracteres"); return;};
            if(!is_numeric($stockmin)){print_r("Stock minimo solo numeros"); return;};
            if(strlen($pesoneto) < 1){print_r("Peson neto minimo 1 caracter"); return;};
            if(!is_numeric($pesoneto)){print_r("Peso neto solo numeros"); return;};
            if(strlen($codclase) == 0){print_r("Seleccione clase del producto"); return;}
            $material = new m_comprobante(); 
            $c_guardarprod = $material->m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina);
            print_r(1);
        }

        static function c_verdatpro($codig,$product,$canpro,$prepro,$seriepro)
        {    
            $codig = trim($codig);
            $m_producto = new m_comprobante();
            if(strlen($codig) == 0){print_r("Producto invalido"); return;}
            $cadena = "COD_PRODUCTO = '$codig'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_producto) == 0){print_r("Producto no existe"); return;}
            if(strlen($canpro) == 0){print_r("Cantidad minimo 1 caracter"); return;}
            if(!is_numeric($canpro)){print_r("Cantidad solo numeros"); return;}
            if(strlen($prepro) == 0){print_r("Precio minimo 1 caracter"); return;}
            if(!is_numeric($prepro)){print_r("Precio solo numeros"); return;}
            if($c_producto[0][16] == '00001'){
                if($seriepro == ""){
                    print_r("Nro de serie obligatorio");
                }
            }
        }
    }
    


?>