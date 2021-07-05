<?php
require_once("DataDinamica.php");

class M_buscarpersonal
{
 
    public function __construct($bd) {
        $this->bd=DatabaseDinamica::Conectarbd($bd);
    }



    public function m_buscarpersonal($personal){
           
        $query = $this->bd->prepare("SELECT * FROM T_PERSONAL WHERE EST_PERSONAL = 'A' AND COD_PERSONAL LIKE '%$personal%' OR  NOM_PERSONAL1 LIKE '%$personal%'");
        $query->execute();
        if($query){
            return $query->fetchAll();
        }
    }
}




?>