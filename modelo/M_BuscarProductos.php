<?php
    require_once("../db/Contrato.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct($database)
        {
            $this->db=ClassContrato::Contrato($database);
        }
        
        public function M_BuscarProducto($cod_producto)
        {
            $query=$this->db->prepare("SELECT * from T_PRODUCTO where COD_PRODUCTO =:cod_producto");
            $query->bindParam("cod_producto", $cod_producto, PDO::PARAM_STR);
            $query->execute();
            $datosproducto = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
                return $datosproducto;
                $query->closeCursor();
                $query = null;
            }
        } 
      
        public function M_PoliticaProductos($cantidad)
        {
           
            $query=$this->db->prepare("SELECT * FROM T_POLITICA_PRECIOS WHERE CANTIDAD <= :pcantidad and CANT_FIN >= :pcantidadfin");
            $query->bindParam("pcantidad", intval($cantidad)  , PDO::PARAM_INT);
            $query->bindParam("pcantidadfin", intval($cantidad) , PDO::PARAM_INT);
            
            $query->execute();
            $datosproducto = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
                return $datosproducto;
                $query->closeCursor();
                $query = null;
            }
        } 
}
?>