<?php
require_once("../db/Contrato.php");
class M_Login
{
    
    private $db;
    
    
    public function __construct($basedatos)
    {
        $this->db=ClassContrato::Contrato($basedatos);
    }
    
    public function Login($cod_vendedor,$estado)
    {

        $query=$this->db->prepare("SELECT * FROM T_PERSONAL WHERE COD_PERSONAL = :cod_personal
                                  and EST_PERSONAL != :estado");
            $query->bindParam("cod_personal", $cod_vendedor, PDO::PARAM_STR);
            $query->bindParam("estado", $estado, PDO::PARAM_STR);
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
            return $cod_usuario;
            $query->closeCursor();
            $query = null;
            }
    }


    public function PasadoQuincena($cod_vendedor,$estado)
    {
        $hoy = getdate();
        $mes = $hoy['mon'];
        $ano = $hoy['year'];
        $m = intval($mes) - intval(1); 

        
        /* primer if se cuenta la quincena del 27 al 11  pero como el mensaje sale durante de tres dias
        es decir desde el 12 al 15 se verifica cuanto a echo desde el 27 hasta el dia actual
        que es menor o igual a 15*/
        if($hoy['mday'] >= '12' && $hoy['mday'] <= '16'){
           
           $quincenas = '27'.'/'. $m .'/'.$ano;
           $fechaActual = $hoy['mday'].'/'.$mes.'/'.$ano;
          
        }else if ($hoy['mday'] >= '27' && $hoy['mday']<='30'){
            /*este if se cuenta la quincena del 12 al 26 pero como el mensaje sale durante de tres dias 
            es decir desde el 27 al 30 se verifica cuanto a echo desde el 12 hasta el dia actual 
            que es menor o igual a 30*/
            $quincenas = '12'.'/' . $mes .'/'.$ano;
            $fechaActual = $hoy['mday'].'/'.$mes.'/'.$ano;

        }

        $query=$this->db->prepare("SELECT p.COD_VENDEDORA, p.NUM_CONTRATO , 
                                p.CODIGO ,p.FECHA, pc.CANTIDAD FROM T_PPEDIDO as p
                                LEFT JOIN T_PPEDIDO_CANTIDAD pc
                                ON pc.CODIGO = p.CODIGO 
                                WHERE p.COD_VENDEDORA = :cod_vendedor AND 
                                p.Fecha >= :fechaquincena AND p.Fecha <= :fechaActual
                                AND EST_PEDIDO != :estado");
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