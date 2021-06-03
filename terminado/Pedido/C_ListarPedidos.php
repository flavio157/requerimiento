<?php
    require_once("M_ListarPedidos.php");

    date_default_timezone_set('America/Lima');

    $accion = $_POST["accion"];
      
    if($accion == "mostrarPedidos"){
        $tipo = $_POST['tipo'];
        $codvendedor = $_POST['codpersonal'];
        $oficina = $_POST['oficina'];
        C_ListarPedidos::mostrarPedido($codvendedor,$tipo,$oficina);
    }


    class C_ListarPedidos
    { 
        static function mostrarPedido($cod_vendedor,$tipo,$oficina){
            $c_mostrarpedido = new M_ListarPedidos($oficina);
            $datos = $c_mostrarpedido->mostrarPedido($cod_vendedor,date("d-m-Y"),$tipo);
            if($datos == ""){$datos = "No hay Pedidos registrados";}
            print_r($datos);
        }

    }

?>