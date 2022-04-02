<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_proveedor
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

    public function m_generar_codpers($campo,$tabla,$canitdad)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], $canitdad, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  

    public function m_guardar_proeveedor($proveedor,$direccion,$ruc,$dni,$telefono,$celular,$estado,$usu){
        try {
            $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
            $cod_proveedor = $this->m_generar_codpers('COD_PROVEEDOR','T_PROVEEDOR',5);
            $query = $this->bd->prepare("INSERT INTO T_PROVEEDOR(COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR
            ,RUC_PROVEEDOR,DNI_PROVEEDOR,TEL_PROVEEDOR,CEL_PROVEEDOR,EST_PROVEEDOR,USU_REGISTRO,FEC_REGISTRO)
            VALUES('$cod_proveedor','$proveedor','$direccion','$ruc','$dni','$telefono','$celular'
                    ,'$estado','$usu','$fech_registro')");
            $resul = $query->execute();
            return $resul;
        } catch (Exception $e) {
            print_r("Error al guardar nuevo proveedor" . $e);
        }
    }
    
}

?>