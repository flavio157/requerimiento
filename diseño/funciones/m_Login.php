<?php
require_once("DataBase.php");
require_once("f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Conectar();
    }
    
    public function Login($nom_usuario)
    {
        
        $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL where NOM_USUARIO = '$nom_usuario'");
        $query->execute();
        $cod_usuario = $query->fetchAll();
       
        
        if(count($cod_usuario) == 1){
            f_regSession($cod_usuario[0]['ANEXO_USUARIO'],$cod_usuario[0]['COD_PERSONAL'],$cod_usuario[0]['NOM_USUARIO'],$cod_usuario[0]['OFICINA'],$cod_usuario[0]['ZONA']); 
        }
        return  $cod_usuario;  
    }


    public function m_permisos($anexo){
        $query = $this->db->prepare("SELECT * FROM T_PERMISOS WHERE ANEXO = '$anexo'");
        $query->execute();
        $permisos = $query->fetchAll(PDO::FETCH_NUM);
        return  $permisos;
    }


    public function m_listaMenu()
    {
        $query = $this->db->prepare("SELECT * FROM T_CAB_MENU WHERE ESTADO = '1'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_NUM);
    }    

    public function m_listasubmenus($idmenu){
        $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND ESTADO1 = '1'");
        $query->execute();
        return $query->fetchAll();
    }

    public function m_listarSubmenus2($idsubmenu){
        $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE IDSUBMENU1 = '$idsubmenu' AND ESTADO2 = '1' ");
        $query->execute();
        return $query->fetchAll();
    }
   
}
?>
