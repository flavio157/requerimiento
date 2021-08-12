<?php
    require_once("../funciones/DataBase.php"); 

    class m_guardar_permisos 
    {
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }
            
        public function m_consultar_permisos($anexo){
                
        }

        public function m_guardar_permisos(){
            $query = "INSERT INTO T_PERMISOS values()";

        }

        public function m_actualizar_permisos(){

        }

      
       
      
    }
    
    

?>