<?php
require_once("../db/Contrato.php");
class M_Login
{
    
    private $db;
    
    
    public function __construct($basedatos)
    {
        $this->db=ClassContrato::Contrato($basedatos);
    }
    
    public function M_Login($cod_vendedor,$estado)
    {
        $hoy = getdate();
        $mes = $hoy['mon'];
        $ano = $hoy['year'];
        $fechaActual = $hoy['mday'].'/'.$mes.'/'.$ano;

        if($hoy['mday'] >= '12' && $hoy['mday']<='26'){

           $quincenas = '12'.'/'.$mes.'/'.$ano;

        }else if ($hoy['mday'] >= '27' && $hoy['mday']<='11'){

            $quincenas = '27'.'/'.$mes.'/'.$ano;
        }

        $query=$this->db->prepare("SELECT p.COD_VENDEDORA, p.NUM_CONTRATO , 
                                p.CODIGO ,p.FECHA, pc.CANTIDAD from T_PPEDIDO as p
                                left join T_PPEDIDO_CANTIDAD pc
                                on pc.CODIGO = p.CODIGO 
                                where p.COD_VENDEDORA = :cod_vendedor and 
                                p.Fecha >= :fechaquincena and p.Fecha <= :fechaActual
                                and EST_PEDIDO != :estado");
        $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("fechaquincena", $quincenas, PDO::PARAM_STR);
        $query->bindParam("fechaActual", $fechaActual, PDO::PARAM_STR);
        $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("estado", $estado, PDO::PARAM_STR);
        $query->execute();
       
        if($query){
            return $query;
            $query->closeCursor();
            $query = null;
        }
        
    }



/*desabilita al usuario actualizando el estado en A */
    public function M_ActualizarEstadoUsuario($cod_personal,$estadoPersona){
        $query=$this->db->prepare("UPDATE T_PERSONAL set EST_PERSONAL =:est_personal where
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

