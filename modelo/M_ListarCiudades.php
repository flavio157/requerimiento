<?php
require_once("../db/Contrato.php");
require_once("../db/Usuarios.php");
class M_ListarCiudades{
      
    private $db;
    
    public function __construct($bd)
    {
        if($bd != "SMP2"){
            $this->db=ClassUsuario::Usuario();
        }else{
            $this->db=ClassContrato::Contrato($bd);
        }
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
        $query=$this->db->prepare("SELECT * from V_DISTRITO WHERE COD_PROVINCIA = :provincia");
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