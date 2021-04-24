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
        $dia = getdate();
        $basedate = "SMP2";
        $m_login = new M_Login($basedate);
        $m_count = "";
        
        
        if($dia['mday']>='12' && $dia['mday']<='16'){
           $m_count = $m_login->PasadoQuincena($cod_vendedor,"A");
            $this->Controlar_Cuotas($m_count);
           
        }else if($dia['mday']>='27' && $dia['mday']<='30')    {
            $m_count = $m_login->PasadoQuincena($cod_vendedor,"A");
            $this->Controlar_Cuotas($m_count);
        }else{
            $m_count = $m_login->Login($cod_vendedor,"A");
            $this->ingresoNormal(0);
        }
    }

    public function Controlar_Cuotas($m_count)
    {
        $C_cuotas = new C_Controlar_Cuotas();
        
        if($m_count){
            $cuota = 0; 
                while($row = $m_count->fetch(PDO::FETCH_ASSOC)){
                    $cuota += intval($row["CANTIDAD"]);
                }
               
                $C_cuotas->C_Cuotas($cuota);
            }
    }
    
    public function ingresoNormal($cuota)
    {
        $C_cuotas = new C_Controlar_Cuotas();
        $C_cuotas->C_Cuotas($cuota);
    }
}

?>