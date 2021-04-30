<?php
date_default_timezone_set('America/Lima');
require_once("../modelo/M_VerificarCuota.php");
require_once("../modelo/M_Login.php");
session_start();

   $cod_usuario = $_POST['usuario'];
 
   
    if ($cod_usuario!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);

    }else{
        return header("Location: http://localhost:8080/requerimiento/vista/");
    }
class C_Login
{
    public function C_usuario($cod_usuario)
    {   $montoSMP = 700;
        $diasprimeraquincena =array("15","26");
        $diassegundaquincena =array("01","11");
        
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);

       if($datosUsuario){
        if(trim($datosUsuario['OFICINA']) == "SMP2"){
            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
            $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$diasprimeraquincena,$diassegundaquincena);
        }else{
           $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$diassegundaquincena,$diassegundaquincena);
        }
        /* print_r($montoTotal);*/
        f_Cuotas($montoTotal,$montoSMP, $diasprimeraquincena,$diassegundaquincena);

       }else{
            return header("Location: http://localhost:8080/requerimiento/vista/");
        }

    }
  
}

?>