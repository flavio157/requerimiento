<?php
require_once("M_Pedido.php");
require_once("../funciones/f_funcion.php");


$accion = $_POST["accion"];
      

if($accion == "guardar"){
    $codcliente = $_POST['codcliente'];
    $oficina = $_POST['oficina'];
    $codPersonal = $_POST['codPersonal'];
    $tipo_documento = $_POST["slcdocumento"];
    $identificacion = $_POST["txtnumero"]; 
    $cliente = strtoupper($_POST["txtcliente"]);
    $direccion = strtoupper($_POST["txtdireccion"]);
    $referencia =  strtoupper($_POST["txtreferencia"]);
    $contacto =  strtoupper($_POST["txtcontacto"]);
    $condicion = $_POST["slccondicion"];
    $telefono = $_POST["txttelefono"];
    $entrega = $_POST["slcentrega"];
    $fcancelacion =  $_POST["dtfechapago"];
    $est_pedido = "P";
    if(isset($_POST["slcdistrito"])){
        $cod_distrito = $_POST["slcdistrito"];
    }else{
        $cod_distrito = isset($_POST["slcdistrito"]);
    }
    $num_contrato = $_POST["txtcontrato"]; 
   // $cod_provincia=$_POST["slcciudad"];  
    $telefono2=$_POST["txtTelefono2"]; 
    $condicion = $_POST["slccondicion"]; 
    
    $dataproductos = json_decode($_POST['array']);
    
    if(isset($_POST["slcciudad"])){
        $provincia = $_POST["slcciudad"];
    }else{
        $provincia = isset($_POST["slcciudad"]);
    }


    guardarPedidos::validacion(trim($codcliente),trim($oficina),trim($tipo_documento),trim($codPersonal),
    trim($identificacion),trim($cliente),trim($direccion),trim($referencia),
    trim($contacto),trim($telefono),trim($entrega),trim($fcancelacion) ,trim($est_pedido),
    trim($cod_distrito),trim($num_contrato),
    trim($provincia),trim($telefono2),trim($condicion),$dataproductos);

}


class guardarPedidos
{ 

    static function validacion($codcliente,$oficina,$tipo_documento,$codPersonal,
        $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
        $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
        $cod_provincia,$telefono2,$condicion,$dataproductos){
            $mensaje = '';
            $contrato = preg_match("/^[a-zA-Z0-9]+$/", $num_contrato);
            if(strlen($tipo_documento) == 0){
                $mensaje = "Error seleccione tipo de documento";
            }else if(strlen($identificacion) == 0){
                $mensaje = "Error ingrese identificacion";
            }else if(strlen($cliente) == 0){
                $mensaje = "Error ingrese nombre cliente";
            }else if(strlen($cod_provincia) == 0){
                $mensaje = "Error seleccione ciudad";
            }else if(strlen($cod_distrito) == 0){
                $mensaje = "Error seleccione distrito";
            }else if(strlen($direccion) == 0){
                $mensaje = "Error ingrese direccion";
            }else if(strlen($referencia) == 0){
                $mensaje = "Error ingrese referencia";
            }else if(count($dataproductos->arrayproductos)==0){
                $mensaje = "Error ingrese productos";
            }else if(strlen($contacto) == 0){
                $mensaje = "Error ingrese contacto";
            }else if(strlen($telefono) == 0){
                $mensaje = "Error ingrese numero de telefono";
            }else if(strlen($condicion) == 0){
                $mensaje = "Error seleccione condicion";
            }else if(strlen($entrega) == 0){
                $mensaje = "Error seleccione entrega";
            }else if(strlen($fcancelacion) == 0){
                $mensaje = "Error seleccione fecha de pago";
            }else if(strlen($num_contrato) == 0){
                $mensaje = "Error ingrese numero de contrato";
            }else if($contrato == 0){
                $mensaje = "Error contrato invalido";
            }
         
         if(strlen($mensaje) == 0){
                guardarPedidos::guardarpedido($codcliente,$oficina,$tipo_documento,$codPersonal,
                $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
                $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
                $cod_provincia,$telefono2,$condicion,$dataproductos);
         }else{
            $buscarProducto = array(
                'estado' => 'error',
                'mensaje' => $mensaje
            ); 
            echo json_encode($buscarProducto,JSON_FORCE_OBJECT);
         }
        
    }
    
    static function guardarpedido($codcliente,$oficina,$tipo_documento,$codPersonal,
    $identificacion,$cliente,$direccion,$referencia,$contacto,$telefono,$entrega,
    $fcancelacion,$est_pedido,$cod_distrito,$num_contrato,
    $cod_provincia,$telefono2,$condicion,$dataproductos){
        
        $c_guardar = new M_Pedidos($oficina);
        $verificar = $c_guardar->verificar($identificacion);
 
        if($verificar == ""){
            $observacion = observacionProducto($dataproductos);
            $total = TotalProducto($dataproductos);

            $c_pedido = $c_guardar->guardarpedido($codcliente,$codPersonal,$tipo_documento,
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