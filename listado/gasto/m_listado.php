<?php
require_once("../funciones/DataBase.php");
    class m_listado 
    {
        private $db;
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }

        public function listado()
        {
            $query = $this->db->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS");
            $query->execute();
            $listado = $query->fetchAll();
            return $listado;
        }


        public function buscar($dato)
        {
            $query = $this->db->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS where COD_INGRESO ='$dato'");
            $query->execute();
            $listado = $query->fetchAll();
            return $listado;
        }
    }
    
?>