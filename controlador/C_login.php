<?php
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
       
       $m_login = new M_Login();

       $datosUsuario = $m_login->Login($cod_usuario);
       

       if($datosUsuario){
       
            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
            $verificar = $_cuota->VerificandoQuincena($datosUsuario['COD_USUARIO']);
           
           if($verificar){
                $C_cuotas = new C_Controlar_Cuotas();
                $C_cuotas->C_Cuotas($verificar['cantidad'],$datosUsuario['OFICINA']);
            }else{
             
                $C_cuotas = new C_Controlar_Cuotas();
                $C_cuotas->C_Cuotas(0,$datosUsuario['OFICINA']);
            }
       }

    }

}

?>