<?php
   require_once("DataDinamica.php");
   require_once("f_funcion.php");

   class M_ListarPedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=DatabaseDinamica::Conectarbd($bd);
    }

    public function mostrarPedido($cod_vendedor,$fecha)
    {
        $nuevafecha = retunrFechaSql($fecha);
        $query = $this->bd->prepare("SELECT * FROM T_PPEDIDO 
        WHERE COD_VENDEDORA = '$cod_vendedor' AND Fecha >= '$nuevafecha' AND EST_PEDIDO != 'A'  ORDER BY CODIGO DESC"); 
        $query->execute();
        return $query->fetchAll();
        $query->closeCursor();
        $query = null;

        
    
    }


    public function mostrarPedidoItems($idpedido)
    {
        $query = $this->bd->prepare("SELECT * FROM V_MOSTRAR_PEDIDO_ITEM 
        WHERE CODIGO = '$idpedido'"); 
        $query->execute();
        return $query->fetchAll();
        $query->closeCursor();
        $query = null;
    }
   }
   




?>