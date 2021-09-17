<?php
    require_once("DataBase.php");
    class m_almacen_productos 
    {
        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }

        public function m_buscar_Almacen($num_lote)
        {
            $query= $this->db->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS WHERE NUM_LOTE = '$num_lote'");
            $query->execute();
            $producto = $query->fetchAll();
            return $producto;
        }

        public function m_guardar_observacion_Proc(){
            $query = $this->db->prepare("INSERT INTO T_PRODUCTO_OBSERVACION_GUIA(COD_PERSONAL,OFICINA,FECHA)
            VALUES()");
        }

        
    }
    
?>