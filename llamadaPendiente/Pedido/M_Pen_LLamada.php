<?php
require_once("../Funciones/Database.php");
require_once("../Funciones/f_funcion.php");
    class M_Pen_Llamada{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Usuario();
        }



        public function M_LlamadasDta($cod_operadora,$ofi){
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE WHERE COD_OPERADORA = :cod_operadora
            AND OFI_OPERADORA = :oficina");
            $query->bindParam("cod_operadora", $cod_operadora, PDO::PARAM_STR);
            $query->bindParam("oficina", $ofi, PDO::PARAM_STR);
            $query->execute();
            $pendiente = $query->fetchAll(PDO::FETCH_ASSOC);
            if($query){
                return  $pendiente;
            }
        }




        public function M_pendiente($hora,$cod_operadora,$ofi)
        {
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE 
                    WHERE HORA_OPERADORA <= :hora AND COD_OPERADORA = :cod_operadora AND OFI_OPERADORA = :oficina");
                  
            $query->bindParam("hora", $hora, PDO::PARAM_STR);
            $query->bindParam("cod_operadora", $cod_operadora, PDO::PARAM_STR);
            $query->bindParam("oficina", $ofi, PDO::PARAM_STR);
            $query->execute();
            $pendiente = $query->fetch(PDO::FETCH_ASSOC);
            
            if($query){
                return  $pendiente;
            }
        }
    }



?>