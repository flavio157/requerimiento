<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_guias
{
    private $bd;
    public function __construct() {
        $this->bd=DataBasePlasticos::Conectar();
    }

    public function m_buscar($tabla,$dato)
    {
        try {
           
           $query = $this->bd->prepare("SELECT * FROM V_REPORTE_GUIAS WHERE COD_COMPROBANTE = '$dato'");

            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }

    public function m_lstrecibos(){
        try {
            $query = $this->bd->prepare("SELECT * FROM T_COMPROBANTE");
            $query->execute();
            $dato = $query->fetchAll();
            return $dato;
        } catch (Exception $e) {
            print_r("Error en la consulta listar ".$e);
        }
    }


}

?>