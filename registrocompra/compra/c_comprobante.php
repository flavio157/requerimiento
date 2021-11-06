<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    }else if ($accion == 'guardarcom'){
        $fechemision = $_POST['txtcomfecemision'];
        $horaemision = $_POST['txtcomhoremision'];
        $fechentrega = $_POST['txtcomfecentrega'];
        $codpersonal = $_POST['txtcomcodpers'];
        $nompersonal = $_POST['txtcompersonal'];
        $tipocomprob = $_POST['slctipocompr'];
        $formapago = $_POST['slcformpago'];
        $tipomoneda = $_POST['slcmoneda'];
        if(!isset($_POST['txttipocambio'])){
            $tipocambio = 0.00;
        }else{
            $tipocambio = $_POST['txttipocambio']; 
        }
        $usuregistro = $_POST['usuario'];
        $almacen = $_POST['almacen'];
        if($fechemision == ""){print_r("Error ingrese fecha de emision"); return;}
        if($horaemision == ""){print_r("Error ingrese hora de emision"); return;}
        if($fechentrega == ""){print_r("Error fecha de entrega"); return;}
        if($codpersonal == ""){print_r("Error personal invalido"); return;}
        if($nompersonal == ""){print_r("Error ingrese personal"); return;}
        if($tipocomprob == ""){print_r("Error ingrese el tipo comprobante"); return;}
        if($formapago == ""){print_r("Error ingrese forma de pago"); return;}
        if($tipomoneda == ""){print_r("Error ingrese el tipo de moneda"); return;}
        if($tipomoneda == 'D' && strlen(str_replace(".","",$tipocambio)) < 3 ){print_r("Error ingrese el tipo de cambio minimo 3"); return;}
        
        if(!is_numeric($tipocambio) && $tipocambio != ""){print_r("Error solo numero en tipo de cambio"); return;}
        if(!isset($_POST['rdnigv']) && !isset($_POST['rdnigv'])){
            print_r("Seleecione si contiene IGV");
            return;
        }else{
            $contiIGV = $_POST['rdnigv'];
        }
        $productos =json_decode($_POST['productos']);
        $observacio = $_POST['txtcompobservacion'];
        c_comprobante::c_guardarcompro($fechemision, $horaemision,$fechentrega,$codpersonal
                        ,$nompersonal,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,
                        $observacio,$usuregistro,$almacen,$productos);
    }elseif($accion == 'guardarperso') {
        $nombre = $_POST['mtxtnomperson'];
        $direccion = $_POST['mtxtdirper'];
        $dni = $_POST['mtxtdniper'];
        $cargo =$_POST['slcargpers'];
        $salario = $_POST['mtxtsalperso'];
        $area = $_POST['slareaper'];
        $departamento = $_POST['sldeparpers']; 
        $provincia = $_POST['slprovpers']; 
        $distrito = $_POST['sldistpers'];
        $telefono = $_POST['mtxttelpers'];
        $celular = $_POST['mtxtcelpers'];
        $cuenta = $_POST['mtxtcuenpers'];
        $titular =$_POST['mtxttitulpers'];
        $usuario = $_POST['usuario'];
        $fechaingreso = $_POST['mtxtfecingreso'];
        c_comprobante::c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso);
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
            $patron = "/^[0-9\.]+$/";
            $codig = trim($codig);
            $m_producto = new m_comprobante();
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

        static function c_guardarcompro($fechemision, $horaemision,$fechentrega,$codpersonal
                  ,$nompersonal,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,$usuregistro,$almacen,$productos){
           $emision = strtotime($fechemision);
           $entrega  = strtotime($fechentrega);
           $total = 0.00;
           //if($emision < $entrega){print_r("Error la fecha de emision no debe ser menor a fecha de entrega"); return;}
            $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
            if(strlen(str_replace(" ", "", $observacio)) < 20){print_r("Error comentario invalido"); return;}
            if(preg_match($pattern,$observacio) == 0){print_r("Error comentario invalido solo letras"); return;}
            if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}  
            foreach ($productos->tds as $dato){
               $total = floatval($total) + floatval($dato[3]);
            }
            $m_producto = new m_comprobante();
            $c_guardarprod = $m_producto->m_guardarcompr($fechemision,$horaemision,$fechentrega,$codpersonal
                        ,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,$usuregistro,$almacen,$productos,$total);
            print_r($c_guardarprod);            
        }
    
    
        static function c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso)
        {
            $numero = "/^[0-9]+$/";
            $letras = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
            $moneda = "/^[0-9\.]+$/";
            
            $cantnombre = explode(" ", $nombre);
            $cantdireccion = explode(" ", $direccion);
            $titular = explode(" ",$titular);
            if($fechaingreso == ""){print_r("Error seleccione fecha de ingreso"); return;}
            if(preg_match($numero,$dni) == 0){print_r("Error DNI solo numeros"); return;}
            if(strlen($dni) > 8 ||strlen($dni) < 8 ){print_r("Error DNI solo 8 digitos"); return;}
            if(count($cantnombre) < 3){print_r("Error minimo un nombre y dos apellidos"); return;}
            if(count($cantdireccion) < 3){print_r("Error direccion invalido"); return;}
            if(strlen($nombre) == 0){print_r("Error nombre invalido"); return;}
            if(preg_match($letras,$nombre) == 0){print_r("Error solo letras en el nombre"); return;}
            if(strlen($direccion) == 0){print_r("Error direccion invalido"); return;}
            if(preg_match($moneda,$salario) == 0){print_r("Error salario solo numeros"); return;}
            if(preg_match($numero,$telefono) == 0){print_r("Error telefono solo numeros"); return;}
            if(preg_match($numero,$celular) == 0){print_r("Error celular solo numeros"); return;}
            if(strlen($celular) > 9 || strlen($celular)  < 9){print_r("Error celular solo 9 digitos"); return;}
            if(count($titular) < 3){print_r("Error minimo un nombre y dos apellidos en titular"); return;}
            $m_personal = new m_comprobante();
            $c_personal = $m_personal->m_guardarpersonal(strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso);
            print_r(1);
        }
    
    
    }
    



?>