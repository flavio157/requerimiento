<?php
require_once("../funciones/DataBase.php");
require_once("../funciones/f_funcion.php");
class m_menu
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
        $query = $this->db->prepare("SELECT * from T_PERMISOS  where ANEXO = '$anexo'");
        $query->execute();
        $permisos = $query->fetchAll(PDO::FETCH_NUM);
        return  $permisos;
    }

    public function m_listarmenu($idmenu){
        $query = $this->db->prepare("SELECT * from T_CAB_MENU where ID_MENU = '$idmenu' and ESTADO = '1'");
        $query->execute();
        $menu = $query->fetchAll();
        return  $menu;
    }

    
    public function m_listasubmenus($id_menu,$id_submenu){
        $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$id_menu' and ID_SUBMENU1='$id_submenu' AND ESTADO1 = '1'");
        $query->execute();
        return $query->fetchAll();
    }
    

    public function m_listasubmenus2($id_menu,$id_submenu,$idsubmenu2){
        $query = $this->db->prepare("SELECT ID_MENU , IDSUBMENU1 , 
        IDSUBMENU2 , SUB_NOMBRE2 , URL2 , ESTADO2 
        FROM T_SUB_MENUS where ID_MENU = '$id_menu' and  IDSUBMENU1 ='$id_submenu' and IDSUBMENU2='$idsubmenu2' and ESTADO2 = '1'");
        $query->execute();
        return $query->fetchAll();
    }

    


    public function m_listaMenuthree()
    {
        $query = $this->db->prepare("SELECT * FROM T_CAB_MENU WHERE ESTADO = '1'");
        $query->execute();
        return $query->fetchAll();
    } 

    public function m_listasubmenusthree($idmenu){
        $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND ESTADO1 = '1'");
        $query->execute();
        return $query->fetchAll();
    }

    public function m_listarSubmenus2three($idsubmenu){
        $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE IDSUBMENU1 = '$idsubmenu' AND ESTADO2 = '1' ");
        $query->execute();
        return $query->fetchAll();
    }
   
}
?>
