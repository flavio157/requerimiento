<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_guardarpersonal
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


    public function m_guardarpersonal($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
    ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso)
    {
      try {
         $fechaingreso = retunrFechaSqlphp($fechaingreso);
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          $query = $this->bd->prepare("INSERT INTO T_PERSONAL(COD_PERSONAL,NOM_PERSONAL1,DIR_PERSONAL,DNI_PERSONAL,COD_CARGO,
          SAL_BASICO,COD_AREA,COD_DEPARTAMENTO,COD_PROVINCIA,COD_DISTRITO,TEL_PERSONAL,CEL_PERSONAL,EST_PERSONAL,
          FEC_INGRESO,USU_REGISTRO,N_CUENTA,TITULAR) VALUES('$codpersonal','$nombre','$direccion','$dni','$cargo','$salario','$area',
          '$departamento','$provincia','$distrito',$telefono,$celular,'A','$fechaingreso','$usuario','$cuenta','$titular')");
          $personal =  $query->execute();
          return $personal;
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          print_r($codpersonal);
      } catch (Exception $e) {
          print_r("Error al registrar nuevo personal ".$e);
      }
    }

    public function m_generar_codpers($campo,$tabla)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 4, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  


}

?>