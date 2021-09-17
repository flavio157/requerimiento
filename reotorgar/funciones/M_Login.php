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
            if($registro){
              $permiso = $this->m_verificarperimiso($registro['COD_PERSONAL'],$registro['OFICINA']);
              if(sizeof($permiso) > 0){
                f_regSession($registro['ANEXO_USUARIO'],$registro['COD_PERSONAL'],$registro['NOM_USUARIO'],$registro['OFICINA'],$registro['ZONA']);
                return  $registro;
              }else{
                return '';
              }
            }
    }


    public function m_verificarperimiso($cod_personal,$oficina){

        $fecha = retunrFechaSql(date("d-m-Y"));
        $query=$this->db->prepare("SELECT * FROM T_PERMISO_REOTORGAR WHERE COD_PERSONAL = '$cod_personal' AND 
        OFICINA = '$oficina' AND FECHA = '$fecha'");
        $query->execute();
        $permiso = $query->fetchAll();
        return $permiso;
    }
   
}
?>
