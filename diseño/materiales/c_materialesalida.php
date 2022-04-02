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
        $perregistro = $_POST['perregistro'];
        $des = $_POST['descr'];
        $items =json_decode($_POST['items']);
        $dxdia =json_decode($_POST['dxdia']);
        c_materialesalida::c_guardar($codpersonal,$perregistro,$des,$items,$dxdia);
    }else if($accion == 'update'){
        $usumodifico = $_POST['usumodifico'];
        $codmaterial = $_POST['codigo'];
        $serie = $_POST['serie'];
        $tipodat = $_POST['tipodato'];
        $codmatxdia = $_POST['codmatxdia'];
        $ofi = $_POST['ofi'];
        $salida = $_POST['salida'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $motivo = $_POST['motivo'];
        $solicito = $_POST['solicito'];
        c_materialesalida::c_devolucion($codmaterial,$serie,$usumodifico,$tipodat,$codmatxdia,
                           $ofi,$salida,$cantidad,$descripcion,$motivo,$solicito);
    }else if($accion == 'stock'){
        $codper  = $_POST['codper'];
        $codmaterial = $_POST['cdmaterial'];
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
    }else if($accion == 'lstmatexdia'){
        c_materialesalida::c_material_x_dia();
    }else if($accion == 'reportar'){
        $personal = $_POST['personal'];
        $producto = $_POST['producto'];
        $cant = $_POST['cant'];
        $descripcion = $_POST['descripcion'];
        $codsalida= $_POST['codsalida'];
        $motivo = $_POST['motivo'];
        $tipo = $_POST['tipo'];
        $usu = $_POST['usu'];
        $codmatxdia = $_POST['codmatxdia'];
        $serie = $_POST['serie'];
        c_materialesalida::c_reportarmaterial($personal,$producto,$cant,$descripcion,$codsalida,$motivo
        ,$codmatxdia,$usu,$tipo,$serie);
    }else if($accion == 'lstperdidos'){
        $codpersonal = $_POST['personal'];
        c_materialesalida::c_lstperdido($codpersonal);
    }else if($accion == 'greingreso'){
        $material = $_POST['material']; 
        $codsalida = $_POST['salida'];
        $cantidad = $_POST['cantidad']; 
        $serie = $_POST['serie'];
        $observacion = $_POST['observacion'];
        $usu = $_POST['usu'];
        $tipo = $_POST['tipo'];
        $serieperd = $_POST['seirper'];
        $almacen = $_POST['oficina'];
        c_materialesalida::c_guarreingreso($material,$codsalida,$cantidad,$serie,$serieperd,$observacion,$tipo,$usu,$almacen);
    }

    
    class c_materialesalida
    {
        static function c_filtarpersonal()
        {
            $personal = array();
            $m_personal = new m_materiasalida();
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

        static function c_filtarproducto($codalmacen)
        {
            //ALMACEN = '$codalmacen' AND 
            $material = array();
            $m_personal = new m_materiasalida();
            $cadena = "EST_PRODUCTO = '1' ";
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
            $cadena = "CODIGO_PER = '$cod_personal' and cantidad != '0'";
            $sindevolver = $material->m_buscar('V_MAT_SIN_DEVOLVER',$cadena);
            $cadena1 = "personal = '$cod_personal' and cantidad != 0";
            $dxdia =  $material->m_buscar('V_MATERIALES_X_DIA',$cadena1);

            $dato = array(
                 'dato' => $sindevolver,   
                 'dxd' => $dxdia
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_verificarstock($codmaterial,$codalmacen,$cantidad,$serie,$material,$codper)
        {  
            $tipo = "";
            $m_material = new m_materiasalida();

            /* sujeto a cambios */
            $c_material_x_devolver = $m_material->m_material_x_dia();
            if(count($c_material_x_devolver) > 0){print_r("3"); return;}
            /*---*/
            if($codper == ''){print_r("Ingrese personal"); return;}
            if($codmaterial == ''){print_r("Ingrese un producto valido"); return;}
            if($codmaterial == "" || $material == "") {print_r("Ingrese material"); return;}

            $codalmacen = oficiona($codalmacen);
            $materiales = c_materialesalida::materialAlmacen($codmaterial,$codalmacen);
            if($materiales[0][4] == "0.00"){print_r("Noy hay Stock"); return;}
            if($materiales[0]['1'] == '00001' || $materiales[0]['1'] == '00004'){
                $tipo = 1;
                $cadena = " CODIGO_PER = '$codper' AND CODIGO = '$codmaterial'";
               // $nodevolvio = $m_material->m_buscar('V_MAT_SIN_DEVOLVER',$cadena);
                
                if($serie == "") {print_r("Ingrese numero de serie"); return;}
              
                if(strlen($serie) > 20){print_r("Error nro de serie solo 20 caracteres");return;}

                if(strlen($serie) < 6){print_r("Error nro de serie nimimo 6 caracteres");return;}
                if(count(count_chars($serie, 1)) < 4){print_r("Error numero de serie invalido");return;}
                $conse = c_materialesalida::validarserieprod($serie);
                if($conse == 1){print_r("Error numero de serie invalido");return;}
                /*if(count($nodevolvio) > 0 ){
                    print_r("Antes de agregar registre devolución del material");
                    return;
                }*/
                if($materiales[0]['1'] != '00004'){
                    $serie = str_replace(" ","",str_replace("-","",$serie));
                    $cadena = "REPLACE(REPLACE(NUM_SERIE,' ',''), '-', '') = '$serie'";
                    $nroseri = $m_material->m_buscar('T_DETSALIDA',$cadena);
                    if(count($nroseri) > 0){
                        print_r("Numero de serie ya registrado");
                        return;
                    }
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

        static function validarserieprod($nroseriepro){
            $array = ['123456789','123456','1234567','12345678','987654321','abcd','abcdef',];
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

        static function c_guardar($codpersonal,$persregistro,$des,$items,$dxdia)
        {
           $material = new m_materiasalida();
           /* sujeto a cambios */
           $c_material = $material->m_material_x_dia();
           if(count($c_material) > 0){print_r("3"); return;}
           /* */
           if($codpersonal == ''){ print_r("Ingrese personal"); return;}
           if(count($items->tds)==0 && count($dxdia->dxd)==0){print_r("Error ingrese material"); return;}
           if(strlen(str_replace(" ", "", $des)) < 10){print_r("Error descripcion invalida"); return;}
           if(strlen($des) > 500){print_r("Error campo descripcion sobrepaso el limite de caracteres"); return;}
           if(count(explode( ' ',trim($des))) < 2){print_r("Campo descripcion debe tener almenos 2 palabras"); return;}
           if(count($items->tds) > 0){
            $materiales = $material->m_guardar($codpersonal,$persregistro,$des,$items);
            }  

            if(count($dxdia->dxd) > 0){
                $materiales = $material->m_guarda_mater_x_dia($dxdia,$codpersonal,$persregistro);
            }
           print_r($materiales);
        }


        static function c_update_stock($codmaterial,$stock,$cant,$almacen)
        {
            //AND COD_ALMACEN = '$almacen'
            $stock =  intval($stock)  - intval($cant);
            $material = new m_materiasalida();
            $codmaterial = trim($codmaterial);
            $almacen = trim($almacen);
           $cadena = "SET STOCK_ACTUAL = '$stock' WHERE COD_PRODUCTO = '$codmaterial'";
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
           $cadena = "SET STOCK_ACTUAL = '$stock'  WHERE COD_PRODUCTO ='$codmaterial'";
           $material->m_update_stock('T_ALMACEN_INSUMOS',$cadena);
           if($materiales[0][1] == '00001') $tipo = 0;
           print_r($stock."/".$tipo);
        }

        static function materialAlmacen($codmaterial,$codalmacen)
        {
            //AND  ALMACEN = '$codalmacen'
            $material = new m_materiasalida();
            $cadena = " PRODUCTO = '$codmaterial' AND  ESTADO = '1' ";
            $materiales = $material->m_buscar('V_VERIFICAR_STOCK',$cadena);
            return $materiales;
        }

        static function c_consulstock($codprod){
            $m_personal = new m_materiasalida();
            $cadena = "PRODUCTO = '$codprod'";
            $c_stockcod = $m_personal->m_buscar('V_VERIFICAR_STOCK',$cadena);
            print_r($c_stockcod[0][4]);
            
        }

        /*funciones sujeta a cambios*/
        static function c_material_x_dia(){
            $material = new m_materiasalida();
            $materiales = $material->m_material_x_dia();
            $dato = array(
                'dato' => $materiales
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
            //return $materiales;
        }



        static function c_devolucion($codmaterial,$serie,$usumodifico,$tipodato,$codmatxdia,$ofi,
                        $salida,$cantidad,$descripcion,$motivo,$solicito)
        {
            $devo = ''; 
            if($motivo == 'R' && $tipodato != '00004' && $tipodato != '00005'){
                print_r("Error no se pueden reotorgar este material");return;
            }
            
            if($motivo != 'D'){
            if(count(explode( ' ',trim($descripcion))) < 2){print_r("Campo descripcion debe tener almenos 2 palabras"); return;}
            if(strlen($descripcion) > 500){print_r("Error campo descripcion sobrepaso el limite de caracteres"); return;}
           }
           $material = new m_materiasalida();
           if($cantidad == '0'){print_r("Error cantidad no puede ser igual a 0"); return;}
           
           if($tipodato == '00004' || $tipodato == '00005'){
                $resultado = $material->actualidetallesalida($salida,$codmatxdia,$usumodifico,$serie,$cantidad);
                if($resultado){$devo = $material->m_devol_x_dia($cantidad,$usumodifico,$codmaterial,$codmatxdia,$ofi,$motivo);}
                if($motivo != 'R'){print_r($devo); return;}
                if($motivo == 'R' && $devo){
                   $retu = $material->m_reotorgar($solicito,$usumodifico,$descripcion,$codmatxdia,$cantidad,$serie);
                   if($retu){print_r(2); return;}else{print_r($retu); return;}
                }else{
                    print_r($devo); return;
                }
           }else{
                $resultado = $material->actualidetallesalida($salida,$codmaterial,$usumodifico,$serie,$cantidad);
                print_r($resultado);
           }
        }
    
    
        static function c_reportarmaterial($personal,$producto,$cant,$descripcion,$codsalida,$motivo,
                        $codmatxdia,$usu,$tipo,$serie){
            if($cant == '0'){print_r("Error cantidad no puede ser igual a 0 ");return;}
            if(count(explode( ' ',trim($descripcion))) < 2){print_r("Campo descripcion debe tener almenos 2 palabras"); return;}
            if(strlen($descripcion) > 500){print_r("Error campo descripcion sobrepaso el limite de caracteres"); return;}
            
            $material = new m_materiasalida();
            if($tipo == '00004' || $tipo == '00005'){
                $reporte = $material->m_materialreporte($personal,$codmatxdia,$cant,$descripcion,$codsalida,$motivo,$usu,$serie);
                print_r($reporte);    
            }else{
                $reporte = $material->m_materialreporte($personal,$producto,$cant,$descripcion,$codsalida,$motivo,$usu,$serie);
                print_r($reporte);  
            } 
        }  


        static function c_lstperdido($codpersonal)
        {
            $material = new m_materiasalida(); 
            $c_listamaterila = $material->m_lstmaterial($codpersonal);
            $a = array(
                'r' => $c_listamaterila
            );
            echo json_encode($a,JSON_FORCE_OBJECT);
        }

        static function c_guarreingreso($material,$codsalida,$cantidad,$serie,$serieperd,$observacion,$tipo,$usu,
        $almacen)
        {
           
            $patron = "/^[0-9\.]+$/";
            if(strlen($cantidad) == 0){print_r("Error cantidad minimo 1 digito"); return;}           
            if(preg_match($patron,$cantidad) == 0){print_r("Error cantidad solo numeros"); return;}
            if(!is_numeric($cantidad)){print_r("Error cantidad solo numeros");return;}
            $cantida = explode(".", $cantidad);
            if($cantida[0] == '0'){print_r("Error cantidad no puede ser igual a 0"); return;}  
            if(strlen($cantida[0]) > 9){print_r("Error campo cantidad, maximo 6 digitos con 3 decimales");return;}
           
            if($tipo == '00001'  || $tipo == '00004'){
                if(strlen($serie) == 0){print_r("Campo serie es obligatorio");return;}
                if(strlen($serie) > 20){print_r("Error nro de serie solo 20 caracteres");return;}
                if(strlen($serie) < 6){print_r("Error nro de serie nimimo 6 caracteres");return;}
                if(count(count_chars($serie, 1)) < 4){print_r("Error numero de serie del producto invalido");return;}
            }

            if(strlen($observacion) == 0){print_r("Error campo observación no puede estar vacio"); return;}
            if(strlen($observacion) > 200){print_r("Error campo observación sobrepaso limite de 200 caracteres"); return;}

            $m_material = new m_materiasalida();
            $c_material = $m_material->m_guardarreingreso($material,$codsalida,$cantidad,strtoupper($serie),$serieperd,$observacion,$tipo,$usu,
                          $almacen);
            print_r($c_material);
        }
    }
?>