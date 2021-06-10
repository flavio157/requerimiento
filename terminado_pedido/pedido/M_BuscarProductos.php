<?php
    require_once("../funciones/DataBase.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }
        
        public function M_BuscarProducto($zona,$nom_producto)
        {
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO WHERE ZONA = $zona AND ABREVIATURA LIKE '%$nom_producto%'");
            $query->execute();
           if ($query) {
                return $query->fetchAll();
                $query->closeCursor();
                $query = null;
            }
        } 

      
        public function M_PoliticaPrecios($zona,$cantidad,$codproducto)
        {   
            $consulta = "";
            
            if($cantidad < '10'){
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO  WHERE ZONA = $zona AND CANTIDAD < 10
                AND COD_PRODUCTO = '$codproducto'";
                
            }else if($cantidad > '9' && $cantidad <= '19')
            {
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO  WHERE ZONA = $zona AND CANTIDAD > 9
                AND CANTIDAD <= 19 AND COD_PRODUCTO = '$codproducto'";

            }else if($cantidad >= '20'){
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO  WHERE ZONA = $zona AND CANTIDAD = 20
                             AND COD_PRODUCTO = '$codproducto'";
            }

            $query=$this->db->prepare($consulta);
            $query->execute();
            $datosproducto = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
                return  $datosproducto;
                $query->closeCursor();
                $query = null;
            }
        } 
                

        public function M_PoliticaBono($zona,$cantidad)
        {   
            $consulta = "";
            if($cantidad >= '6' && $cantidad <= '9'){
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO WHERE ZONA = $zona AND CANTIDAD <= 9";
                
            }else if($cantidad >= '10' && $cantidad <='19'){
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO WHERE ZONA = $zona AND CANTIDAD >= 10
                AND CANTIDAD <= 19 ";

            }else if($cantidad >= '20'){
                $consulta = "SELECT * FROM T_PRODUCTO_PRECIO WHERE ZONA = $zona AND CANTIDAD = 20";
            }

            if($consulta == ""){return 0;}

            $query=$this->db->prepare($consulta);
            $query->execute();
            $datosproducto = $query->fetch(PDO::FETCH_ASSOC);
          
            if($query){
                return $datosproducto;
                $query->closeCursor();
                $query = null;
            }
        }


        public function M_Combo($cod_combo){
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_COMBO WHERE ABR_PRODUCTO LIKE '%$cod_combo%'");
            $query->execute();
           if ($query) {
                return $query->fetchAll();
                $query->closeCursor();
                $query = null;
            }
        }


        public function M_ComboItem($cod_combo){
            $query=$this->db->prepare("SELECT * FROM T_COMBO_ITEM WHERE COD_COMBO = '$cod_combo'");
            $query->execute();
            $cod_productos = "";
            if($query){
                while ($row = $query->fetch()) {
                    if( $cod_productos != ""){
                        $cod_productos .= " - ".$row['COD_PRODUCTO'];
                    }else{
                        $cod_productos .=$row['COD_PRODUCTO'];
                    }
                   
                }
                return  $cod_productos;
                $query->closeCursor();
                $query = null;
            }

        }

        public function M_ComboProducto($cod_combo){
            $query=$this->db->prepare("SELECT * FROM V_COMBOPRODUCTO WHERE combo = '$cod_combo'");
            $query->execute();
            $productos = $query->fetchAll();
            if($query){
                return  $productos;
                $query->closeCursor();
                $query = null;
            }

        }

}
?>