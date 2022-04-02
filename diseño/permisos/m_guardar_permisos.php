<?php
    require_once("../funciones/DatabasePlasticos.php"); 
   // require_once("../funciones/Database.php"); 
    class m_guardar_permisos 
    {
        private $bd;
        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
          //  $this->bd=DataBase::Conectar();
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
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {
                print_r("Error al consultar menus three" . $e);
             }
          
        } 
    
        public function m_listasubmenusthree($idmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND ESTADO1 = '1'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {
                print_r("Error al consultar sub menus three" . $e);
            }
            
        }
        public function m_listarSubmenus2three($idsubmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE IDSUBMENU1 = '$idsubmenu' AND ESTADO2 = '1' ");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {
                print_r("Error al consultar sub sub menus three" . $e);
            }
          
        }



        public function m_lstMenu()
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_CAB_MENU");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {   
                print_r("Error al consultar menus" . $e);             
            }
        } 
    
        public function m_lstsubmenu($idmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {
                print_r("Error al consultar sub menus" . $e);
            }
           
        }
        public function m_lstSubmenu2($idmenu,$idsubmenu){
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE ID_MENU = '$idmenu' AND IDSUBMENU1 = '$idsubmenu'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {
                print_r("Error al consultar sub sub menus" . $e);
            }
           
        }
       

        public function m_buscarMenu($idmenu)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_CAB_MENU WHERE ID_MENU = '$idmenu'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {   
                print_r("Error al buscar menu" . $e);             
            }
        } 

        public function m_buscarsubMenu($idmenu,$idsubmenu)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE 
                ID_MENU = '$idmenu' AND ID_SUBMENU1 = '$idsubmenu'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {   
                print_r("Error al buscar submenu" . $e);             
            }
        } 

        public function m_buscarsubsubMenu($idmenu,$idsubmenu,$disubmenu2)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_SUB_MENUS WHERE 
                ID_MENU = '$idmenu' AND IDSUBMENU1 = '$idsubmenu' AND IDSUBMENU2 = '$disubmenu2'");
                $query->execute();
                $resulta = $query->fetchAll();
                return $resulta;
            } catch (Exception $e) {   
                print_r("Error al buscar submenu2" . $e);             
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
        
        public function m_guardarmenu($nombre,$url,$estado)
        {
            try {
                $idmenu = $this->m_generarcodigo("ID_MENU","T_CAB_MENU");
                $query = $this->bd->prepare("INSERT INTO T_CAB_MENU(ID_MENU,NOMBRE,URL,ESTADO) 
                VALUES('$idmenu','$nombre','$url','$estado')");
                $guardarmenu = $query->execute();
                return $guardarmenu;
            } catch (Exception $e) {
                print_r("Error al guardar menu" . $e);
            } 
        }

        public function m_guardarsubmenus($idmenu,$nombre,$url,$estado){
            try {
                $idsubmenu = $this->m_generarcodigo("ID_SUBMENU1","T_SUB_MENUS");
                $query = $this->bd->prepare("INSERT INTO T_SUB_MENUS                 
                VALUES('$idmenu','$idsubmenu','$nombre','$url','','','','','$estado','')");
                /*print_r($query);*/
                $guardarmenu = $query->execute();
                return $guardarmenu;
            } catch (Exception $e) {
                print_r("Error al guardar submenu" . $e);
            } 
        }

        public function m_guardarsubmenus2($idmenu,$idsubmenu,$nombre,$url,$estado){
            try {
                $idsubmenu2 = $this->m_generarcodigo("IDSUBMENU2","T_SUB_MENUS");
                $query = $this->bd->prepare("INSERT INTO T_SUB_MENUS
                VALUES('$idmenu','','','','$idsubmenu','$idsubmenu2','$nombre','$url','','$estado')");
               /* print_r($query);*/
                $guardarmenu = $query->execute();
                return $guardarmenu;
            } catch (Exception $e) {
                print_r("Error al guardar submenu2" . $e);
            } 
        }

        public function m_generarcodigo($campo,$tabla)
        {
            try {
                $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
                $query->execute();
                $results = $query->fetch();
                if($results[0] == NULL) $results[0] = '1';
                $res = str_pad($results[0], 3, '0', STR_PAD_LEFT);
                return $res;
            } catch (Exception $e) {
                print_r("Error en la consulta generar codigo".$e);
            }
        }  

    }

?>