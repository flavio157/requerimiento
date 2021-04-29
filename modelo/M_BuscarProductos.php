<?php
    require_once("../db/Usuarios.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=ClassUsuario::Usuario();
        }
        
        public function M_BuscarProducto($nom_producto)
        {
            $producto = strip_tags($nom_producto);
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO WHERE DES_PRODUCTO LIKE '%$nom_producto%'");
            $query->execute();
            /* ABR_PRODUCTO*/
           if ($query) {
               $html = "";
                while ($row = $query->fetch()) {                
                    $html .= '<div><a class="suggest-element" data-="'.$row['DES_PRODUCTO'].'&'.$row['PRE_PRODUCTO'].'"  
                    id="'.$row['COD_PRODUCTO'].'">'.$row['DES_PRODUCTO'].'</a></div>';
                }
                return $html ;
                $query->closeCursor();
                $query = null;
            }

           
        } 
      
        public function M_PoliticaProductos($cantidad)
        {
            $query=$this->db->prepare("SELECT * FROM V_POLITICA_PRECIOS WHERE CANTIDAD <= :pcantidad and CANT_FIN >= :pcantidadfin");
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