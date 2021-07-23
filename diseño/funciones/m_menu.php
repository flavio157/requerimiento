<?php
    require_once("../funciones/DataBase.php"); 

    class m_menu 
    {
        public function __construct()
        {
            $this->db=DataBase::Conectar();
        }
            
      
    }
    
    

?>