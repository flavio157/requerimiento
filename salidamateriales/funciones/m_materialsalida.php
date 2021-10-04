<?php
require_once("DataBase.php");
    class m_materiasalida 
    {
        private $bd;

        public function __construct()
        {
            $this->bd=DataBase::Conectar();
        }

        public function m_buscarlike($tabla,$columna1,$columna2,$columna3,$estado,$dato,$categoria){
            $query = $this->bd->prepare("SELECT * FROM $tabla where $columna1 = '$estado' AND
            $columna2 LIKE '%$dato%' AND $columna3 = '$categoria'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }

        public function m_buscar($dato,$tabla,$columna)
        {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $columna = '$dato'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }

        public function m_guardar($tabla,$codsalida,$numdoc,$perso,$usureg,$fecregs,$des)
        {
            $query = $this->bd->prepare("INSERT INTO $tabla values($codsalida,$numdoc,$perso,$usureg,$fecregs,$des)");
            $query->execute();
        }


    }


?>