<?php
require_once("../funciones/Database.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_regalos
{
    private $bd;
    public function __construct() {
        $this->bd=DataBase::Conectar();
    }

    public function m_buscar($zona)
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM V_BUSCAR_PRODUCTO WHERE ZONA = '$zona'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        }
    }

    public function m_evaluacion($cod_producto)
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM T_REGALOS WHERE COD_PRODUCTO = '$cod_producto'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta evaluacion". $e);
        }
    }


}

?>