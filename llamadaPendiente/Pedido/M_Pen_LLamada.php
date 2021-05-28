<?php
require_once("../Funciones/Database.php");
    class M_Pen_Llamada{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Usuario();
        }



        public function M_LlamadasDta(){
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE");
            $query->execute();
            $pendiente = $query->fetchAll(PDO::FETCH_ASSOC);
            if($query){
                return  $pendiente;
            }
        }




        public function M_pendiente($hora,$fecha)
        {
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE 
                    WHERE HORA_OPERADORA = :hora");
                  
            $query->bindParam("hora", $hora, PDO::PARAM_STR);
            $query->execute();
            $pendiente = $query->fetch(PDO::FETCH_ASSOC);
            
            if($query){
                return  $pendiente;
            }
        }
    }



?>