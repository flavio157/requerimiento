<?php
require_once("../Funciones/DataDinamica.php");
class M_ListarCiudades{
      
    private $db;
    
    public function __construct($bd)
    {
        
        $this->db=DatabaseDinamica::Conectarbd($bd);
     
    }
    
    public function M_Provincia(){
        $query=$this->db->prepare("SELECT * from V_PROVINCIA");
        $query->execute();
        $datosProvincia = $query->fetchAll();
        if($datosProvincia){
            return $datosProvincia;
            $query->closeCursor();
            $query = null;
        }

    }

    public function M_Distrito($id_provincia){
        $query=$this->db->prepare("SELECT * from V_DISTRITO WHERE COD_PROVINCIA ='$id_provincia'");
        $query->execute();
        $datosDistrito = $query->fetchAll();
        if($datosDistrito){
            return $datosDistrito;
            $query->closeCursor();
            $query = null;
        }
    }
}

?>