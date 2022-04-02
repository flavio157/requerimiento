<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_kardesenvaces
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

    public function m_ingreso($codpro){
        try {
            $query = $this->bd->prepare("SELECT TOP 1 * from V_KARDEX_ENVACE WHERE codigo ='$codpro'
            ORDER BY fecha ASC");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta ingreso".$e);
        }
    }

    public function m_kardex_confecha($fecini,$fecfin,$id)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX(codigo),MAX(DES_PRODUCTO),SUM(CAN_PRODUCCION),
            MAX(CONVERT(date,fecha)),MAX(almacen),MAX(ingreso),
            MAX(cod_alma)
            FROM V_KARDEX_ENVACE
            WHERE
            CAST(fecha as date) >= '$fecini' AND CAST(fecha as date) <= '$fecfin' AND codigo = '$id'
            group by CONVERT(date,fecha),codigo,cod_alma,ingreso
            order by MAX(fecha) asc");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error al generar lista de kardex con fecha" . $e);
        }
    }

    public function m_kardex_sinfecha($id){
        try {
            $query = $this->bd->prepare("SELECT MAX(codigo),MAX(DES_PRODUCTO),SUM(CAN_PRODUCCION),
            MAX(CONVERT(date,fecha)),MAX(almacen),MAX(ingreso),
            MAX(cod_alma)
            FROM V_KARDEX_ENVACE
            WHERE codigo = '$id'
            group by CONVERT(date,fecha),codigo,cod_alma,ingreso
            order by MAX(fecha) asc");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }catch (Exception $e) {
            print_r("Error al generar lista de kardex sin fecha ".$e);
        }
    }


}

?>