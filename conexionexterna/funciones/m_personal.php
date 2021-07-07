<?php
require_once("DataDinamica.php");

class M_buscarpersonal
{
 
    public function __construct() {
        /*$this->db=DatabaseDinamica::Conectarbd($bd);*/
        $this->db=DataBase::Conectar();
    }



    public function m_buscarpersonal($personal){
           
        $query = $this->db->prepare("SELECT * FROM T_PERSONAL WHERE EST_PERSONAL = 'A' AND COD_PERSONAL LIKE '%$personal%' OR  NOM_PERSONAL LIKE '%$personal%'");
        $query->execute();
        if($query){
            return $query->fetchAll();
        }
    }
}




?>