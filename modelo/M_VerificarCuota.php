<?php
date_default_timezone_set('America/Lima');
require_once("../db/Contrato.php");
require_once("../controlador/C_Funciones.php");
class M_VerificarCuota
{
    private $db;
    
    public function __construct($basedatos)
    {
        $this->db=ClassContrato::Contrato($basedatos);
    }

    public function VerificandoQuincena($cod_vendedor,$diasprimeraquincena,$diassegundaquincena)
    {  
        $fechas = fechas($diasprimeraquincena,$diassegundaquincena);
        $separarFechas = explode(" ",$fechas);

         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR = :cod_vendedor and
         FECHA >= :fecha_inicial and FECHA < :fecha_final");
         $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
         $query->bindParam("fecha_inicial", $separarFechas[0], PDO::PARAM_STR);
         $query->bindParam("fecha_final", $separarFechas[1], PDO::PARAM_STR);
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
         
       if($query){
             /*  return $separarFechas[0] ." ".$separarFechas[1];*/
          return $montoTotal; 
            $query->closeCursor();
            $query = null;
        } 
    }


}

?>
