<?php
    require_once("../db/Usuarios.php");

class M_BuscarProductos{

        private $db;
    
        public function __construct()
        {
            $this->db=ClassUsuario::Usuario();
        }
        
        public function M_BuscarProducto($zona,$nom_producto)
        {
            $producto = strip_tags($nom_producto);
            $query=$this->db->prepare("SELECT * FROM V_BUSCAR_PRODUCTO WHERE ZONA = :zona AND DES_PRODUCTO LIKE '%$nom_producto%'");
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
                AND CANTIDAD < 19 AND COD_PRODUCTO = :cod_producto";

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


}
?>