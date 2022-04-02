<?php
require_once("funciones/Database.php");
require_once("funciones/f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Conectar();
    }
    
    public function Login($cod_usuario)
    {   
              $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL where NOM_USUARIO = '$cod_usuario'");
           // $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL WHERE COD_PERSONAL = $cod_usuario AND EST_USUARIO != 'A'");
            $query->execute();
            $registro = $query->fetchAll(PDO::FETCH_NUM);
           
            if($registro){
                f_regSession($registro[0][3],$registro[0][7],$registro[0][1],$registro[0][6],$registro[0][8]);
                return  $registro;
            }else{
              return '';
            }
    }
}
?>
