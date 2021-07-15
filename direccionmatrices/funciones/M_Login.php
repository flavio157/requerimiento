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
            $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL WHERE COD_PERSONAL = $cod_usuario AND EST_USUARIO != 'A'");
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            f_regSession($cod_usuario['ANEXO_USUARIO'],$cod_usuario['COD_PERSONAL'],$cod_usuario['NOM_USUARIO'],$cod_usuario['OFICINA'],$cod_usuario['ZONA']);
            if($query){
                return  $cod_usuario;
                $query->closeCursor();
                $query = null;
            }
    }
}
?>
