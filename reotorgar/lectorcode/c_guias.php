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
        c_guia_remision::c_guardar_item($oficina,$codguia,$codebar);
    }
    class c_guia_remision
    {
        static function c_verificar_guia($codebar,$oficina,$cod_personal)
        {
            $m_guia_remision = new m_guia_remision($oficina);
            $c_guia_remision = $m_guia_remision->m_verificar_guia_remision($cod_personal);

            if(count($c_guia_remision) == 0 && $codebar != ""){
               $almacen = new m_almacen_productos();
               $producto = $almacen->m_buscar_Almacen($codebar);
               $guia = c_guia_remision::c_crear_guia($codebar,$cod_personal,$oficina,$producto[0][3]);
               $datos = array(
                '0' => $guia[0],
                '1' => $guia[1]
                );
               echo json_encode($datos,JSON_FORCE_OBJECT);
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

        static function c_guardar_item($oficina,$cod_guia,$num_lote){
            $m_guardar_item = new m_guia_remision($oficina);
            if(count($m_guardar_item->m_verificar_item_guia($num_lote))){
                print_r("El producto ya fue agregado");
                return;
            }else{
                $almacen = new m_almacen_productos();
                $producto = $almacen->m_buscar_Almacen($num_lote);
                $cod_producto = "" ;
                if(count($producto)){ 
                    $cod_producto = $producto[0][3];
                }
                else {
                    print_r("producto no existe"); return;
                }
            $c_guardar_item = $m_guardar_item->m_crear_item_guia($cod_guia,$num_lote,$cod_producto); 
            print_r($c_guardar_item);
            }
        }


        static function c_guardar_observacion_Proc($cod_personal,$oficina,$fecha){
            $almacen = new m_almacen_productos();
            $observacion = $almacen->m_guardar_observacion_Proc();
            print_r($observacion);

        }

        
    }
?>