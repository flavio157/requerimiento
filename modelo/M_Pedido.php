<?php
   require_once("../db/Contrato.php");

   class M_Pedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=ClassContrato::Contrato($bd);
    }

    public function GuardarPedido($codigo,$cod_cliente,$cod_vendedora,$tipo_documento,$identificacion,
    $cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,$est_pedido,$freparto,
    $cod_reparto,$cod_distrito,$num_contrato,$cod_provincia,
    $fec_despacho){

       

    }


    public function GuardarPedidoCantidad($codigo,$cod_producto,$cantidad,$bono,$precio,$ccan,$cbon)
    {
       
    }



   }
   




?>