<?php
require_once("../db/Usuarios.php");
require_once("../controlador/C_Fechas.php");

class M_Login
{
    
    private $db;
    
    
    public function __construct()
    {
        $this->db=ClassUsuario::Usuario();
    }
    
    public function Login($cod_usuario)
    {
            $query=$this->db->prepare("SELECT * FROM V_Login WHERE COD_PERSONAL = :cod_usuario");
            $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
            return $cod_usuario;
            $query->closeCursor();
            $query = null;
            }
    }

    public function VerificarCallCenter($cod_vendedor,$diasprimeraquincena,$diassegundaquincena)
    {
        $c_fechas = new RangoFechas();
        $fechas = $c_fechas->fechas($diasprimeraquincena,$diassegundaquincena);
        $separarFechas = explode(" ",$fechas);

        $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
        WHERE VENDEDOR = :cod_vendedor AND FECHA_GENERADO >= :fechaInical 
        AND FECHA_GENERADO < :fechaFinal");
        $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("fechaInical", $separarFechas[0], PDO::PARAM_STR);
        $query->bindParam("fechaFinal",  $separarFechas[1], PDO::PARAM_STR);
        $query->execute();
        $montoTotal=0;
        
        while ($result = $query->fetch()) {
            if($result['MONTO'] != ""){
               $montoTotal += $result['MONTO'];
            }
        }
            
       if($query){
            /* return $separarFechas[0] .'  '. $separarFechas[1];*/
           return $montoTotal;
            $query->closeCursor();
            $query = null;
        } 
    }


    /*desabilita al usuario actualizando el estado en A */
    public function M_ActualizarEstadoUsuario($cod_personal,$estadoPersona){
        $query=$this->db->prepare("UPDATE V_ActCodVendedor SET EST_USUARIO =:est_usuario WHERE
        COD_USUARIO =:cod_usuario");
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
