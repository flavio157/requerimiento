<?php
    require_once("../funciones/Database.php");
    require_once("../funciones/f_funcion.php");
    class m_comentarios 
    {
        private $bd;
        
        public function __construct()
        {
            $this->bd=DataBase::Conectar();
        }
        
        public function m_lstcomentario($fecha)
        {
           try {
                $query = $this->bd->prepare("SELECT * FROM T_COMENTARIOS_FURGON
                where CAST(FEC_REGISTRO as date) = '$fecha' AND ESTADO = NULL");
                $query->execute();
                return $query->fetchAll();
           } catch (Exception $e) {
               print_r("Error al listar comentario por fecha ". $e);
           }
        }  

        public function m_actualizarestado($fecha,$id){
            try {
                $query = $this->bd->prepare("UPDATE T_COMENTARIOS_FURGON
                SET ESTADO = '1', FEC_VERIFICO = '$fecha' WHERE ID = '$id'");
                $query->execute();
               
           } catch (Exception $e) {
               print_r("Error al listar datos ". $e);
           }
        }

        public function m_lstcomentariofalta(){
            try {
                $query = $this->bd->prepare("SELECT * FROM V_VERIFICAR_COMENTARIOS");
                $query->execute();
                return $query->fetchAll();
           } catch (Exception $e) {
               print_r("Error al listar comentario por fecha ". $e);
           }
        }
    }
    


?>