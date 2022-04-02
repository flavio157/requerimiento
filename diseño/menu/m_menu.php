<?php
date_default_timezone_set('America/Lima');
require_once("funciones/DataBasePlasticos.php");
require_once("funciones/f_funcion.php");

class m_menu
{
    private $db;
    
    public function __construct()
    {
        $this->db=DataBasePlasticos::Conectar();
    }
    
    public function m_permisos($anexo){
        try {
            $query = $this->db->prepare("SELECT * from T_PERMISOS  where ANEXO = '$anexo'");
            $query->execute();
            $permisos = $query->fetchAll();
            return  $permisos;
        } catch (Exception $e) {
           print_r("Error buscar Permisos" . $e);
        }
      
    }

    public function m_listarmenu($idmenu){
        try {
            $query = $this->db->prepare("SELECT * from T_CAB_MENU where ID_MENU = '$idmenu' 
            and ESTADO = '1'");
            $query->execute();
            $menu = $query->fetchAll();
            return  $menu;
        }catch (Exception $e) {
            print_r("Error buscar Cabecera" . $e);
        }
        
    }

    
    public function m_listasubmenus($id_menu,$id_submenu){
        try {
            $query = $this->db->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$id_menu' and ID_SUBMENU1='$id_submenu' AND ESTADO1 = '1'");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            print_r("Error buscar sub menu" . $e);
        }
      
    }
    

    public function m_listasubmenus2($id_menu,$id_submenu,$idsubmenu2){
        try {
            $query = $this->db->prepare("SELECT ID_MENU , IDSUBMENU1 , 
            IDSUBMENU2 , SUB_NOMBRE2 , URL2 , ESTADO2 
            FROM T_SUB_MENUS where ID_MENU = '$id_menu' and  IDSUBMENU1 ='$id_submenu' and IDSUBMENU2='$idsubmenu2' and ESTADO2 = '1'");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            print_r("Error buscar sub menu 2" . $e);
        }
       
    }
}
?>
