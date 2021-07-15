<?php
date_default_timezone_set('America/Lima');
require_once("M_VerificarCuota.php");
require_once("M_Login.php");
require_once("../funciones/f_funcion.php");


   $cod_usuario = $_POST['usuario'];
  
  // print_r($estado);
   
    if ($cod_usuario !="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);
    }else{
        return header("Location: ../index.php");
    }


class C_Login
{
    public function C_usuario($cod_usuario){  
        $diasrestriccion = 2;
        $arraydias = array('3','6','9');
       
        $m_login = new M_Login(); 

        $datosUsuario = $m_login->Login($cod_usuario);
        if($datosUsuario != ''){
            $c_admins = $m_login->Administradores($datosUsuario['COD_PERSONAL']);
            if($c_admins == ''){
                $fecha = C_Asistenciadias($cod_usuario);
                $dias = diasfalto($fecha); 
                $m_cuotaPersonal = new M_VerificarCuota($datosUsuario['OFICINA']);
                $montoSMP = $m_cuotaPersonal->CuotaPersonal($cod_usuario);
               // print_r($montoSMP);
                $oficina = $datosUsuario['OFICINA'];
            
                if($datosUsuario){
                        if(trim($oficina) == 'SMP2' || trim($oficina) == 'SMP5'){
                            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
                            $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$diasrestriccion,
                            $montoSMP['FEC_INGRESO'],count($dias),$montoSMP['CUOTA']);
                        
                        }else{
                        $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$arraydias,
                        $montoSMP['FEC_INGRESO'],$oficina,count($dias),$montoSMP['CUOTA']);
                        }
                     
                   //   print_r($montoTotal);
                        if($montoTotal != ''){
                          // print_r($montoTotal);
                           f_Cuotas($montoTotal,$montoSMP['CUOTA'],$oficina) ; 
                            //echo $retur;
                        }else{
                            print_r("SIN RESTRICCION");
                        }  
                }else{
                    return header("Location: ../index.php");
                }
            }else{
                print_r("acceso directo");
            } 
        }else{
            //return header("Location: ../index.php");
            print_r("usuario no existe");
        }     
    }
}
?>