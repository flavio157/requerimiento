<?php
require_once("../funciones/Database.php");
require_once("../funciones/f_funcion.php");
    class M_Pen_Llamada{

        private $db;
    
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }



        public function M_LlamadasDta($cod_operadora,$ofi){
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE WHERE COD_OPERADORA =".$cod_operadora." AND OFI_OPERADORA  ='$ofi'");
            $query->execute();
            $pendiente = $query->fetchAll(PDO::FETCH_ASSOC);
            if($query){
                return  $pendiente;
            }
        }




        public function M_pendiente($hora,$cod_operadora,$ofi)
        {
            $query=$this->db->prepare("SELECT * FROM V_LLAMADA_PENDIENTE 
                    WHERE HORA_OPERADORA <='$hora' AND COD_OPERADORA = ".$cod_operadora." AND OFI_OPERADORA = '$ofi'");
            $query->execute();
            $pendiente = $query->fetch(PDO::FETCH_ASSOC);
            
            if($query){
                return  $pendiente;
            }
        }
    }
?>