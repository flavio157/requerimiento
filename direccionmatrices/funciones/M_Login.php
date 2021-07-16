<?php
require_once("Database.php");
require_once("f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Conectar();
    }
    
    public function Login($cod_usuario)
    {   
            //  $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL where NOM_USUARIO = '$cod_usuario'");
          $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL WHERE COD_PERSONAL = $cod_usuario AND EST_USUARIO != 'A'");
            $query->execute();
            $registro = $query->fetch();
            f_regSession($registro['ANEXO_USUARIO'],$registro['COD_PERSONAL'],$registro['NOM_USUARIO'],$registro['OFICINA'],$registro['ZONA']);
            if($query){
                return  $cod_usuario;
                $query->closeCursor();
                $query = null;
            }
    }
}
?>
