<?php
date_default_timezone_set('America/Lima');
require_once("../db/Contrato.php");
require_once("../controlador/f_funcion.php");
class M_VerificarCuota
{
    private $db;
    
    public function __construct($basedatos)
    {
        $this->db=ClassContrato::Contrato($basedatos);
    }

    public function VerificandoQuincena($cod_vendedor,$diasprimeraquincena,$diassegundaquincena,$fec_ingreso)
    {  
        $fechas = fechas($diasprimeraquincena,$diassegundaquincena,$fec_ingreso);
        if(!is_string($fechas[0])){
            $fech1 = $fechas[0]->format('d-m-y');
            $fech2 = $fechas[1];
            $bool = $fechas[2];
            
        }else{
            $fech1 = $fechas[0];
            $fech2 = $fechas[1];
            $bool = true;
        }
        
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
         
       if($query){
            /*   return  $fechas[0] ." ".$fechas[1]; */
            return array($montoTotal,$bool);
            $query->closeCursor();
            $query = null;
        } 
    }

}

?>
