<?php
    require_once("../db/conexionSMP2.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=ClassConexionSMP2::conexionSMP2();
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
}
?>