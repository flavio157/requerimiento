<?php
date_default_timezone_set('America/Lima');
require_once("m_login.php");
require_once("./menu/c_permisosmenu.php");


   $cod_usuario = $_POST['usuario'];
   $clave = $_POST['clave']; 
   
    if ($cod_usuario!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario,$clave);
    }else{
        return header("Location:  ../index.php");
    }


class C_Login
{
    public function C_usuario($cod_usuario,$clave){   
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario,$clave);
       
        if($datosUsuario){
           $m_login = new c_permisosmenu();
           $datosUsuario = $m_login->c_permisos('9002');
          // $datosUsuario = $m_login->c_permisos($datosUsuario[3]);
        }else{
           print_r("USTED NO TIENE PERMISO");
        }
    }

}