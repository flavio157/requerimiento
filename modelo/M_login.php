<?php
require_once("../db/conexion.php");
class M_Login
{
    private $db;
    
    public function __construct()
    {
        $this->db=ClassConexion::conexionAlmacenes();
    }
    
    public function get_usuario($usu,$pass,$estado)
    {
        $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL where COD_PERSONAL=:username and PDW_USUARIO=:pass and EST_USUARIO!=:est");
        $query->bindParam("username", $usu, PDO::PARAM_STR);
        $query->bindParam("pass", $pass, PDO::PARAM_STR);
        $query->bindParam("est", $estado, PDO::PARAM_STR);
        $query->execute();
        $datosUsuario = $query->fetch(PDO::FETCH_ASSOC);
       
        if(!$query){
        }else{
            $_SESSION['user_id'] = $datosUsuario['NOM_USUARIO'];
            return $datosUsuario;
        }
        
    }

    public function M_Cuotas($cod_personal,$oficina,$zona){

        $query=$this->db->prepare("SELECT * FROM T_CALL_CENTER where COD_PERSONAL=:username  and 
        OFICINA =:oficiona and COD_ZONA =:zona");
        $query->bindParam("username", $cod_personal, PDO::PARAM_STR);
        $query->bindParam("oficina", $oficina, PDO::PARAM_STR);
        $query->bindParam("zona", $zona, PDO::PARAM_STR);
        $query->execute();
        $datosCuotas = $query->fetch(PDO::FETCH_ASSOC);


      /*    SELECT *
            FROM Almacenes.T_CALL_CENTER
            WHERE COD_PERSONAL=:username and CUOTAS=:cuota and 
            OFICINA =:oficiona and COD_ZONA =:zona
            FEC_REGISTRO = (SELECT MAX(FEC_REGISTRO) FROM Almacenes.T_CALL_CENTER);*/

        if(!$query){
        }else{
          return $datosCuotas;
        }

    }

    

}

?>
