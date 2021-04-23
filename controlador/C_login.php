<?php
require_once("../modelo/M_login.php");
require_once("../modelo/M_BuscarProductos.php");
require_once("C_Cuotas.php");
session_start();

    $nombre = $_POST['usuario'];

    if ($nombre!="") {
        $usu = new C_Login();
        $usu->C_usuario($nombre);
    }else{
        return header("Location: http://localhost:8080/requerimiento/vista/");
       
    }
class C_Login
{
    public function C_usuario($usu)
    {
        $m_cuotas = new C_Controlar_Cuotas();
        $m_login = new M_Login();
        $m_count = $m_login->get_usuario($usu,"A");

        if(sizeof($m_count) > 0){
            
            $m_lista = $m_cuotas->C_Cuotas($m_count['COD_CLIENTE'],$m_count["SALDO"]);
        }
        
    }

}
?>