<?php
require_once("../db/Usuarios.php");
require_once("../controlador/f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=ClassUsuario::Usuario();
    }
    
    public function Login($cod_usuario)
    {
            $query=$this->db->prepare("SELECT * FROM V_LOGIN WHERE COD_PERSONAL = :cod_usuario");
            $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            f_regSession($cod_usuario['ANEXO_USUARIO'],$cod_usuario['COD_PERSONAL'],$cod_usuario['NOM_USUARIO'],$cod_usuario['OFICINA'],$cod_usuario['ZONA']);
            if($query){
                return  $cod_usuario;
                $query->closeCursor();
                $query = null;
            }
    }


    public function CuotaPersonal($cod_usuario){
        $query=$this->db->prepare("SELECT * FROM V_VERIFICAR_CUOTAPERSONAL WHERE COD_PERSONAL = :cod_usuario");
        $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
        $query->execute();
        $d_usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $d_usuario;
    }




    public function VerificarCallCenter($cod_vendedor,$diasprimeraquincena,$diassegundaquincena,$fec_ingreso)
    {
        
       $fechas = fechas($diasprimeraquincena,$diassegundaquincena,$fec_ingreso);
     
        if(!is_string($fechas[0])){
            $fech1 = $fechas[0];
            $fech2 = $fechas[1];
            $bool = $fechas[2];
            
        }else{
            $fech1 = $fechas[0];
            $fech2 = $fechas[1];
            $bool = true;
        }


      
       
       $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
        WHERE VENDEDOR = :cod_vendedor AND FECHA_GENERADO >= :fechaInical 
        AND FECHA_GENERADO < :fechaFinal");
        $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("fechaInical", $fech1, PDO::PARAM_STR);
        $query->bindParam("fechaFinal",  $fech2, PDO::PARAM_STR);
        $query->execute();
        $montoTotal=0;
        
        while ($result = $query->fetch()) {
            if($result['MONTO'] != ""){
               $montoTotal += $result['MONTO'];
            }
        }
            
       if($query){
            return array($montoTotal, $bool);
            $query->closeCursor();
            $query = null;
        } 
    }
}
?>
