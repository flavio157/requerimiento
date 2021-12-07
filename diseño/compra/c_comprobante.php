<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_comprobante.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];
    if($accion == 'personal'){
        c_comprobante::c_listapersonal();
    }else if($accion == 'producto'){
        c_comprobante::c_listarproductos();
    }else if($accion == 'proveedor'){
        c_comprobante::c_listarproveedor();
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
        $fechentrega = $_POST['txtcomfecentrega'];
        $codpersonal = $_POST['txtcomcodpers'];
        $nompersonal = $_POST['txtcompersonal'];
        $tipocomprob = $_POST['slctipocompr'];
        $nrocompro = $_POST['txtnrocompro'];
        $correlativo = $_POST['txtcorrecomp'];
        $formapago = $_POST['slcformpago'];
        $tipomoneda = $_POST['slcmoneda'];
        $proveedor = $_POST['txtcodproveedor'];
        if(!isset($_POST['txttipocambio'])){
            $tipocambio = 0.00;
        }else{
            $tipocambio = $_POST['txttipocambio']; 
        }
        $usuregistro = $_POST['usuario'];
        $almacen = $_POST['almacen'];
        if($fechemision == ""){print_r("Error ingrese fecha de emision"); return;}
        if($fechentrega == ""){print_r("Error fecha de entrega"); return;}
        if($codpersonal == ""){print_r("Error personal invalido"); return;}
        if($nompersonal == ""){print_r("Error ingrese personal"); return;}
        if($tipocomprob == ""){print_r("Error ingrese el tipo comprobante"); return;}

        if($nrocompro == ""){print_r("Error ingrese el Numero combrobante"); return;}
        if($correlativo == ""){print_r("Error ingrese el correlativo del comprobante"); return;}

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
        c_comprobante::c_guardarcompro($fechemision,$fechentrega,$codpersonal
                        ,$nompersonal,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,
                        $observacio,$usuregistro,$almacen,$productos,$nrocompro,$correlativo,$proveedor);
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
    }else if($accion == 'area'){
        c_comprobante::c_lstarea('T_AREA','EST_AREA');
    }else if($accion == 'cargo'){
        c_comprobante::c_lstarea('T_CARGO','EST_CARGO');
    }else if($accion == 'depa'){
        c_comprobante::c_ubigeo('T_DEPARTAMENTO',"''","''");
    }else if($accion == 'provi'){
        $dato = $_POST['dato'];
        c_comprobante::c_ubigeo('T_PROVINCIA','COD_DEPARTAMENTO',$dato);
    }else if($accion == 'distri'){
        $dato = $_POST['dato'];
        c_comprobante::c_ubigeo('T_DISTRITO','COD_PROVINCIA',$dato);
    }else if($accion == 'codpro'){
        c_comprobante::c_codprod();
    }else if($accion == 'gproveedor'){
        $proveedor = $_POST['mtxtnomprovee'];
        $direccion = $_POST['mtxtdirprovee'];
        $ruc = $_POST['mtxtrucprovee'];
        $dni = $_POST['mtxtdniprovee'];
        $usu = $_POST['usu'];
        c_comprobante::c_guardarproveedor($proveedor,$direccion,$ruc,$dni,$usu);
    }

    class c_comprobante
    {
        static function c_listapersonal(){
            $personal = array();
            $m_personal = new m_comprobante();
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

        static function c_listarproductos(){
            $producto = array();
            $m_producto = new m_comprobante();
            $cadena = "EST_PRODUCTO = '1'";
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

        static function c_listarproveedor(){
            $producto = array();
            $m_producto = new m_comprobante();
            $cadena = "EST_PROVEEDOR = '1'";
            $c_producto = $m_producto->m_buscar('T_PROVEEDOR',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "cod" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1]));
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
            $material = new m_comprobante();
            $cadena = "COD_PRODUCTO = '$codpro'";
            $c_verificarcod = $material->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_verificarcod) > 0){print_r("Error el codigo del producto ya existe");return;}
            $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ.,;]+$/";
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
            if(strlen($codclase) == 0){print_r("Seleccione clase del producto"); return;}
            $c_guardarprod = $material->m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina);
            print_r(1);
        }

        static function c_verdatpro($codig,$product,$canpro,$prepro,$seriepro)
        {
            $patron = "/^[0-9\.]+$/";
            $codig = trim($codig);
            $m_producto = new m_comprobante();
            if(strlen($codig) == 0){print_r("Error producto invalido"); return;}
            $cadena = "COD_PRODUCTO = '$codig'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_producto) == 0){print_r("Error producto no existe"); return;}
            if(strlen($canpro) == 0){print_r("Error cantidad minimo 1 digito"); return;}           
            if( preg_match($patron,$canpro) == 0){print_r("Error cantidad solo numeros"); return;}

            $cantidad = explode(".", $canpro);
            if(strlen($cantidad[0]) > 6){print_r("Error campo cantidad, maximo 6 digitos con 3 decimales");return;}

            if(strlen($prepro) == 0){print_r("Error precio minimo 1 caracter"); return;}
            if( preg_match($patron,$prepro) == 0){print_r("Error precio solo numeros"); return;}

            $prec = explode(".", $prepro);
            if(strlen($prec[0]) > 4){print_r("Error campo precio, maximo 4 digitos con 3 decimales");return;}
            if($c_producto[0][16] == '00001'){
                if(strlen($seriepro) > 20){print_r("Error nro de serie solo 20 caracteres");return;}
                if(strlen($seriepro) < 6){print_r("Error nro de serie nimimo 6 caracteres");return;}
                if(count(count_chars($seriepro, 1)) < 4){print_r("Error numero de serie del producto invalido");return;}
                $conse = c_comprobante::validarserieprod($seriepro);
                if($conse == 1){print_r("Error numero de serie del producto invalido");return;}
                if($seriepro == ""){
                    print_r("Error Nro de serie obligatorio");
                    return;
                }
                $buscarserie = c_comprobante::buscregistroserie($seriepro);
                if(count($buscarserie) > 0 ){print_r("Error el numero de serie ya esta registrado"); return;}
                if($canpro > 1){
                    print_r("Error el nro de serie no puede se igual en mas de un producto");
                    return;
                }
            }
            print_r(1);
        }

        static function validarserieprod($nroseriepro){
            $array = ['123456789','123456','1234561','1234562','1234563',
                     '1234564','987654321','abcd','abcdefa',];
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$nroseriepro);
            for ($i=0; $i < count($array); $i++) { 
                if($arr[0] == $array[$i]){
                    return 1;
                }
                if(count($arr) > 1){
                    if($arr[1] == $array[$i]){
                        return 1;     
                    } 
                } 
            }
            return 0;
        }

        static function buscregistroserie($nroseriepro){
            $m_producto = new m_comprobante();
            $cadena = "NUM_SERIE = '$nroseriepro'";
            $c_producto = $m_producto->m_buscar('T_DETACOMP',$cadena);
            return $c_producto;
        }

        static function c_guardarcompro($fechemision,$fechentrega,$codpersonal
                  ,$nompersonal,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,
                  $usuregistro,$almacen,$productos,$nrocompro,$correlativo,$proveedor){
                      
            $m_producto = new m_comprobante();        
            $total = 0.00;
            $nrocompro = strtoupper($nrocompro);
            if(strlen($observacio) > 500){print_r("Error campo observacion sobrepaso el limite de caracteres"); return;}
            if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}
            if(strlen($proveedor) == 0){print_r("Error seleccione proveedor");return;}
            $correlativo = completarcontrato($correlativo);    
            $consulta = "NRO_COMPROBANTE = '$nrocompro' and CORREL_COMPROBANTE = '$correlativo' 
                         and TIPO_COMPROBANTE = '$tipocomprob' and COD_PROVEEDOR = '$proveedor'";
            $buscar = $m_producto->m_buscar("T_COMPROBANTE",$consulta);
            
            if(count($buscar) > 0){print_r("Error ya se registro un comprobante con el mismo numero de serie y correlativo"); return;}
            foreach ($productos->tds as $dato){
               $total = floatval($total) + floatval($dato[3]);
            }
            $c_guardarprod = $m_producto->m_guardarcompr($fechemision,$fechentrega,$codpersonal
                        ,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,
                        $usuregistro,$almacen,$productos,$total,$nrocompro,$correlativo,$proveedor);
            print_r($c_guardarprod);     
        }
    
    
        static function c_guardarpersol($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
        ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso)
        {
            $numero = "/^[0-9]+$/";
            $letras = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ.,;]+$/";
            $moneda = "/^[0-9\.]+$/";
            
            $cantnombre = explode(" ", $nombre);
            $cantdireccion = explode(" ", $direccion);
            $titularar = explode(" ",$titular);
            if($fechaingreso == ""){print_r("Error seleccione fecha de ingreso"); return;}
            if(preg_match($numero,$dni) == 0){print_r("Error DNI solo numeros"); return;}
            if(strlen($dni) > 8 ||strlen($dni) < 8 ){print_r("Error DNI solo 8 digitos"); return;}
            if(count($cantnombre) < 3){print_r("Error minimo un nombre y dos apellidos"); return;}
            if(count($cantdireccion) < 3){print_r("Error direccion invalido"); return;}
            if(strlen($nombre) == 0){print_r("Error nombre invalido"); return;}
            if(strlen($nombre) > 60 ){print_r("Error nombre del personal sobrepaso limite de 60 caracteres"); return;}
            if(preg_match($letras,$nombre) == 0){print_r("Error solo letras en el nombre"); return;}
            if(strlen($direccion) == 0){print_r("Error campo direccion vacio"); return;}
            if(strlen($direccion) > 100){print_r("Error direccion del personal sobrepaso limite"); return;}
            if(preg_match($moneda,$salario) == 0){print_r("Error salario solo numeros"); return;}
           
           
            $saldo = explode(".", $salario);
            if(strlen($saldo[0]) > 7){print_r("Error campo cantidad, maximo 7 digitos con 2 decimales");return;}
            
            if($cargo == "00000"){print_r("Error seleccione cargo"); return 0;}
            if($area == "00000"){print_r("Error seleccione area"); return 0;}
            if($departamento == "00000"){print_r("Error seleccione departamento"); return 0;}
            if($provincia == "00000"){print_r("Error seleccione provincia"); return 0;}
            if($distrito == "00000"){print_r("Error seleccione distrito"); return 0;}

            if($telefono != ""){
                if(preg_match($numero,$telefono) == 0){print_r("Error telefono solo numeros"); return;}
            }else{
                $telefono = 'NULL';
            }
            
            if($cuenta == ""){$cuenta = 'NULL';}
            if(preg_match($numero,$celular) == 0){print_r("Error celular solo numeros"); return;}
            if(strlen($celular) > 9 || strlen($celular)  < 9){print_r("Error celular solo 9 digitos"); return;}
            if($titular != ""){
                if(count($titularar) < 3){print_r("Error minimo un nombre y dos apellidos en titular"); return;}
                if(preg_match($letras,$titular) == 0){print_r("Error solo letras en titular"); return;}
                if(strlen($titular) > 50 ){print_r("Error nombre del titular sobrepaso limite de 50 caracteres"); return;}
            }else{
                $titular = 'NULL';
            }
            $m_personal = new m_comprobante();
            $c_personal = $m_personal->m_guardarpersonal(strtoupper($nombre),strtoupper($direccion),$dni,$cargo,$salario,$area,$departamento,$provincia
            ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso);
            print_r(1);
        }

        static function c_lstarea($tabla,$campo)
        {
            $m_personal = new m_comprobante();
            $cadena = "$campo= '1'";
            $c_area = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'area' => $c_area,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        
        static function c_ubigeo($tabla,$campo,$dato)
        {
            $m_personal = new m_comprobante();
            $cadena = "$campo= $dato";
            $c_area = $m_personal->m_buscar($tabla,$cadena);
            $dato = array(
                'area' => $c_area,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    
        static function c_codprod()
        {
            $m_personal = new m_comprobante();
            $c_area = $m_personal->m_generar_codpers('COD_PRODUCTO','T_PRODUCTO',6);
            print_r($c_area);
        }

        static function c_guardarproveedor($proveedor,$direccion,$ruc,$dni,$usu){
            if(strlen($proveedor) > 50){print_r("Error nombre del proveerod maxino 50 caracteres"); return;}
            if(strlen($direccion) > 100){print_r("Error nombre del proveerod maxino 100 caracteres"); return;}
            if(strlen($ruc) == 0 && strlen($dni) == 0){print_r("Error ingrese RUC o DNI del proveedor"); return;}
            if(strlen($ruc) != 0){
                if(strlen($ruc) > 11 || strlen($ruc) < 11){print_r("Error RUC minimo 11 caracteres"); return;}
                if(!is_numeric($ruc)){print_r("Error RUC solo numeros");return;}
            }
            if(strlen($dni) != 0){
                if(strlen($dni) > 8 || strlen($dni) < 8){print_r("Error DNI minimo 8 caracteres"); return;}
                if(!is_numeric($dni)){print_r("Error DNI solo numeros");return;}
            }

            $m_personal = new m_comprobante();
            $m_proveedor = $m_personal->m_guardar_proeveedor($proveedor,$direccion,$ruc,$dni,$usu);
            print_r($m_proveedor);
        }

    }

?>