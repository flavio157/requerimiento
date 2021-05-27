<?php
require_once("../Funciones/Database.php");
require_once("../Funciones/f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Usuarios();
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


  




    public function VerificarCallCenter($cod_vendedor,$dias,$fec_ingreso,$oficina)
    {
        
        $fec = explode(" ",$fec_ingreso);
        $fechas = nuevfech($dias,$fec[0]);
        if(!is_string($fechas[0])){
            $fech1 = $fechas[0];
        }else{
            $fech1 = $fechas[0];
        }
        $fech2 = $fechas[1];
        $dias =  $fechas[2];

      
       
       $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
        WHERE VENDEDOR = :cod_vendedor AND FECHA_GENERADO >= :fechaInical 
        AND FECHA_GENERADO < :fechaFinal AND OFICINA = :oficina");
        $query->bindParam("cod_vendedor", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("fechaInical", $fech1, PDO::PARAM_STR);
        $query->bindParam("fechaFinal",  $fech2, PDO::PARAM_STR);
        $query->bindParam("oficina",  $oficina, PDO::PARAM_STR);
        $query->execute();
        $montoTotal=0;
        
        while ($result = $query->fetch()) {
            if($result['MONTO'] != ""){
               $montoTotal += $result['MONTO'];
            }
        }
            
        $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / $dias,2) : 0; 
    
        $arraydato = array($fech1,$promedio); 
    
       
      if($query){
          return $oficina;
       } 
    }



}
?>
