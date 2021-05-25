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
        return header("Location: http://localhost:8080/requerimiento/vista/");
    }


class C_Login
{
    public function C_usuario($cod_usuario){   
        $dias = 2;

        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);
       

        $m_cuotaPersonal = new M_VerificarCuota($datosUsuario['OFICINA']);
        $montoSMP = $m_cuotaPersonal->CuotaPersonal($cod_usuario);
        $oficina = $datosUsuario['OFICINA'] ;
       if($datosUsuario){
     
        if(trim($oficina) == 'SMP2'){
            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
            $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$dias,$montoSMP['FEC_INGRESO']);
           
        }else{
           $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$dias,$montoSMP['FEC_INGRESO'],$oficina);
        }
        
         
          f_Cuotas($montoTotal,$montoSMP['CUOTA'], $dias);  

       }else{
            return header("Location: http://localhost:8080/requerimiento/vista/");
        }
    }

}

?>