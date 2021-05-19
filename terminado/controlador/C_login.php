<?php
date_default_timezone_set('America/Lima');
require_once("../modelo/M_VerificarCuota.php");
require_once("../modelo/M_Login.php");
require_once("../funciones/f_funcion.php");


   $cod_usuario = $_POST['usuario'];
 
   
    if ($cod_usuario!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);
    }else{
        return header("Location: http://localhost:8080/terminado/vista/");
    }


class C_Login
{
    public function C_usuario($cod_usuario){   
        

        $diasprimeraquincena =array("14","26");
        $diassegundaquincena =array("29","11");
        
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);
       

        $m_cuotaPersonal = new M_VerificarCuota($datosUsuario['OFICINA']);
        $montoSMP = $m_cuotaPersonal->CuotaPersonal($cod_usuario);

       if($datosUsuario){
        return header("Location: http://localhost:8080/terminado/vista/ventana.php");
       }else{
         return header("Location: http://localhost:8080/terminado/vista/");
        }
    }

}

?>