<?php
    require_once("../funciones/DataBasePlasticos.php");

    class m_moldes 
    {
        private $bd;
        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }   

        public function m_buscar($tabla,$dato)
        {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }
    }
?>