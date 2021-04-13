<?php

class M_Login
{
    private $db;
    private $Usuario;
    
    public function __construct()
    {
        $this->db=ClassConexion::conexion();
    }
    
    public function get_usuario($usu,$pass)
    {
        $query=$this->db->query("SELECT * FROM $this->table where usuario=");
        if(!$query){
            echo '<p class="error">Username password combination is wrong!</p>';
        }else{
            if (password_verify($pass, $query['pass el campo del array'])) {
                $_SESSION['user_id'] = $query['ID el campo del array'];
               /* echo '<p class="success">Congratulations, you are logged in!</p>';*/
            } else {
                echo "error";
            } 
        }
           /* if($row = $query->fetchObject()) {
                $resultSet=$row;
            }
            return $resultSet;*/
    }

}

?>