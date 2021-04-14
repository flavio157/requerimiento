<?php
require_once("../modelo/M_login.php");
require_once("C_Cuotas.php");


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
        $m_cuotas = new C_Controlar_Cuotas();
        $m_login = new M_Login();
        $m_count = $m_login->get_usuario($usu,$pass,"A");

        /*echo $m_count['OFICINA'];*/
        
        if(sizeof($m_count) > 0){

           /* $m_lista = $m_cuotas->C_Cuotas(null,null,null); se pasara los datos cod_persona, oficina,zona*/
           return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
        }
    }

}
?>