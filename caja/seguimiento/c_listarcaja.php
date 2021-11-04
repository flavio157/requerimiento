<?php
        require_once("../funciones/m_listarcaja.php");
        require_once("../funciones/f_funcion.php");
        require_once("../funciones/m_comentario.php"); //esto

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
        }else if($accion == "verificar"){ 
            $oficina = $_POST['oficina'];
            $nro_correlativo = $_POST['dato'];
            c_listarcaja::c_verificar_escaneo($oficina,$nro_correlativo);
        }else if($accion == "lstfecha"){//esto
            $fecha = $_POST['fecha'];
            c_listarcaja::c_lstcomentario($fecha);
        }else if($accion == "actualizar"){
            $nro = $_POST['nro'];
            c_listarcaja::c_actualiestado($nro);
        }else if ($accion == 'lstcomenfalta'){
            c_listarcaja::c_lstcomentariofalta();
        }//hasta aqui

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

        static function c_verificar_escaneo($oficina,$nro_correlativo){
            $m_escaneo = new m_listarcaja($oficina);
            $c_escaneo = $m_escaneo->m_verificar_escaneo($nro_correlativo);
            print_r(count($c_escaneo));
        }

        static function c_lstcomentario($fecha) //esto
        {
            $m_comentario = new m_comentarios();
            $c_comentario = $m_comentario->m_lstcomentario($fecha);
            if(count($c_comentario) == 0){return;}
            $dato = array(
                'nro' =>$c_comentario[0][0],
                'comentario' => $c_comentario[0][1]
            );
            
            echo json_encode($dato , JSON_FORCE_OBJECT);
        }

        static function c_actualiestado($id)
        {
            $date = retunrFechaActualphp(); 
            $m_comentario = new m_comentarios();
            $c_comentario = $m_comentario->m_actualizarestado($date,$id);
            
        }
        static function c_lstcomentariofalta(){
            $m_comentario = new m_comentarios();
            $c_comentario = $m_comentario->m_lstcomentariofalta();
            if(count($c_comentario) == 0){return;}
            $dato = array(
               "dato" => $c_comentario,
               "b" => false
            );
            
            echo json_encode($dato , JSON_FORCE_OBJECT);
        }//hasta aqui
    }
?>