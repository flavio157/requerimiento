<?php
    require_once("DataBase.php");
    
    class m_verficiarproducto 
    {
        public function __construct() {
            $this->db=DataBase::Conectar();
        }

        public function m_verificarProcAlma($num_lote){
            $query = $this->db->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS where NUM_LOTE = '$num_lote'");
            $query->execute();
            $valor = $query->fetchAll();
            return $valor;
        }
    }
    

?>