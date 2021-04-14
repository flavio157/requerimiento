<?php
require_once("../modelo/M_login.php");
session_start();

    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];

    if ($nombre!="" && $clave!="") {
        $usu = new C_Login();
        $usu->C_usuario($nombre,$clave);
    }else{
        return header("Location: http://localhost:8080/requerimiento/vista/");
    }

class C_Login
{
    public function C_usuario($usu,$pass)
    {
        $m_login = new M_Login();
        $m_count = $m_login->get_usuario($usu,$pass);
        if(sizeof($m_count) > 0){
           echo  $m_count['OFICINA'];
           /*return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
        */ }
    }


}
?>