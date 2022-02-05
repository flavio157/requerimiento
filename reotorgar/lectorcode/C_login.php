<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/M_Login.php");
require_once("../Funciones/f_funcion.php");


   $cod_usuario = $_POST['usuario'];
 
   
    if ($cod_usuario!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);
    }else{
        return header("Location:  ../index.php");
    }


class C_Login
{
    public function C_usuario($cod_usuario){   
        //$m_login = new M_Login();
        //$datosUsuario = $m_login->Login($cod_usuario);
        

        //if($datosUsuario){
            return header("Location: index.php");
          // }else{
           // return header("Location: ../index.php");
           //print_r("USTED NO TIENE PERMISO");
       // }
    }

}

?>