<?php
require_once("../db/Usuarios.php");

class M_Login
{
    
    private $db;
    
    
    public function __construct()
    {
        $this->db=ClassUsuario::Usuario();
    }
    
    public function Login($cod_usuario)
    {
            $query=$this->db->prepare("SELECT * FROM V_Login WHERE COD_USUARIO = :cod_usuario");
            $query->bindParam("cod_usuario", $cod_usuario, PDO::PARAM_STR);
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
            return $cod_usuario;
            $query->closeCursor();
            $query = null;
            }
    }


    
    public function VerificarCallCenter($cod_vendedor)
    {
        $fecha = getdate();
        $dia = $fecha['mday'];
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $m = intval($mes) - intval(1); 
        $d = intval($dia) - intval(1);

        if($dia['mday'] >= '12' && $dia['mday'] <= '27'){
           
            if($dia['mday']>= '15' && $dia['mday']<='27'){
                $fechainicial = '12'.'/'. $mes .'/'.$ano;
                $fechafinal = $d.'/'.$mes.'/'.$ano;
            }
          
        }else if ($dia['mday'] >= '27' && $dia['mday']<='12'){
            if($dia['mday']>= '30' && $dia['mday']<='12'){
                $fechainicial = '27'.'/' . $m .'/'.$ano;
                $fechafinal = $d.'/'.$mes.'/'.$ano;
            }
        }

        $query=$this->db->prepare("SELECT * FROM V_call_center  
        WHERE vendedor = cod_vendedor AND fecha_generado >= :fechaInical 
        AND fecha_generado <= :fechaFinal");
        $query->bindParam("cod_vendedora", $cod_vendedor, PDO::PARAM_STR);
        $query->bindParam("fechaquincena", $fechainicial, PDO::PARAM_STR);
        $query->bindParam("fechaActual", $fechafinal, PDO::PARAM_STR);
        $query->execute();
       if($query){
            return $query;
            $query->closeCursor();
            $query = null;
        } 
    }

}
?>

