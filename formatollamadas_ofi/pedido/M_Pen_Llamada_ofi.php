<?php
require_once("../funciones/DataDinamica.php");
require_once("../funciones/f_funcion.php");
    class M_Pen_Llamada_Ofi{

        private $db;
    
        public function __construct($ofi)
        {
            $this->db=DatabaseDinamica::Conectarbd($ofi);
        }



        public function M_LlamadasDta($cod_operadora,$oficinalogin){
            $query=$this->db->prepare("SELECT * FROM V_RESUMEN_EMPADRONADORA WHERE COD_OPERADORA =".$cod_operadora."AND OFI_OPERADORA ='$oficinalogin'");
       
            $query->execute();
            $pendiente = $query->fetchAll(PDO::FETCH_ASSOC);
            if($query){
                return  $pendiente;
            }
        }




        public function M_pendiente($hora,$cod_operadora,$oficinalogin)
        {
          
            $query=$this->db->prepare("SELECT * FROM V_RESUMEN_EMPADRONADORA 
                    WHERE HORA_OPERADORA <='$hora' AND COD_OPERADORA =".$cod_operadora." AND OFI_OPERADORA ='$oficinalogin'");
            $query->execute();
            $pendiente = $query->fetch(PDO::FETCH_ASSOC);
            
            if($query){
                return  $pendiente;
            }
        }
    }
?>