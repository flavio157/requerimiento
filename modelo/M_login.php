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
       
        if($query){
            $_SESSION['user_id'] = $datosUsuario['COD_PERSONAL'];
            return $datosUsuario;
            $query->closeCursor();
            $query = null;
        }
        
    }

    public function M_Cuotas($cod_personal,$oficina,$zona){
  
        $query=$this->db->prepare("SELECT * FROM T_CALL_CENTER WHERE COD_PERSONAL=:username 
        and OFICINA =:oficinas and COD_ZONA =:zonas 
        and FEC_REGISTRO = ".'('."SELECT MAX(FEC_REGISTRO) FROM T_CALL_CENTER".')'."");
        $query->bindParam("username", $cod_personal, PDO::PARAM_STR);
        $query->bindParam("oficinas", $oficina, PDO::PARAM_STR);
        $query->bindParam("zonas", $zona, PDO::PARAM_STR);
        $query->execute();
        $datosCuotas = $query->fetch(PDO::FETCH_ASSOC);

        if($query){
            return $datosCuotas;
            $query->closeCursor();
            $query = null;
        }

    }


    public function M_ActualizarEstadoUsuario($NombreUsu,$oficiona,$zona,$estadoUsu){
       
       
        $query=$this->db->prepare("UPDATE T_USUARIO_CALL set EST_USUARIO =:est_usuario where
        COD_PERSONAL =:cod_persona and  OFICINA =:oficina and ZONA =:zona");
        $query->bindParam("cod_persona",$NombreUsu,PDO::PARAM_STR);
        $query->bindParam("oficina",$oficiona,PDO::PARAM_STR);
        $query->bindParam("zona",$zona,PDO::PARAM_STR);
        $query->bindParam("est_usuario",$estadoUsu,PDO::PARAM_STR);
        $query->execute();
        $actualuzarUsu = $query;
        if($query){
            return $actualuzarUsu;
            $query->closeCursor();
            $query = null;
        }
    }
    /*update T_USUARIO_CALL set EST_USUARIO = 'P' where
    COD_PERSONAL = 'admin' and  OFICINA = '0001' and ZONA = '7'*/

}

?>

