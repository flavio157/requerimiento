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
            c_guia_remision::c_guardar_item($oficina,$codguia,trim($codebar),$cod_personal);
        }else{
            print_r("Codigo de barra invalido");
        }
    }
    class c_guia_remision
    {
        static function c_verificar_guia($codebar,$oficina,$cod_personal)
        {
            $m_guia_remision = new m_guia_remision($oficina);
            $c_guia_remision = $m_guia_remision->m_verificar_guia_remision($cod_personal);
           
            if(count($c_guia_remision) == 0 && $codebar != ""){
                if(strlen($codebar) == 11){
                    $almacen = new m_almacen_productos();
                    if(substr($codebar, 0, 2) == "CM"){
                        $combo = $almacen->m_buscarcombo_producto($codebar);
                        for ($i=0; $i < sizeof($combo) ; $i++) { 
                            if($combo[$i][6] != 'M'){
                               c_guia_remision::c_guardar_observacion_Proc($cod_personal,trim($oficina),$combo[$i][5]);       
                            }
                            $guia = c_guia_remision::c_crear_guia($combo[$i][5],$cod_personal,$oficina,$combo[$i][3]);
                            //poner variable mensaje
                        }
                    }else{
                        $producto = $almacen->m_buscar_Almacen(trim($codebar),$oficina);
                        if(sizeof($producto) > 0){
                            if($producto[0][10] != 'M'){
                                c_guia_remision::c_guardar_observacion_Proc($cod_personal,trim($oficina),$codebar);
                            }
                            $guia = c_guia_remision::c_crear_guia($codebar,$cod_personal,$oficina,$producto[0][1]);
                            //poner mensaje
                        }else{
                            //print_r("PRODUCTO NO ENCONTRADO"); reemplazar por mensaje
                        }
                    }
               }else{
                    print_r("Codigo de barra invalido");
                }
              
            }else if(count($c_guia_remision) != 0){
                $datos = array(
                 '1' => $c_guia_remision[0]['COD_GUIA']
                );
                echo json_encode($datos,JSON_FORCE_OBJECT);
            }
        }


      
        

        static function c_crear_guia($codebar,$cod_personal,$oficina,$producto){
            $m_guia_remision = new m_guia_remision($oficina);
            $c_guia_remision = $m_guia_remision->m_crear_guia_remision($codebar,$cod_personal,$oficina,$producto);
            return $c_guia_remision;
        }

        static function c_guardar_item($oficina,$cod_guia,$num_lote,$cod_personal){
            $m_guardar_item = new m_guia_remision($oficina);
            if(count($m_guardar_item->m_verificar_item_guia($num_lote))){
                print_r("3");
                return;
            }else{
                $almacen = new m_almacen_productos();
                $producto = $almacen->m_buscar_Almacen($num_lote,$oficina);
                $cod_producto = "" ;
                if(count($producto)){ 
                    if($producto[0][10] != 'M') c_guia_remision::c_guardar_observacion_Proc($cod_personal,$oficina,$num_lote);
                    $cod_producto = $producto[0][3];
                }
                else {
                    print_r(0); return;
                }
            $c_guardar_item = $m_guardar_item->m_crear_item_guia($cod_guia,$num_lote,$cod_producto,$cod_personal,$oficina); 
            print_r($c_guardar_item);
            }
        }


        static function c_guardar_observacion_Proc($cod_personal,$oficina,$codebar){
            $almacen = new m_almacen_productos();
            $oficina = trim($oficina);
           // print_r($cod_personal."".$oficina."".$codebar);
            $observacion = $almacen->m_guardar_observacion_Proc($cod_personal,$oficina,$codebar);
            //print_r($observacion);
        }

        
    }
?>