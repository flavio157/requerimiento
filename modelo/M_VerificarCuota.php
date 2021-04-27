<?php
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
                $fechainicial = '12'.'/'. $mes .'/'.$ano;
                $fechafinal =  $dia;
            }
          
            if($fecha['mday']>= '30' && $fecha['mday']<='12'){
                if($fecha['mday'] == '30' || $fecha['mday'] == '31'){
                    $fechainicial = '27'.'/' . $mes .'/'.$ano;
                    $fechafinal = $dia;
                }else{
                    $fechainicial = '27'.'/' . $m .'/'.$ano;
                    $fechafinal =  $dia;
                }
                
            }

         $query=$this->db->prepare("{CALL P_PEDIDO_MONTO(?,?,?)}");
         $query->bindParam(1, $cod_vendedor, PDO::PARAM_STR);
         $query->bindParam(2, $fechainicial, PDO::PARAM_STR);
         $query->bindParam(3, $fechafinal, PDO::PARAM_STR);
         $query->execute();
         $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
       if($query){
            return $cod_usuario;
            $query->closeCursor();
            $query = null;
        } 
    }











/*desabilita al usuario actualizando el estado en A */
    public function M_ActualizarEstadoUsuario($cod_personal,$estadoPersona){
        $query=$this->db->prepare("UPDATE T_PERSONAL SET EST_PERSONAL =:est_personal WHERE
        COD_PERSONAL =:cod_persona");
        $query->bindParam("cod_persona",$cod_personal,PDO::PARAM_STR);
        $query->bindParam("est_personal",$estadoPersona,PDO::PARAM_STR);
        $query->execute();
        $actualuzarUsu = $query;
        if($query){
            return $actualuzarUsu;
            $query->closeCursor();
            $query = null;
        }
    }
}

?>
