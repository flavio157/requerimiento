<?php
    require_once("../funciones/m_guia_remision.php");
    require_once("../funciones/m_almacen_producto.php");
    $accion = $_POST['accion'];
    if($accion == 'buscar'){
       $cod_personal = $_POST['codpersonal']; 
       $oficina = $_POST['oficina'];
       $tipo = $_POST['tipo'];
       if($tipo == '1'){
        $codebar = $_POST['codebar'];
       }else{
        $codebar = "";
       }
       c_guia_remision::c_verificar_guia($codebar,$oficina,$cod_personal);
    }else if($accion = 'insertItem'){ 
        $oficina = $_POST['oficina'];
        $codebar = $_POST['codebar'];
        $codguia = $_POST['codguia'];
        $cod_personal = $_POST['codpersonal']; 
        if(strlen($codebar) == 11){
            $estado = 1;
            c_guia_remision::c_guardar_item($oficina,$codguia,trim($codebar),$cod_personal,$estado);
        }else{
            print_r("Codigo de barra invalido");
        }
    }
    class c_guia_remision
    {
        static function c_verificar_guia($codebar,$oficina,$cod_personal)
        {
            $datos = array();
            $guia = '';
            $m_guia_remision = new m_guia_remision($oficina);
            $c_guia_remision = $m_guia_remision->m_verificar_guia_remision($cod_personal);
            if(count($c_guia_remision) == 0 && $codebar != ""){
                if(strlen($codebar) == 11){
                    $almacen = new m_almacen_productos();
                    if(substr(trim($codebar), 0, 2) == "CM"){
                        $combo = $almacen->m_buscarcombo_producto(trim($codebar));
                         for ($i=0; $i < sizeof($combo) ; $i++) { 
                            if($combo[$i][6] != 'O'){
                               c_guia_remision::c_guardar_observacion_Proc($cod_personal,trim($oficina),$combo[$i][2]);       
                            }
                            $c_guia_remision = $m_guia_remision->m_verificar_guia_remision($cod_personal);
                            if(count($c_guia_remision) == 0){
                                $guia = c_guia_remision::c_crear_guia($combo[$i][5],$cod_personal,$oficina,$combo[$i][3]);
                            }else{
                                $estado = 0;
                                c_guia_remision::c_guardar_item($oficina,$guia,$combo[$i][2],$cod_personal,$estado);
                            }//poner variable mensaje
                        }
                        $datos = array(
                            '1' => $guia,
                            'msj' => "producto registrado"
                        );
                    }else{
                        $producto = $almacen->m_buscar_Almacen(trim($codebar),$oficina);
                        if(sizeof($producto) > 0){
                            if($producto[0][10] != 'O'){
                                c_guia_remision::c_guardar_observacion_Proc($cod_personal,trim($oficina),$codebar);
                            }
                            $guia = c_guia_remision::c_crear_guia($codebar,$cod_personal,$oficina,$producto[0][1]);
                            $datos = array(
                                '1' => $guia,
                                'msj' => "producto registrado"
                            );
                        }else{
                            $datos = array(
                                '1' => $guia,
                                'msj' => "PRODUCTO NO ENCONTRADO"
                            );
                        }
                    }
               }else{
                    print_r("Codigo de barra invalido");
                }
            }else if(count($c_guia_remision) != 0){
                $datos = array(
                 '1' => $c_guia_remision[0]['COD_GUIA']
                );
            }
            echo json_encode($datos,JSON_FORCE_OBJECT);
        }


      
        

        static function c_crear_guia($codebar,$cod_personal,$oficina,$producto){
            $m_guia_remision = new m_guia_remision($oficina);
            $c_guia_remision = $m_guia_remision->m_crear_guia_remision($codebar,$cod_personal,$oficina,$producto);
            return $c_guia_remision;
        }

        static function c_guardar_item($oficina,$cod_guia,$num_lote,$cod_personal,$estado){
            $datos = '';
            $m_guardar_item = new m_guia_remision($oficina);
            if(substr(trim($num_lote), 0, 2) == "CM"){
                $almacen = new m_almacen_productos();
                $combo = $almacen->m_buscarcombo_producto(trim($num_lote));
                for ($i=0; $i < sizeof($combo) ; $i++) { 
                    if($combo[$i][6] != 'O'){
                        c_guia_remision::c_guardar_observacion_Proc($cod_personal,trim($oficina),$combo[$i][2]);       
                    }
                    if(count($m_guardar_item->m_verificar_item_guia($combo[$i][2]))){
                        if($estado != 0){
                            $datos = array(
                                'msj' => "producto ya registrado"
                            );
                            echo json_encode($datos,JSON_FORCE_OBJECT);
                        }
                        return;
                    }
                    $c_guardar_item = $m_guardar_item->m_crear_item_guia($cod_guia,$combo[$i][2],$combo[$i][3],$cod_personal,$oficina);
                }
                if($estado != 0){
                    $datos = array(
                        '1' => $cod_guia,
                        'msj' => "producto registrado"
                    );
                }
                
              
            }else{
                if(count($m_guardar_item->m_verificar_item_guia($num_lote))){
                    $datos = array(
                        'msj' => "producto ya registrado"
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
                    return;
                }else{
                    $almacen = new m_almacen_productos();
                    $producto = $almacen->m_buscar_Almacen($num_lote,$oficina);
                    //print_r($producto);
                    $cod_producto = "" ;
                    if(count($producto)){ 
                        if($producto[0][10] != 'O') c_guia_remision::c_guardar_observacion_Proc($cod_personal,$oficina,$num_lote);
                        $cod_producto = $producto[0][1];
                    }
                    else {
                        $datos = array(
                            'msj' => "producto no encontrado"
                        );
                        echo json_encode($datos,JSON_FORCE_OBJECT);
                       return;
                    }
                $c_guardar_item = $m_guardar_item->m_crear_item_guia($cod_guia,$num_lote,$cod_producto,$cod_personal,$oficina);
                    $datos = array(
                        'msj' => "producto registrado"
                    );
                }
            }
          
            if($estado != 0){
              echo json_encode($datos,JSON_FORCE_OBJECT);
            }
        }


        static function c_guardar_observacion_Proc($cod_personal,$oficina,$codebar){
            $almacen = new m_guia_remision($oficina);
            $oficina = trim($oficina);
            $observacion = $almacen->m_guardar_observacion_Proc($cod_personal,$oficina,$codebar);
            //print_r($observacion);
        } 
    }
?>