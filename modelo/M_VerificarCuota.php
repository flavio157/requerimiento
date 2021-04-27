<?php
date_default_timezone_set('America/Lima');
require_once("../db/Contrato.php");
class M_VerificarCuota
{
    
    private $db;
    
    
    public function __construct($basedatos)
    {
        $this->db=ClassContrato::Contrato($basedatos);
       
    }

    public function VerificandoQuincena($cod_vendedor)
    {
        $fecha_actual = date("d-m-Y");
        $fecha = getdate();
        $dia = date("d-m-Y",strtotime($fecha_actual."- 1 days"));
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $m = intval($mes) - intval(1); 

            if($fecha['mday']>= '15' && $fecha['mday'] <='27'){
                if($mes <= '9'){
                    $mes = '0'.$mes;
                }
                $fechainicial = '12'.'/'. $mes .'/'.$ano;
                $fechafinal =  $dia;
            }
           

            if($fecha['mday'] >= '01' && $fecha['mday']<='12'){
                    $fechainicial = '27'.'/' . $m .'/'.$ano;
                    $fechafinal =  $dia;
            }

         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR = :cod_vendedor and
         FECHA >= :fecha_inicial and FECHA < :fecha_final");
         $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
         $query->bindParam("fecha_inicial", $fechainicial, PDO::PARAM_STR);
         $query->bindParam("fecha_final", $fechafinal, PDO::PARAM_STR);
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
         
       if($query){
            return $fechainicial . $fechafinal ;
            $query->closeCursor();
            $query = null;
        } 
    }

}

?>

