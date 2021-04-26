<?php
date_default_timezone_set('America/Lima');
require_once("../modelo/M_VerificarCuota.php");
require_once("../modelo/M_Login.php");
require_once("../modelo/M_BuscarProductos.php");
require_once("C_Cuotas.php");
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
    {
        $diasprimeraquincena =array("15","26");
        $diassegundaquincena =array("01","11");
        
       $m_login = new M_Login();
       $datosUsuario = $m_login->Login($cod_usuario);

       if(trim($datosUsuario['OFICINA']) == "SMP2"){
                if($datosUsuario){
                    $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
                    $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$diasprimeraquincena,$diassegundaquincena);
                  
                    print_r($montoTotal);
                    $this->c_cuotas($montoTotal,"SMP2", $diasprimeraquincena,$diassegundaquincena);

                }else{
                    return header("Location: http://localhost:8080/requerimiento/vista/");
                }
                
       }else{
            if($datosUsuario){
                    $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$diassegundaquincena,$diassegundaquincena);
                  
                    print_r($montoTotal);
                    $this->c_cuotas($montoTotal,"SMP4",$diasprimeraquincena,$diassegundaquincena);
            }else{
                return header("Location: http://localhost:8080/requerimiento/vista/");
            }
        }
    }



    public function c_cuotas($montoTotal,$tipo,$diasprimeraquincena,$diassegundaquincena)
    {
        $montoSMP2 = 7000;
    
        if($tipo == "SMP2"){
            if($montoTotal == ""){
                $montoTotal = 0;
            }
            $C_cuotas = new C_Controlar_Cuotas();
            $C_cuotas->C_Cuotas($montoTotal,$montoSMP2,$diasprimeraquincena,$diassegundaquincena);

        }else{
            if($montoTotal == ""){
                $montoTotal = 0;
            }
            echo $montoTotal;
            $C_cuotas = new C_Controlar_Cuotas();
            $C_cuotas->C_Cuotas($montoTotal,$montoSMP2,$diasprimeraquincena,$diassegundaquincena);
        }
       
    }
  
}

?>