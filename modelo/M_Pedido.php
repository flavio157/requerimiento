<?php
   require_once("../db/Contrato.php");

   class M_Pedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=ClassContrato::Contrato($bd);
    }

    public function GuardarPedido($fecha,$cod_cliente,$cod_vendedora,$tipo_documento,$identificacion,
    $cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,$est_pedido,$observacion,
    $n_productos,$cod_distrito,$num_contrato,$cod_provincia,$telefono2){
    

       $query=$this->bd->prepare("INSERT INTO V_REGISTRAR_PEDIDO(FECHA,COD_CLIENTE,COD_VENDEDORA,
        TIPO_DOCUMENTO,IDENTIFICACION,CLIENTE,DIRECCION,REFERENCIA,CONTACTO,TELEFONO,ENTREGA,
        FCANCELACION,EST_PEDIDO,OBSERVACION,N_PRODUCTOS,
        COD_DISTRITO,NUM_CONTRATO,COD_PROVINCIA,TELEFONO2) values 
        
        (:fecha,:cod_cliente,:cod_vendedora,:tipo_documento,:identificacion,:cliente,:direccion,
        :referencia,:contacto,:telefono,:entrega,:fcancelacion,:est_pedido,:observacion,:n_productos,
        :cod_distrito,:num_contrato,:cod_provincia,:telefono2)");

        $query->bindParam("fecha",$fecha,PDO::PARAM_STR);
        $query->bindParam("cod_cliente",$cod_cliente,PDO::PARAM_STR);        
        $query->bindParam("cod_vendedora",$cod_vendedora,PDO::PARAM_STR);
        $query->bindParam("tipo_documento",$tipo_documento,PDO::PARAM_STR);
        $query->bindParam("identificacion",$identificacion,PDO::PARAM_STR);
        $query->bindParam("cliente",$cliente,PDO::PARAM_STR);
        $query->bindParam("direccion",$direccion,PDO::PARAM_STR);
        $query->bindParam("referencia",$referencia,PDO::PARAM_STR);
        $query->bindParam("contacto",$contacto,PDO::PARAM_STR);
        $query->bindParam("telefono",$telefono,PDO::PARAM_STR);
        $query->bindParam("entrega",$entrega,PDO::PARAM_STR);
        $query->bindParam("fcancelacion",$fcancelacion,PDO::PARAM_STR);
        $query->bindParam("est_pedido",$est_pedido,PDO::PARAM_STR);
        $query->bindParam("observacion",$observacion,PDO::PARAM_STR);
        $query->bindParam("n_productos",$n_productos,PDO::PARAM_INT);
        $query->bindParam("cod_distrito",$cod_distrito,PDO::PARAM_STR);
        $query->bindParam("num_contrato",$num_contrato,PDO::PARAM_STR);
        $query->bindParam("cod_provincia",$cod_provincia,PDO::PARAM_STR);
        $query->bindParam("telefono2",$telefono2,PDO::PARAM_STR);
    
        $guardarpedido = $query->execute();
        if($guardarpedido){
            return $query;
            $query->closeCursor();
            $query = "";
        }

    }


    public function GuardarPedidoCantidad($codigo,$cod_producto,$cantidad,$bono,$precio,$ccan,$cbon)
    {
        $query = $this->bd->prepare("INSERT INTO V_PEDIDO_CANTIDAD(CODIGO,COD_PRODUCTO,
                                     CANTIDAD,BONO,PRECIO,CCAN,CBON) 
                                     VALUES(:codigo,:cod_producto,:cantidad,:bono,:precio,:ccan,:cbon)");
        $query->bindParam("codigo",$codigo,PDO::PARAM_STR); 
        $query->bindParam("cod_producto",$cod_producto,PDO::PARAM_STR);
        $query->bindParam("cantidad",$cantidad,PDO::PARAM_STR);
        $query->bindParam("bono",$bono,PDO::PARAM_STR);
        $query->bindParam("precio",$precio,PDO::PARAM_INT);
        $query->bindParam("ccan",$ccan,PDO::PARAM_INT);
        $query->bindParam("cbon",$cbon,PDO::PARAM_INT);
        $guardarPecantidad = $query->execute();

        if($guardarPecantidad){
            return $guardarPecantidad;
            $query->closeCursor();
            $query = null;
        }
    
    }


    public function UltimoRegistro()
    {
        $query = $this->bd->prepare("SELECT * FROM V_ULTIMO_REGISTRO");
        $query->execute();
        $ultimoregistro =  $query->fetch(PDO::FETCH_ASSOC);
        return $ultimoregistro;
    }


   }
   




?>