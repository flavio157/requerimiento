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
        $hoy = getdate();
        $mes = $hoy['mon'];
        $ano = $hoy['year'];
        $m = intval($mes) - intval(1); 
        /* el mensaje sale a los tres dias de iniciar la quincena (estos dias pueden variar)
        a partir del 15 para el primero*/
        if($hoy['mday'] >= '12' && $hoy['mday'] <= '27'){
           
            if($hoy['mday']>= '15' && $hoy['mday']<='27'){
                $fechainicial = '12'.'/'. $mes .'/'.$ano;
                $fechafinal = $hoy['mday'].'/'.$mes.'/'.$ano;
            }
          
        }else if ($hoy['mday'] >= '27' && $hoy['mday']<='12'){
            if($hoy['mday']>= '30' && $hoy['mday']<='12'){
                $fechainicial = '27'.'/' . $m .'/'.$ano;
                $fechafinal = $hoy['mday'].'/'.$mes.'/'.$ano;
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
