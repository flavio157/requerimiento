<?php
require_once("../modelo/M_login.php");
require_once("../modelo/M_BuscarProductos.php");
require_once("C_Cuotas.php");
session_start();

    $cod_vendedor = $_POST['usuario'];

    if ($cod_vendedor!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_vendedor);
    }else{
        print_r($cod_vendedor);
        return header("Location: http://localhost:8080/requerimiento/vista/");
       
    }
class C_Login
{
    

    public function C_usuario($cod_vendedor)
    {
        $basedate = "SMP2";
        $C_cuotas = new C_Controlar_Cuotas();
        $m_login = new M_Login($basedate);
        $m_count = $m_login->M_Login($cod_vendedor,"A");
        $cuota = 0;  
        

         if($m_count){
            while($row = $m_count->fetch(PDO::FETCH_ASSOC)){
                $cuota += intval($row["CANTIDAD"]);
              
            }
             print_r($cuota);
            $C_cuotas->C_Cuotas($cuota);
        }
        
    }

}
?>