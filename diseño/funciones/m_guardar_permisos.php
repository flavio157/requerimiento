<?php
    require_once("../funciones/DataBase.php"); 

    class m_guardar_permisos 
    {
        public function __construct()
        {
            $this->bd=DataBase::Conectar();
        }
            
        public function m_consultar_permisos($anexo){
            $query = $this->bd->prepare("SELECT * FROM T_PERMISOS WHERE ANEXO = '$anexo'");
            $query->execute();
            $permisos = $query->fetchAll();
            return  $permisos;
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
        
    }

?>