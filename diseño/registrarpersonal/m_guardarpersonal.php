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
            print_r("Error en la consulta listar ". $e);
        }
       
    }


    public function m_guardarpersonal($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
    ,$distrito,$telefono,$celular,$usuario,$fechaingreso,$estado)
    {
      try {
         $fechaingreso = retunrFechaSqlphp($fechaingreso);
         $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          $query = $this->bd->prepare("INSERT INTO T_PERSONAL(COD_PERSONAL,NOM_PERSONAL1,DIR_PERSONAL,DNI_PERSONAL,COD_CARGO,
          SAL_BASICO,COD_AREA,COD_DEPARTAMENTO,COD_PROVINCIA,COD_DISTRITO,TEL_PERSONAL,CEL_PERSONAL,EST_PERSONAL,
          FEC_INGRESO,USU_REGISTRO,FEC_REGISTRO) VALUES('$codpersonal','$nombre','$direccion','$dni','$cargo','$salario','$area',
          '$departamento','$provincia','$distrito',$telefono,$celular,'$estado','$fechaingreso','$usuario','$fech_registro')");
          $personal =  $query->execute();
          $repuesta = array($personal,$codpersonal);
          return $repuesta;
      } catch (Exception $e) {
            $repuesta = array("-1","Error al registrar nuevo personal ".$e);
            return $repuesta;
      }
    }
    
    public function m_generar_codpers($campo,$tabla)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 5, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  

    public function m_listarpersonal(){
        try {
            $query = $this->bd->prepare("SELECT * FROM T_PERSONAL");
            $query->execute();
            $results = $query->fetchAll();
            return $results;
        } catch (Exception $e) {
            print_r("Error en listar personal".$e);
        }
    }


    public function m_actualizarpers($codpersonal,$nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
    ,$distrito,$telefono,$celular,$usuario,$fechaingreso, $estado)
    {
      try {
          $fechaingreso = retunrFechaSqlphp($fechaingreso);
          $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
          $query = $this->bd->prepare("UPDATE T_PERSONAL SET COD_AREA = '$area',
          COD_CARGO = '$cargo',DNI_PERSONAL ='$dni',NOM_PERSONAL1 = '$nombre',SAL_BASICO = '$salario',
          DIR_PERSONAL = '$direccion',COD_DEPARTAMENTO = '$departamento', COD_PROVINCIA = '$provincia',
          COD_DISTRITO = '$distrito',TEL_PERSONAL = '$telefono',CEL_PERSONAL = '$celular',
          EST_PERSONAL = '$estado',FEC_INGRESO = '$fechaingreso',USU_MODIFICO = '$usuario',
          FEC_MODIFICO = '$fech_registro'
          WHERE COD_PERSONAL = '$codpersonal'");
          $personal =  $query->execute();
          return $personal;
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          print_r($codpersonal);
      } catch (Exception $e) {
          print_r("Error al registrar nuevo personal ".$e);
      }
    }

}

?>