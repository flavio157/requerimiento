<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/m_materialsalida.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/cod_almacenes.php");
    $accion = $_POST['accion'];
    if($accion == "personal"){
        $dato = $_POST['dato'];
        $user_datos = array(
            'EST_PERSONAL' => 'A',
        );
        $valores = select_where($user_datos);
        c_materialesalida::c_buscarlike('T_PERSONAL','NOM_PERSONAL1',$valores,$accion,$dato);
    }else if($accion == "material"){
        $dato = $_POST['dato'];
        $codalmacen = oficiona($_POST['almacen']);
        $user_datos = array(
            'ALMACEN' => $codalmacen,
            'EST_PRODUCTO' => 'A',
            'COD_CATEGORIA' => '00003',
        );
        $valores = select_where($user_datos);
        c_materialesalida::c_buscarlike('V_BUSCAR_MATERIALES','DES_PRODUCTO',$valores,$accion,$dato);
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
    }   

    
    class c_materialesalida
    {
        static function c_buscarlike($tabla,$campolike,$valores,$tipo,$dato){
                $material = new m_materiasalida();
                $buscar = $material->m_buscarlike($tabla,$campolike,$valores,$dato);
                if($tipo == 'personal')$lista = self::listar($buscar,0,5,0,0,0);
                else $lista = self::listar($buscar,0,1,2,7,5);
                echo $lista; 
        }  
        
        static function listar($buscar,$c1,$c2,$c3,$c4,$c5){
            $html = "";
            foreach($buscar as $c){
                $html.= '<div><a class="suggest-element" datstc="'.$c[$c5].'" datalm="'.$c[$c4].'" datatip="'.$c[$c3].'" dataid="'.$c[$c1].'" data="'.$c[$c2].'">'.$c[$c2].'</a></div>';
            }
            return $html;
        }

        static function c_mat_sin_devolver($cod_personal)
        {
            $material = new m_materiasalida();
            $user_datos = array(
                'CODIGO_PER' => trim($cod_personal) 
            );
            $valores = select_where($user_datos);
            $sindevolver = $material->m_buscar('V_MAT_SIN_DEVOLVER',$valores);
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
                $user_datos = array(
                    'CODIGO_PER' => $codper,
                    'CODIGO' => $codmaterial,
                ); 
                $sindevolver = select_where($user_datos);
                $nodevolvio = $m_material->m_buscar('V_MAT_SIN_DEVOLVER',$sindevolver);
                if($serie == "") {print_r("Ingrese numero de serie"); return;}
                if(count($nodevolvio) > 0 ){
                    print_r("Antes de agregar registre devolución del material");
                    return;
                }
                $veriserie = array(
                    'NUM_SERIE' => $serie
                ); 
                $sindevolver = select_where($veriserie);
                $nroseri = $m_material->m_buscar('T_DETSALIDA',$sindevolver);
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
            $tock = c_materialesalida::c_update_stock($codmaterial,$materiales[0][4],$cant,$codalmacen);
            print_r($tock.'/'.$cant.'/'.$tipo);
        }

        static function c_guardar($codpersonal,$perregistro,$des,$items)
        {
           if(count($items->tds)==0){print_r("Error ingrese material"); return;} 
           $regName = '/^(?!.*([A-Za-z])\1{2})/';
           if(strlen(str_replace(" ", "", $des)) < 30){print_r("Error descripcion invalida"); return;}
           if(preg_match($regName,$des) == 0){print_r("Error descripcion invalida"); return;}
           $desc = str_replace(' ', '', $des);
           if(!ctype_alpha(trim($desc))){print_r("Error descripcion invalida"); return;}
           $material = new m_materiasalida();
           $materiales = $material->m_guardar($codpersonal,$perregistro,$des,$items);
           print_r($materiales);
        }

        static function c_update($codmaterial,$serie,$usumodifico)
        {
            $material = new m_materiasalida();
            $user_datos = array(
                'COD_PRODUCTO_DEV' => $codmaterial,
                'CANTIDAD_DEV' => '1',
                'USU_MODIFICO' => $usumodifico,
                'FEC_MODIFICO' => retunrFechaSqlphp(date("Y-m-d"))
            );
           $valores = update($user_datos);
           $wher = array(
            'NUM_SERIE' => trim($serie),
            );
            $where = select_where($wher);
           $update = $material->m_update('T_DETSALIDA',$valores,$where);
           print_r($update); 
        }

        static function c_update_stock($codmaterial,$stock,$cant,$almacen)
        {
            $stock =  intval($stock)  - intval($cant);
            $material = new m_materiasalida();
            $user_datos = array(
                'STOCK_ACTUAL' => $stock,
            );
            $wher = array(
                'COD_PRODUCTO' => trim($codmaterial),
                'COD_ALMACEN' => trim($almacen),
            );
           $where = select_where($wher);
           $valores = update($user_datos);
           $material->m_update('T_ALMACEN_INSUMOS',$valores,$where);
           return $stock;
           
        }

        static function c_return_stock($codmaterial,$codalmacen,$cant)
        {   $tipo = 1;
            $codalmacen = oficiona($codalmacen);
            $materiales = c_materialesalida::materialAlmacen($codmaterial,$codalmacen);
            $stock =  intval($materiales[0][4])  + intval($cant);
            $material = new m_materiasalida();
            $user_datos = array(
                'STOCK_ACTUAL' => $stock,
            );
            $valores = update($user_datos);
            $wher = array(
                'COD_PRODUCTO' => trim($codmaterial), 
                'COD_ALMACEN' => trim($codalmacen) 
            );
           $where = select_where($wher);
           $material->m_update('T_ALMACEN_INSUMOS',$valores,$where);
           if($materiales[0][1] == '00001') $tipo = 0;
           print_r($stock."/".$tipo);
        }

        static function materialAlmacen($codmaterial,$codalmacen)
        {
            $material = new m_materiasalida();
            $user_datos = array(
                'PRODUCTO' => $codmaterial,
                'ALMACEN' => $codalmacen,
                'ESTADO' => 'A'
            );
            $valores = select_where($user_datos);
            $materiales = $material->m_buscar('V_VERIFICAR_STOCK',$valores);
            return $materiales;
        }

    }
?>