<?php
require_once("../db/Contrato.php");
class M_Login
{
    private $db;
    
    public function __construct()
    {
        $this->db=ClassContrato::Contrato();
    }
    
    public function get_usuario($usu,$estado)
    {
        
        $query=$this->db->prepare("SELECT * FROM T_ClIENTE where COD_CLIENTE=:username  and EST_CLIENTE!=:estado");
        $query->bindParam("username", $usu, PDO::PARAM_STR);
        $query->bindParam("estado", $estado, PDO::PARAM_STR);
        $query->execute();
        $datosUsuario = $query->fetch(PDO::FETCH_ASSOC);
       
        if($query){
            $_SESSION['user_id'] = $datosUsuario['NOM_CLIENTE1'];
            return $datosUsuario;
            $query->closeCursor();
            $query = null;
        }
        
    }


    

    public function M_Cuotas($cod_cliente){  
        $query = $this->db->prepare("SELECT * FROM T_PPEDIDO as pd 
        left join T_PPEDIDO_CANTIDAD as pc
        on pd.CODIGO = pc.CODIGO
        where pd.COD_CLIENTE = :cod_cliente and EST_PEDIDO != 'A' and
        pd.FEC_DESPACHO = (SELECT MAX(FEC_DESPACHO) FROM T_PPEDIDO)"); 
    
        $query->bindParam("cod_cliente", $cod_cliente, PDO::PARAM_STR);
        $query->execute();
        $datosCuotas = $query->fetch(PDO::FETCH_ASSOC);

        if($query){
            return $datosCuotas;
            $query->closeCursor();
            $query = null;
        }
    }




/*desabilita al usuario actualizando el estado en A */
    public function M_ActualizarEstadoUsuario($Cod_cliente,$estadoUsu){
        $query=$this->db->prepare("UPDATE T_ClIENTE set EST_CLIENTE =:est_usuario where
        COD_PERSONAL =:cod_persona");
        $query->bindParam("cod_persona",$Cod_cliente,PDO::PARAM_STR);
        $query->bindParam("est_usuario",$estadoUsu,PDO::PARAM_STR);
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

