<?php
    require_once("M_Pedido.php");
    require_once("../funciones/f_funcion.php");

   

    $accion = $_POST["accion"];
      

    if($accion == "guardar"){
        $oficina = $_POST['oficina'];
        $codPersonal = $_POST['codPersonal'];
        $tipo_documento = $_POST["slcdocumento"];
        $identificacion = $_POST["txtnumero"]; 
        $cliente = strtoupper($_POST["txtcliente"]);
        $direccion = strtoupper($_POST["txtdireccion"]);
        $referencia =  strtoupper($_POST["txtreferencia"]);
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

        guardarPedidos::validacion(trim($oficina),trim($tipo_documento),trim($codPersonal),
        trim($identificacion),trim($cliente),trim($direccion),trim($referencia),
        trim($contacto),trim($telefono),trim($entrega),trim($fcancelacion) ,trim($est_pedido),
        trim($cod_distrito),trim($num_contrato),
        trim($provincia),trim($telefono2),trim($condicion),$dataproductos);

    }


    class guardarPedidos
    { 

        static function validacion($oficina,$tipo_documento,$codPersonal,
            $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
            $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
            $cod_provincia,$telefono2,$condicion,$dataproductos){

             $contrato = preg_match("/^[a-zA-Z0-9]+$/", $num_contrato);
             if($contrato != 0){
                    guardarPedidos::guardarpedido($oficina,$tipo_documento,$codPersonal,
                    $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
                    $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
                    $cod_provincia,$telefono2,$condicion,$dataproductos);
             }else{
                $buscarProducto = array(
                    'estado' => 'error',
                    'mensaje' => 'Error al registrar el pedido'
                ); 
                echo json_encode($buscarProducto,JSON_FORCE_OBJECT);
             }
            
        }
        
        static function guardarpedido($oficina,$tipo_documento,$codPersonal,
        $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
        $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
        $cod_provincia,$telefono2,$condicion,$dataproductos){
            
            $c_guardar = new M_Pedidos($oficina);
            $verificar = $c_guardar->verificar($identificacion);
     
            if($verificar == ""){
                $observacion = observacionProducto($dataproductos);
                $total = TotalProducto($dataproductos);
    
                $c_pedido = $c_guardar->guardarpedido($codPersonal,$tipo_documento,
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
    }

?>