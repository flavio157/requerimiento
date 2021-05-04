<?php
    require_once("../modelo/M_Pedido.php");
   

    /*$accion = $_POST["accion"];
    $codigo = "5";
    $cod_cliente = "0001" ;
    $cod_vendedora ='0002';
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
    $est_pedido = "A";
    $freparto = "19/04/2020";
    $cod_reparto = "0002";
    $cod_distrito = $_POST["slcdistrito"];
    $num_contrato = $_POST["txtcontrato"]; 
    $cod_provincia=$_POST["slcciudad"];  
    $fec_despacho= "19/04/2020";


    $cod_producto = $_POST["cod_producto"];
    $can_productos = $_POST["cantidad"];
    $promocion = $_POST["promocion"];
    $total = $_POST["total"];*/


    $data = json_decode($_POST['array']);
    print_r($data);
  
    foreach ($data->arrayproductos as $k){
        if(isset($k->cod_producto)){
           echo "\t".$k->cod_producto." - ".$k->nombre.PHP_EOL;
         }         
    }

   


    if($accion = "guardar"){





       /* $date = date_create($fcancelacion);
        $fechaNueva = date_format($date,"d/m/Y H:i:s");
        $c_guardarpedido = new guardarpedidos();
        $c_guardarpedido->guardarpedido(trim($codigo),trim($cod_cliente),trim($cod_vendedora),
        trim($tipo_documento),trim($identificacion),trim($cliente),trim($direccion),trim($referencia),
        trim($contacto),trim($telefono),trim($entrega),trim($fechaNueva),trim($est_pedido),
        trim($freparto),trim($cod_reparto),trim($cod_distrito),trim($num_contrato),
        trim($cod_provincia),trim($fec_despacho),trim($cod_producto),trim($can_productos)
        ,trim($promocion),trim($total));*/

    }


    class guardarPedidos
    { 
        public function guardarpedido($codigo,$cod_cliente,$cod_vendedora,$tipo_documento,
        $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
        $fcancelacion,$est_pedido,$freparto,$cod_reparto,$cod_distrito,$num_contrato,
        $cod_provincia,$fec_despacho,$cod_producto,$can_productos,$promocion,$total)
        {
            $bd = 'SMP2';
           
            $c_guardar = new M_Pedidos($bd);

            $c_pedido = $c_guardar->guardarpedido($codigo,$cod_cliente,$cod_vendedora,$tipo_documento,
            $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,$est_pedido,
            $freparto,$cod_reparto,$cod_distrito,$num_contrato,
            $cod_provincia,$fec_despacho);
    
            if($c_pedido){
               $this->guardarpedidocantidad($codigo,$cod_producto,$can_productos,$promocion,$total,
                                            $can_productos,$promocion,$bd);
            }
        }


        public function guardarpedidocantidad($codigo,$cod_producto,$cantidad,$bono,$precio,$bd){
            $bd = 'SMP2';
            $c_guardar = new M_Pedidos($bd);
            echo $bd;
            $precioTotal =number_format(floatval($precio), 2, '.', ' ');
            $c_pedidocantidad = $c_guardar->guardarpedidocantidad($codigo,$cod_producto,$cantidad,
                                                                  $bono,$precioTotal,$cantidad,$bono);
            if($c_pedidocantidad){
                $buscarProducto = array(
                    'estado' => 'ok'
                );
                echo json_encode($buscarProducto,JSON_FORCE_OBJECT);
            }

        }
    }
    



?>