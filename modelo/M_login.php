<?php
require_once("../db/conexion.php");
class M_Login
{
    private $db;
    private $Usuario;
    
    public function __construct()
    {
        $this->db=ClassConexion::conexion();
    }
    
    public function get_usuario($usu,$pass)
    {
        $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL where NOM_USUARIO=:username and PDW_USUARIO=:pass");
        $query->bindParam("username", $usu, PDO::PARAM_STR);
        $query->bindParam("pass", $pass, PDO::PARAM_STR);
        $query->execute();
        $datosUsuario = $query->fetch(PDO::FETCH_ASSOC);
        if(!$query){
           
        }else{
               $_SESSION['user_id'] = $datosUsuario['NOM_USUARIO'];
        }
        return $datosUsuario;
    }

}

?>