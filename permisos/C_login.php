<?php
date_default_timezone_set('America/Lima');
require_once("M_Login.php");
require_once("funciones/f_funcion.php");


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
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);
        

        if($datosUsuario){
            return header("Location: permisos/index.php");
           }else{
           print_r("USTED NO TIENE PERMISO");
        }
    }

}

?>