<?php
    //require_once("../funciones/DatabasePlasticos.php"); 
    require_once("../funciones/Database.php"); 
    class m_guardar_permisos 
    {
        private $bd;
        public function __construct()
        {
           //  $this->bd=DataBasePlasticos::Conectar();
           $this->bd=DataBase::Conectar();
        }
            
        public function m_consultar_permisos($anexo){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_PERMISOS WHERE ANEXO = '$anexo'");
                $query->execute();
                $permisos = $query->fetchAll();
                return  $permisos;
            } catch (Exception $e) {
                print_r("Error al consultar permisos" . $e);
             }
         
        }

        public function m_guardar_permisos($anexo,$dt){
            $this->bd->beginTransaction();
            try{
                $query = $this->bd->prepare("DELETE T_PERMISOS WHERE ANEXO = '$anexo'");
                $query->execute();
                if($query->errorCode()>0){
                    $this->bd->rollBack();
                    return 0;
                }
               

                foreach ($dt->permisos as $date){
                    if($date[0] != ""){
                        $query2 = $this->bd->prepare("INSERT INTO T_PERMISOS values('$anexo','$date[0]','$date[1]','$date[2]')");
                        $query2->execute();
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                                break;
                            }
                    }
                }
               
                $guardado = $this->bd->commit();
                return  $guardado;
            
               }catch(Exception $e){
                  $this->bd->rollBack();
                  return $e;
                }
           

        }
        public function m_listaMenuthree()
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_CAB_MENU WHERE ESTADO = '1'");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                print_r("Error al consultar menus three" . $e);
             }
          
        } 
    
        public function m_listasubmenusthree($idmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND ESTADO1 = '1'");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                print_r("Error al consultar sub menus three" . $e);
            }
            
        }
        public function m_listarSubmenus2three($idsubmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE IDSUBMENU1 = '$idsubmenu' AND ESTADO2 = '1' ");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                print_r("Error al consultar sub sub menus three" . $e);
            }
          
        }



        public function m_lstMenu()
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_CAB_MENU");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {   
                print_r("Error al consultar menus" . $e);             
            }
        } 
    
        public function m_lstsubmenu($idmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu'");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                print_r("Error al consultar sub menus" . $e);
            }
           
        }
        public function m_lstSubmenu2($idmenu,$idsubmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND IDSUBMENU1 = '$idsubmenu'");
                $query->execute();
                return $query->fetchAll();
            } catch (Exception $e) {
                print_r("Error al consultar sub sub menus" . $e);
            }
           
        }
       
        public function m_actualizar($tabla, $datos)
        {
            try {
                $query = $this->bd->prepare("UPDATE $tabla SET $datos");
                $menus =  $query->execute();
                return $menus;
            } catch (Exception $e) {
               print_r("Error al actualizar datos" . $e);
            }
        }
        
    }

?>