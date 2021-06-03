<?php
require_once("../Funciones/Database.php");
require_once("../Funciones/f_funcion.php");
class M_CDR
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Conectar();
    }
    
    public function CDR($fecha,$src,$dst)
    {       
            $query=$this->db->prepare("SELECT * FROM CDR WHERE calldate >= '$fecha' AND calldate < GETDATE() AND
            (src = '$src' OR dst = '$dst')");
            $query->execute();
            $dato = $query->fetchAll();
            if($query){
                return  $dato;
            }
    }
}
?>
