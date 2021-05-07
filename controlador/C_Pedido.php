<?php
    require_once("../modelo/M_Pedido.php");
    session_start();
   

    $accion = $_POST["accion"];
    $tipo_documento = $_POST["slcdocumento"];
    $identificacion = $_POST["txtnumero"];

    if($accion == "guardar"){
        $cod_cliente = '0001';
        $cliente = $_POST["txtcliente"];
        $direccion = $_POST["txtdireccion"];
        $referencia = $_POST["txtreferencia"];
        $contacto = $_POST["txtcontacto"] ;
        $condicion = $_POST["slccondicion"];
        $telefono = $_POST["txttelefono"];
        $entrega = $_POST["slcentrega"];
        $fcancelacion =  $_POST["dtfechapago"];
        $est_pedido = "P";
        $cod_distrito = $_POST["slcdistrito"];
        $num_contrato = $_POST["txtcontrato"]; 
        $cod_provincia=$_POST["slcciudad"];  
        $telefono2=$_POST["txtTelefono2"];  
        
        $dataproductos = json_decode($_POST['array']);

       
        guardarPedidos::guardarpedido(trim($cod_cliente),
        trim($tipo_documento),trim($identificacion),trim($cliente),trim($direccion),trim($referencia),
        trim($contacto),trim($telefono),trim($entrega),trim($fcancelacion) ,trim($est_pedido),
        trim($cod_distrito),trim($num_contrato),
        trim($cod_provincia),trim($telefono2),$dataproductos);

    }


    class guardarPedidos
    { 
        static function guardarpedido($cod_cliente,$tipo_documento,
        $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
        $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
        $cod_provincia,$telefono2,$dataproductos){
            
            $observacion = "";
            $producto = 0;
            $promocion = 0;
            $bd = 'SMP2';
            $c_guardar = new M_Pedidos($bd);
            $verificar = $c_guardar->verificar($identificacion);
     
            if($verificar == ""){
                foreach ($dataproductos->arrayproductos as $dato){
                    if(isset($dato->cod_producto)){
                        $observacion.= $dato->nombre."/ ";
                        $producto += intval($dato->cantidad);
                        $promocion += intval($dato->promocion);
                      }  
                }  
    
                $total = $producto + $promocion;
    
                $c_pedido = $c_guardar->guardarpedido(date("d-m-Y"),$cod_cliente,$_SESSION['cod_personal'],$tipo_documento,
                $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,
                $est_pedido,$observacion,$total,'01',$num_contrato,'01',$telefono2,$dataproductos);
                
                if($c_pedido){
                    $buscarProducto = array(
                        'estado' => 'echo',
                        'mensaje' => 'Se registro el Pedido'
                    );
                }
                
            }else{
                $buscarProducto = array(
                    'estado' => 'error',
                    'mensaje' => 'Existe un pedido pendiente con la misma Identificación '
                );
                
            }

            echo json_encode($buscarProducto,JSON_FORCE_OBJECT);
        }      
    }
    



?>