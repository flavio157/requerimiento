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
        
        $hoy = getdate();
        $mes = $hoy['mon'];
        $ano = $hoy['year'];
        $m = intval($mes) - intval(1); 
        /* el mensaje sale a los tres dias de iniciar la quincena (estos dias pueden variar)
        a partir del 15 para el primero*/
        if($hoy['mday'] >= '12' && $hoy['mday'] <= '27'){
           
            if($hoy['mday']>= '15' && $hoy['mday']<='27'){
                $fechainicial = '12'.'/'. $mes .'/'.$ano;
                $fechafinal = $hoy['mday'].'/'.$mes.'/'.$ano;
            }
          
        }else if ($hoy['mday'] >= '27' && $hoy['mday']<='12'){

            if($hoy['mday']>= '30' && $hoy['mday']<='12'){
                $fechainicial = '27'.'/' . $m .'/'.$ano;
                $fechafinal = $hoy['mday'].'/'.$mes.'/'.$ano;
            }
        }

        $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE COD_VENDEDORA = :cod_vendedora AND
        FECHA >= :fechaincial AND FECHA <= :fechafinal");
         $query->bindParam("cod_vendedora", $cod_vendedor, PDO::PARAM_STR);
         $query->bindParam("fechaincial", $fechainicial, PDO::PARAM_STR);
         $query->bindParam("fechafinal", $fechafinal, PDO::PARAM_STR);
         $query->execute();
         $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
       if($query){
            return $cod_usuario;
            $query->closeCursor();
            $query = null;
        } 
    }
}