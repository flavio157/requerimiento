<?php
date_default_timezone_set('America/Lima');
require_once("../modelo/M_VerificarCuota.php");
require_once("../modelo/M_Login.php");
require_once("../controlador/f_funcion.php");


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
        $m_login = new M_Login();
        
        $montoSMP = $m_login->CuotaPersonal($cod_usuario); 
        $diasprimeraquincena =array("15","26");
        $diassegundaquincena =array("01","11");
        
      
        $datosUsuario = $m_login->Login($cod_usuario);
        

       if($datosUsuario){
        if(trim($datosUsuario['OFICINA']) == "SMP2"){
            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
            $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$diasprimeraquincena
                                                       ,$diassegundaquincena,$montoSMP['FEC_INGRESO']);
        }else{
           $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$diasprimeraquincena,
                                                       $diassegundaquincena,$montoSMP['FEC_INGRESO']);
        }
       /* print_r($montoTotal);*/
        f_Cuotas($montoTotal[0],$montoSMP['CUOTA'], $diasprimeraquincena,$diassegundaquincena,$montoTotal[1]);

       }else{
         return header("Location: http://localhost:8080/requerimiento/vista/");
        }
    }

}

?>