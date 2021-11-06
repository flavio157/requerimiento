<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_kardex
{
    private $bd;
    public function __construct() {
        $this->bd=DataBasePlasticos::Conectar();
    }

    public function m_buscar($tabla,$dato)
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
           
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta listar".$e);
        }
    }

    public function m_lstcompra($vista,$dato){
        try {
            $query = $this->bd->prepare("SELECT * FROM $vista WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la vista kardex".$e);
        }
    }

   
}

?>