<?php
date_default_timezone_set('America/Lima');
require_once("m_materialsalida.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/cod_almacenes.php");
    $accion = $_POST['accion'];
    if($accion == "personal"){
        c_materialesalida::c_filtarpersonal();
    }else if($accion == "material"){
        $codalmacen = oficiona($_POST['almacen']);
        c_materialesalida::c_filtarproducto($codalmacen);
    }else if($accion == "sindevolver"){
        $cod_pers = $_POST['dato'];
        c_materialesalida::c_mat_sin_devolver($cod_pers);
    }else if($accion == 'guardar'){
        $codpersonal = $_POST['codigo'];
        if($codpersonal == ''){ print_r("Ingrese personal"); return;}
        $perregistro = $_POST['perregistro'];
        $des = $_POST['descr'];
        $items =json_decode($_POST['items']);
        c_materialesalida::c_guardar($codpersonal,$perregistro,$des,$items);
    }else if($accion == 'update'){
        $usumodifico = $_POST['usumodifico'];
        $codmaterial = $_POST['codigo'];
        $serie = $_POST['serie'];
        c_materialesalida::c_update($codmaterial,$serie,$usumodifico);
    }else if($accion == 'stock'){
        $codper  = $_POST['codper'];
        if($codper == ''){print_r("Ingrese personal"); return;}
        $codmaterial = $_POST['cdmaterial'];
        if($codmaterial == ''){print_r("Ingrese un producto valido"); return;}
        $almacen = $_POST['almacen']; 
        $cantidad = $_POST['cantidad'];
        $serie = $_POST['serie'];  
        $material = $_POST['material'];  
        c_materialesalida::c_verificarstock($codmaterial,$almacen,$cantidad,$serie,$material,$codper);
    }else if($accion == "destock"){
        $codmaterial = $_POST['cdmaterial'];
        $almacen = $_POST['almacen']; 
        $cantidad = $_POST['cantidad'];
        c_materialesalida::c_return_stock($codmaterial,$almacen,$cantidad);
    }else if($accion == "consstock"){
        $codpro = $_POST['dato'];
        c_materialesalida::c_consulstock($codpro);
    }

    
    class c_materialesalida
    {
        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_materiasalida();
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

        static function c_filtarproducto($codalmacen)
        {
            //ALMACEN = '$codalmacen' AND 
            $material = array();
            $m_personal = new m_materiasalida();
            $cadena = "ALMACEN = '$codalmacen' AND EST_PRODUCTO = 'A' ";
            $c_material = $m_personal->m_buscar('V_BUSCAR_MATERIALES',$cadena);
            for ($i=0; $i < count($c_material) ; $i++) { 
                array_push($material,array(
                    "code" => $c_material[$i][0],
                    "label" => $c_material[$i][1],
                    "clase" => $c_material[$i][2],
                    "stock" => $c_material[$i][5],
                    "alma" => $c_material[$i][7]));
            }
            $dato = array(
                'dato' => $material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        } 
        

        static function c_mat_sin_devolver($cod_personal)
        {
            $material = new m_materiasalida();
            $cod_personal = trim($cod_personal);
            $cadena = " CODIGO_PER = '$cod_personal'";
            $sindevolver = $material->m_buscar('V_MAT_SIN_DEVOLVER',$cadena);
            $dato = array(
                 'dato' => $sindevolver,   
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_verificarstock($codmaterial,$codalmacen,$cantidad,$serie,$material,$codper)
        {  
            $tipo = "";
            $m_material = new m_materiasalida();
            if($codmaterial == "" || $material == "") {print_r("Ingrese material"); return;}
            $codalmacen = oficiona($codalmacen);
            $materiales = c_materialesalida::materialAlmacen($codmaterial,$codalmacen);
            if($materiales[0][4] == "0.00"){print_r("Noy hay Stock"); return;}
            if($materiales[0]['1'] == '00001'){
                $tipo = 1;
                $cadena = " CODIGO_PER = '$codper' AND CODIGO = '$codmaterial'";
                $nodevolvio = $m_material->m_buscar('V_MAT_SIN_DEVOLVER',$cadena);
                if($serie == "") {print_r("Ingrese numero de serie"); return;}
                if(count($nodevolvio) > 0 ){
                    print_r("Antes de agregar registre devolución del material");
                    return;
                }
                $cadena = " NUM_SERIE = '$serie'";
                $nroseri = $m_material->m_buscar('T_DETSALIDA',$cadena);
                if(count($nroseri) > 0){
                    print_r("Numero de serie ya registrado");
                    return;
                }
                $cant = 1;
            }else{
                $tipo = 2;
                if($cantidad == "" || $cantidad <= 0 || !is_numeric($cantidad)){
                    print_r("ingrese cantidad del material");
                    return;
                }
                $cant = $cantidad;
            }
            if($materiales[0][4] < $cant){print_r("Stock insuficiente");return;}
            $stock = c_materialesalida::c_update_stock($codmaterial,$materiales[0][4],$cant,$codalmacen);
            print_r($materiales[0][4].'/'.$cant.'/'.$tipo.'/'.$stock);
        }

        static function c_guardar($codpersonal,$perregistro,$des,$items)
        {
           if(count($items->tds)==0){print_r("Error ingrese material"); return;} 
           if(strlen(str_replace(" ", "", $des)) < 10){print_r("Descripcion debe tener 10 caracteres"); return;}
           $pattern = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
           if(preg_match($pattern,$des) == 0){print_r("Error descripcion invalida solo letras"); return;}
           if(strlen($des) > 500){print_r("Error sobrepaso el limite de caracteres"); return;}
           $material = new m_materiasalida();
           $materiales = $material->m_guardar($codpersonal,$perregistro,$des,$items);
           print_r($materiales);
        }

        static function c_update($codmaterial,$serie,$usumodifico)
        {
            $material = new m_materiasalida();
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $serie = trim($serie);

            $cadena = "SET COD_PRODUCTO_DEV = '$codmaterial' ,CANTIDAD_DEV = '1', USU_MODIFICO = '$usumodifico',
            FEC_MODIFICO = '$fecha' WHERE NUM_SERIE = '$serie'";
           $update = $material->m_update_stock('T_DETSALIDA',$cadena);
           print_r($update); 
        }

        static function c_update_stock($codmaterial,$stock,$cant,$almacen)
        {
            //AND COD_ALMACEN = '$almacen'
            $stock =  intval($stock)  - intval($cant);
            $material = new m_materiasalida();
            $codmaterial = trim($codmaterial);
            $almacen = trim($almacen);
           $cadena = "SET STOCK_ACTUAL = '$stock' WHERE COD_PRODUCTO = '$codmaterial' AND COD_ALMACEN = '$almacen'";
           $material->m_update_stock('T_ALMACEN_INSUMOS',$cadena);
           return $stock;
           
        }

        static function c_return_stock($codmaterial,$codalmacen,$cant)
        {    
            //AND COD_ALMACEN = '$almacen'
            $tipo = 1;
            $codalmacen = oficiona($codalmacen);
            $materiales = c_materialesalida::materialAlmacen($codmaterial,$codalmacen);
            $stock =  intval($materiales[0][4])  + intval($cant);
            $material = new m_materiasalida();
            $almacen = trim($codalmacen);
           $cadena = "SET STOCK_ACTUAL = '$stock'  WHERE COD_PRODUCTO ='$codmaterial' AND COD_ALMACEN = '$almacen'";
           $material->m_update_stock('T_ALMACEN_INSUMOS',$cadena);
           if($materiales[0][1] == '00001') $tipo = 0;
           print_r($stock."/".$tipo);
        }

        static function materialAlmacen($codmaterial,$codalmacen)
        {
            //AND  ALMACEN = '$codalmacen'
            $material = new m_materiasalida();
            $cadena = " PRODUCTO = '$codmaterial' AND  ESTADO = 'A' AND  ALMACEN = '$codalmacen'";
            $materiales = $material->m_buscar('V_VERIFICAR_STOCK',$cadena);
            return $materiales;
        }

        static function c_consulstock($codprod){
            $m_personal = new m_materiasalida();
            $cadena = "PRODUCTO = '$codprod'";
            $c_stockcod = $m_personal->m_buscar('V_VERIFICAR_STOCK',$cadena);
            print_r($c_stockcod[0][4]);
            
        }
    }
?>