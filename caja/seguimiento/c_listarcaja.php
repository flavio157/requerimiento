<?php
        require_once("../funciones/m_listarcaja.php");
        require_once("../funciones/f_funcion.php");


        $accion = $_POST['accion'];
        $oficina = trim($_POST['oficina']);
        
        
        if ($accion == "listar") {
            c_listarcaja::c_mostraritems($oficina);
        }else if($accion == "guardar"){
            
            $nro_correlativo = trim($_POST['correlativo']);
            $cod_personal = trim($_POST['cod_personal']);
            $monto = trim($_POST['monto']);
            $vroficina = trim($_POST['vroficina']);
            $fec_gasto = trim($_POST['fec_gasto']);
            $fec_cobro = trim($_POST['fec_cobro']);
            $cod_usuario = trim($_POST['cod_usuario']);
            c_listarcaja::c_guardarcaja($nro_correlativo,$fec_gasto,$fec_cobro,$vroficina,$cod_personal,$cod_usuario,$oficina,$monto);
        }

    class c_listarcaja 
    {
        static function c_mostraritems($oficina)
        {
           $m_listarcaja = new m_listarcaja($oficina);
           $c_mostraritems = $m_listarcaja->m_mostraritems(); 
            $datos  = array(
                'estado' => 'ok',
                'items' => $c_mostraritems
                );
                echo json_encode($datos,JSON_FORCE_OBJECT); 
        }


        static function c_guardarcaja($nro_correlativo,$fec_gasto,$fec_cobro,$vroficina,$cod_personal,$cod_usuario,$oficina,$monto)
        {
            $m_listarcaja = new m_listarcaja($oficina);
            $c_guardarcaja = $m_listarcaja->m_guardarcaja($nro_correlativo,$fec_gasto,$fec_cobro,$cod_personal,$cod_usuario,$vroficina,$monto);
            if($c_guardarcaja) echo $c_guardarcaja;
        }

    }
?>