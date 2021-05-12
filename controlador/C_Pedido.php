<?php
    require_once("../modelo/M_Pedido.php");
    require_once("../controlador/C_Funciones.php");
    session_start();
   

    $accion = $_POST["accion"];
      

    if($accion == "guardar"){
        $tipo_documento = $_POST["slcdocumento"];
        $identificacion = $_POST["txtnumero"]; 
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
        $condicion = $_POST["slccondicion"]; 
        
        $dataproductos = json_decode($_POST['array']);
        $provincia = $_POST["slcciudad"];
       
        guardarPedidos::guardarpedido(trim($tipo_documento),
        trim($identificacion),trim($cliente),trim($direccion),trim($referencia),
        trim($contacto),trim($telefono),trim($entrega),trim($fcancelacion) ,trim($est_pedido),
        trim($cod_distrito),trim($num_contrato),
        trim($provincia),trim($telefono2),trim($condicion),$dataproductos);

    }else if($accion == "mostrarPedidos"){
        guardarPedidos::mostrarPedido($_SESSION['cod_personal']);
    }else if($accion == "pedidoItem"){
        $idpedido =$_POST['idpedido'];
        guardarPedidos::mostrarPedidoItem($idpedido);
    }


    class guardarPedidos
    { 
        static function guardarpedido($tipo_documento,
        $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
        $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
        $cod_provincia,$telefono2,$condicion,$dataproductos){
            
            $bd = 'SMP2';
            $c_guardar = new M_Pedidos($bd);
            $verificar = $c_guardar->verificar($identificacion);
     
            if($verificar == ""){
                $observacion = observacionProducto($dataproductos);
                $total = TotalProducto($dataproductos);
    
                $c_pedido = $c_guardar->guardarpedido(date("d-m-Y"),$_SESSION['cod_personal'],$tipo_documento,
                $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,
                $est_pedido,$observacion,$total,$cod_distrito,$num_contrato,$cod_provincia,$telefono2,$condicion,$dataproductos);
             
                if($c_pedido){
                    $buscarProducto = array(
                        'estado' => 'echo',
                        'mensaje' => 'Se registro el Pedido'
                    );
                }else{
                    $buscarProducto = array(
                        'estado' => 'error',
                        'mensaje' => 'Error al registrar el pedido'
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
        
       



        static function mostrarPedido($cod_vendedor){
            $bd = 'SMP2';
            $c_mostrarpedido = new M_Pedidos($bd);
            $datos = $c_mostrarpedido->mostrarPedido($cod_vendedor,date("d-m-Y"));
            print_r($datos) ;
        }

        static function mostrarPedidoItem($idPedido){
            $bd = 'SMP2';
            $c_mostrarpedido = new M_Pedidos($bd);
            $datos = $c_mostrarpedido->mostrarPedidoItems($idPedido);
            print_r($datos) ;
        }

    }

?>