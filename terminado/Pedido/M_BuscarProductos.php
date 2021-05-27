<?php
    require_once("../Funciones/DataBase.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Usuarios();
        }
        
        public function M_BuscarProducto($zona,$nom_producto)
        {
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO WHERE ZONA = :zona AND ABREVIATURA LIKE '%$nom_producto%'");
            $query->bindParam("zona",$zona, PDO::PARAM_INT);
            $query->execute();
           if ($query) {
               $html = "";
                while ($row = $query->fetch()) {                
                    $html .= '<div><a class="suggest-element" data-="'.$row['DES_PRODUCTO'].'&'.$row['PRECIO'].'"  
                    id="'.$row['CODIGO'].'">'.$row['DES_PRODUCTO'].'</a></div>';
                }
                return $html ;
                $query->closeCursor();
                $query = null;
            }
        } 

      
        public function M_PoliticaPrecios($zona,$cantidad,$codproducto)
        {   
            $consulta = "";
            
            if($cantidad < '10'){
                $consulta = "SELECT * FROM V_POLITICA_PRECIOS WHERE ZONA = :zona AND CANTIDAD < 10
                AND COD_PRODUCTO = :cod_producto";
                
            }else if($cantidad > '9' && $cantidad <= '19')
            {
                $consulta = "SELECT * FROM V_POLITICA_PRECIOS WHERE ZONA = :zona AND CANTIDAD > 9
                AND CANTIDAD <= 19 AND COD_PRODUCTO = :cod_producto";

            }else if($cantidad >= '20'){
                $consulta = "SELECT * FROM V_POLITICA_PRECIOS WHERE ZONA = :zona AND CANTIDAD = 20
                             AND COD_PRODUCTO = :cod_producto";
            }

            $query=$this->db->prepare($consulta);
            $query->bindParam("zona",$zona,PDO::PARAM_STR);
            $query->bindParam("cod_producto", $codproducto, PDO::PARAM_INT); 
            $query->execute();
            $datosproducto = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
                return  $datosproducto;
                $query->closeCursor();
                $query = null;
            }
        } 
                

        public function M_PoliticaBono($zona,$cantidad,$codproducto)
        {   
            $consulta = "";
            if($cantidad >= '6' && $cantidad <= '9'){
                $consulta = "SELECT * FROM V_POLITICA_BONOS WHERE ZONA = :zona AND CANTIDAD <= 9
                AND COD_PRODUCTO = :cod_producto";
                
            }else if($cantidad >= '10' && $cantidad <='19'){
                $consulta = "SELECT * FROM V_POLITICA_BONOS WHERE ZONA = :zona AND CANTIDAD >= 10
                AND CANTIDAD <= 19 AND COD_PRODUCTO = :cod_producto";

            }else if($cantidad >= '20'){
                $consulta = "SELECT * FROM V_POLITICA_BONOS WHERE ZONA = :zona AND CANTIDAD = 20
                AND COD_PRODUCTO = :cod_producto";
            }

            if($consulta == ""){return 0;}

            $query=$this->db->prepare($consulta);
            $query->bindParam("zona",$zona,PDO::PARAM_STR);
            $query->bindParam("cod_producto", $codproducto, PDO::PARAM_INT); 
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
               $html = "";
                while ($row = $query->fetch()) {                
                    $html .= '<div><a class="suggest-element" data-="'.$row['PRECIO'].'"
                    class ="'.$row['COD_COMBO'].'" id="'.$row['NOM_COMPLETO'].'">'.$row['NOM_COMPLETO'].'</a></div>';
                }
                return $html ;
                $query->closeCursor();
                $query = null;
            }
        }


        public function M_ComboItem($cod_combo){
            $query=$this->db->prepare("SELECT * FROM V_COMBOITEM WHERE COD_COMBO = :cod_combo");
            $query->bindParam("cod_combo",$cod_combo,PDO::PARAM_STR);
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
            $query=$this->db->prepare("SELECT * FROM V_COMBOPRODUCTO WHERE combo = :cod_combo");
            $query->bindParam("cod_combo",$cod_combo,PDO::PARAM_STR);
            $query->execute();
            $productos = $query->fetchAll();
            if($query){
                return  $productos;
                $query->closeCursor();
                $query = null;
            }

        }



        /*buscar y retorna el producto con su precio web */
        public function M_BuscarProducto_WEB($nom_producto)
        {
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO_WEB WHERE ABREVIATURA LIKE '%$nom_producto%'");
            $query->execute();
           if ($query) {
               $html = "";
                while ($row = $query->fetch()) {                
                    $html .= '<div><a class="suggest-element" data-="'.$row['DES_PRODUCTO'].'&'.$row['PRECIO'].'"  
                    id="'.$row['CODIGO'].'">'.$row['DES_PRODUCTO'].'</a></div>';
                }
                return $html ;
                $query->closeCursor();
                $query = null;
            }
        } 
}
?>