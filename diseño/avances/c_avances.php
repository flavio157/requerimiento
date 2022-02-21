<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_avances.php");

    $accion = $_POST['accion'];  
    if($accion == 'produccion'){
        c_avances::c_parametros();
    }else if($accion == 'filtrar'){
        $inicio = $_POST['inicion'];
        $fin = $_POST['fin'];
        c_avances::c_filtrar($inicio,$fin);
    }
 
    class c_avances
    {
        static function c_parametros(){
           
            $m_formula = new m_avances();
            $consulta = "''=''";
            $parametros = $m_formula->m_buscar("V_LISTAR_PRODUCCION",$consulta);
            $dato = array('dato' => $parametros);
            echo json_encode($dato,JSON_FORCE_OBJECT); 
        }

        static function c_filtrar($inicio,$fin){
           
            $m_formula = new m_avances();
            $consulta = "Convert(DATE, inicio) >= '$inicio' AND Convert(DATE, inicio) <= '$fin'";
            $parametros = $m_formula->m_buscar("V_LISTAR_PRODUCCION",$consulta);
            $dato = array('dato' => $parametros);
            echo json_encode($dato,JSON_FORCE_OBJECT); 
        }
}
?>