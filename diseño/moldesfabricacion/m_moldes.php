<?php
    date_default_timezone_set('America/Lima');
    require_once("../funciones/DataBasePlasticos.php");
    require_once("../funciones/f_funcion.php");
    require_once("../funciones/cod_almacenes.php");
    class m_moldes 
    {
        private $bd;
        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }   

        public function m_buscar($tabla,$dato)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
                //print_r($query);
                $query->execute();
                $datos = $query->fetchAll();
                return $datos;  
            } catch (Exception $e) {
                print_r("Error en la consulta buscar" . $e);
            }
           
        }

        public function m_finfabricion($molde,$fabricacion,$usuario)
        {
            try {
                $fech_fin = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("UPDATE T_FABRICACION SET USU_REGI_FIN = '$usuario', 
                FEC_FIN = '$fech_fin',FAB_TERMINO = '1'
                WHERE COD_FABRICACION = '$fabricacion' AND ID_MOLDE = '$molde'");
                $resultado = $query->execute();
                return $resultado;
            }catch(Exception $e){
                print_r("Error al poner terminar la fabricacion ".$e);
            }
        }

       
    }
?>