<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_guardarmaterial.php");
    $accion = $_POST['accion'];
    if($accion == 'lstcategoria'){
        c_guardarmaterial::c_litarcategoria('T_CATEGORIA','EST_CATEGORIA','1');
    }else if ($accion  == 'lstclase'){
        c_guardarmaterial::c_litarcategoria('T_CLASE_MATERIAL','EST_CLASE','A');
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
        c_guardarmaterial::guardarproducto($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina);
    }else if($accion == "verdatpro"){
        $codig = $_POST['codigo'];
        $product = $_POST['produ'];
        $canpro = $_POST['cant'];
        $prepro = $_POST['precio'];
        $seriepro = $_POST['serie'];
        c_guardarmaterial::c_verdatpro($codig,$product,$canpro,$prepro,$seriepro);
    }else if($accion == 'codpro'){
        c_guardarmaterial::c_codprod();
    }else if($accion == 'lstmaterial'){
        c_guardarmaterial::c_lstmaterial();
    }else if($accion == 'updatematerial'){
        $codpro = $_POST['codpro'];
        $unidad = $_POST['unidad'];
        $nombre = $_POST['nomprod'];
        $categoria = $_POST['categoria'];
        $abre = $_POST['abre'];
        $stock = $_POST['sctockmin'];
        $neto = $_POST['neto'];
        $clase = $_POST['clase'];
        $usu = $_POST['usuregis'];
        c_guardarmaterial::c_actualizarprod($codpro,$categoria,$nombre,$unidad,$abre,$stock,$neto,$clase,$usu);
    }
    class c_guardarmaterial
    {
        
        static function c_lstmaterial()
        {
            $producto = array();
            $m_producto = new m_guardarmaterial();
            $cadena = "EST_PRODUCTO = '1' AND COD_CATEGORIA != ''";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => trim($c_producto[$i][0]),
                    "label" => trim($c_producto[$i][2]),
                    "uni" => trim($c_producto[$i][3]),
                    "cat" => trim($c_producto[$i][1]),
                    "abr" => trim($c_producto[$i][5]),
                    "mini" => trim($c_producto[$i][4]),
                    "peso" => trim($c_producto[$i][15]),
                    "clase" => trim($c_producto[$i][16]),
                ));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }    




        static function c_litarcategoria($tabla,$campo,$dato)
        {
            $categoria = array();
            $m_categoria = new m_guardarmaterial();
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
            $material = new m_guardarmaterial();
            $cadena = "COD_PRODUCTO = '$codpro'";
            $c_verificarcod = $material->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_verificarcod) > 0){print_r("Error el codigo del producto ya existe");return;}
            $pattern = "/^[a-zA-Z\s??????????????????????.,;]+$/";
            if(strlen($codpro) > 6 || strlen($codpro) < 6){print_r("Codigo producto debe tener 6 caracteres");return;}
            if(strlen($unimedpro) > 3){print_r("Error unidad de medida maximo 3 caracteres"); return;}
            if(strlen($unimedpro) < 2){print_r("Unidad de medida minimo 2 caracteres"); return;}
            if(strlen($despro) < 6){print_r("Error nombre del producto minimo 6 caracteres"); return;}
            if(strlen($despro) > 50){print_r("Error nombre del producto maximo 50 caracteres"); return;}
            if(strlen($codcateg) == 0){print_r("Seleccione categoria"); return;}
            if(strlen($abre) > 4 || strlen($abre) < 2){print_r("Abreviatura minimo 2 y maximo 4 caracteres"); return;}
            if(preg_match($pattern,$abre) == 0){print_r("Abreviatura solo letras"); return;}
            if(strlen($stockmin) < 1){print_r("Error campo stock, minimo 1 digitos"); return;};
            if(strlen($stockmin) > 5){print_r("Error campo stock, maximo 5 digitos"); return;};
            if(!is_numeric($stockmin)){print_r("Error stock minimo, solo numeros"); return;};
            if(!is_numeric($pesoneto)){print_r("Error peso neto solo numeros"); return;};
            if(strlen($pesoneto) < 1){print_r("Error peso neto minimo 1 digito"); return;};
            if(strlen($pesoneto) > 9){print_r("Error peso neto maximo 9 digitos"); return;};
            if($codcateg == "00001" || $codcateg == "00002"){
                $codclase = "00002";
            }else{
                if(strlen($codclase) == 0){print_r("Seleccione clase del producto"); return;}
            }
            $c_guardarprod = $material->m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina);
            print_r(1);
        }

        static function c_verdatpro($codig,$product,$canpro,$prepro,$seriepro)
        {
            $patron = "/^[0-9\.]+$/";
            $codig = trim($codig);
            $m_producto = new m_guardarmaterial();
            if(strlen($codig) == 0){print_r("Producto invalido"); return;}
            $cadena = "COD_PRODUCTO = '$codig'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_producto) == 0){print_r("Producto no existe"); return;}
            if(strlen($canpro) == 0){print_r("Cantidad minimo 1 caracter"); return;}           
            if( preg_match($patron,$canpro) == 0){print_r("Cantidad solo numeros"); return;}
            if(strlen($prepro) == 0){print_r("Precio minimo 1 caracter"); return;}
            if( preg_match($patron,$prepro) == 0){print_r("Precio solo numeros"); return;}
            if($c_producto[0][16] == '00001'){
                if(strlen($seriepro) > 10){print_r("Nro de serie solo 10 caracteres");
                    return;}
                if($seriepro == ""){
                    print_r("Nro de serie obligatorio");
                    return;
                }
                if($canpro > 1){
                    print_r("El Nro de serie no puede se igual en mas de un producto");
                    return;
                }
            }
            print_r(1);
        }


        static function c_codprod()
        {
            $m_personal = new m_guardarmaterial();
            $c_area = $m_personal->m_select_generarcodigo('COD_PRODUCTO','T_PRODUCTO',6);
            print_r($c_area);
        }

        static function c_actualizarprod($codpro,$categoria,$nombre,$uni,$abre,$stock,$peso,$clas,$usu){
            $pattern = "/^[a-zA-Z\s??????????????????????.,;]+$/";
            if(strlen($codpro) > 6 || strlen($codpro) < 6){print_r("Codigo producto debe tener 6 caracteres");return;}
            if(strlen($uni) > 3){print_r("Error unidad de medida maximo 3 caracteres"); return;}
            if(strlen($uni) < 2){print_r("Unidad de medida minimo 2 caracteres"); return;}
            if(strlen($nombre) < 6){print_r("Error nombre del producto minimo 6 caracteres"); return;}
            if(strlen($nombre) > 50){print_r("Error nombre del producto maximo 50 caracteres"); return;}
            if(strlen($categoria) == 0){print_r("Seleccione categoria"); return;}
            if(strlen($abre) > 4 || strlen($abre) < 2){print_r("Abreviatura minimo 2 y maximo 4 caracteres"); return;}
            if(preg_match($pattern,$abre) == 0){print_r("Abreviatura solo letras"); return;}
            if(strlen($stock) < 1){print_r("Error campo stock, minimo 1 digitos"); return;};
            if(strlen($stock) > 5){print_r("Error campo stock, maximo 5 digitos"); return;};
            if(!is_numeric($stock)){print_r("Error stock minimo, solo numeros"); return;};
            if(!is_numeric($peso)){print_r("Error peso neto solo numeros"); return;};
            if(strlen($peso) < 1){print_r("Error peso neto minimo 1 digito"); return;};
            if(strlen($peso) > 9){print_r("Error peso neto maximo 9 digitos"); return;};
            $m_producto = new m_guardarmaterial();
            if($categoria == "00001" || $categoria == "00002"){
                $clas = "00002";
            }else{
                if(strlen($clas) == 0){print_r("Seleccione clase del producto"); return;}
            }
            $c_area = $m_producto->m_actulizarprod($codpro,$categoria,strtoupper($nombre),
            strtoupper($uni),strtoupper($abre),$stock,$peso,$clas,$usu);
            print_r($c_area);
        }
    }

?>