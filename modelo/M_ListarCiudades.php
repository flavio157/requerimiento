<?php
require_once("../db/Contrato.php");
class M_ListarCiudades{
      
    private $db;
    
    public function __construct($bd)
    {
        $this->db=ClassContrato::Contrato($bd);
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

    public function M_Distrito($id_departamento,$id_provincia){
        $query=$this->db->prepare("SELECT * from V_DISTRITO where COD_DEPARTAMENTO = :departamento  
                                  and  COD_PROVINCIA = :provincia");
        $query->bindParam("departamento", $id_departamento, PDO::PARAM_STR);
        $query->bindParam("provincia", $id_provincia, PDO::PARAM_STR);
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