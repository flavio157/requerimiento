<?php
    require_once("../funciones/DataBase.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Usuario();
        }
        

        /*buscar y retorna el producto con su precio web */
        public function M_BuscarProducto_WEB($nom_producto)
        {
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO_WEB WHERE ABREVIATURA LIKE '%$nom_producto%'");
            $query->execute();
            $producto =  $query->fetchAll();
           if ($query) {
                return $producto ;
            }
        }
        
        
        public function M_VerificarRegalo($gramo,$cantidad){
            $query=$this->db->prepare("SELECT * FROM V_PRODUCTO_REGALO WHERE UNIDAD_MEDIDA = :gramo 
                                       AND CANTIDAD = :cantidad");
            $query->bindParam("gramo",$gramo, PDO::PARAM_INT);
            $query->bindParam("cantidad",$cantidad, PDO::PARAM_INT);                           
            $query->execute();
            $regalo =  $query->fetchAll();
            if ($query) {
                return $regalo;
            }
        }
}
?>