<?php
    require_once("../funciones/DataBase.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Conectar();
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
            $query=$this->db->prepare("SELECT * FROM T_PRODUCTOS_REGALO WHERE UNIDAD_MEDIDA = $gramo  AND CANTIDAD = $cantidad
            AND  ESTADO = '1'");                  
            $query->execute();
            $regalo =  $query->fetchAll();
            if ($query) {
                return $regalo;
            }
        }
}
?>