<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataDinamica.php");
require_once("../funciones/f_funcion.php");
class M_VerificarCuota
{
    private $db;
    
    public function __construct($basedatos)
    {
        $this->db=DataDinamica::Contrato($basedatos);
    }

    public function VerificandoQuincena($cod_vendedor,$dias,$fec_ingreso)
    {  
        
        $fec = explode(" ",$fec_ingreso);
        $fechas = nuevfech($dias,$fec[0]);
        if(!is_string($fechas[0])){
            $fech1 = $fechas[0];
        }else{
            $fech1 = $fechas[0];
        }
        $fech2 = $fechas[1];
        $dias =  $fechas[2];
        
         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR = :cod_vendedor and
         FECHA >= :fecha_inicial and FECHA < :fecha_final");
         $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
         $query->bindParam("fecha_inicial", $fech1, PDO::PARAM_STR);
         $query->bindParam("fecha_final", $fech2, PDO::PARAM_STR);
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
        $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / $dias,2) : 0;

        $arraydato = array($fech1,$promedio); 
      if($query){
          return $arraydato;
       } 
    }

    public function CuotaPersonal($cod_usuario){
        try {
            $query=$this->db->prepare("SELECT * FROM V_VERIFICAR_CUOTAPERSONAL WHERE COD_PERSONAL = :cod_usuario");
            $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
            $query->execute();
            $d_usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $d_usuario;
        } catch (Throwable $th) {
            print_r("El codigo de usuario no esxiste");
        }
       
    }

}

?>
