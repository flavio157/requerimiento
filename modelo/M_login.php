<?php
require_once("../db/Usuarios.php");
require_once("../controlador/C_Funciones.php");

class M_Login
{
    
    private $db;
    
    
    public function __construct()
    {
        $this->db=ClassUsuario::Usuario();
    }
    
    public function Login($cod_usuario)
    {
        session_start();
            $query=$this->db->prepare("SELECT * FROM V_Login WHERE COD_PERSONAL = :cod_usuario");
            $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION['zona']= $cod_usuario['ZONA'];
            if($query){
                return $cod_usuario;
                $query->closeCursor();
                $query = null;
            }
    }

    public function VerificarCallCenter($cod_vendedor,$diasprimeraquincena,$diassegundaquincena)
    {
        
        $fechas = fechas($diasprimeraquincena,$diassegundaquincena);
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
           /*  return $separarFechas[0] .'  '. $separarFechas[1];*/
           return $montoTotal;
            $query->closeCursor();
            $query = null;
        } 
    }
}
?>
