<?php
        require_once("../funciones/m_reclamos.php");
        $accion = $_POST['accion'];
        if($accion == "guardar"){    
            $nroreclamo = $_POST['nroreclamo'];
            $diareclamo = $_POST['txtdiareclamo'];
            $mesreclamo = $_POST['txtmesreclamo'];
            $anoreclamo = $_POST['txtanoreclamo'];
            $nombrecliente = $_POST['txtnombrecliente'];
            $domicilio = $_POST['txtdomiciliocliente'];
            $dni = $_POST['txtdni'];
            $cedula = $_POST['txtcedula'];
            $telefono = $_POST['txttelefono'];
            $correo   = $_POST['txtcorreo'];
            $nompadres = $_POST['txtnompadres'];
            $producto = $_POST['txtproducto'];
            $servicio = $_POST['txtservicio'];
            $monto = $_POST['txtmonto'];
            $descripcion = $_POST['txtdescripcion'];
            $reclamo = 'reclamo';
            $detalle = $_POST['txtdetalle'];
            $pedido = $_POST['txtpedido'];
            $diarespuesta = $_POST['txtdiarespuesta'];
            $mesrespuesta = $_POST['txtmesrespuesta'];
            $anorespuesta = $_POST['txtanorespuesta'];

            c_reclamos::c_guardarReclamo($nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,$cedula,$telefono,$correo
            ,$nompadres,$producto,$servicio,$monto,$descripcion,$reclamo,$detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta);
        
        }else if($accion == "nroreclamo"){
                c_reclamos::c_nroreclamo();
        }   

    class c_reclamos 
    {
        static function c_guardarReclamo($nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,$cedula,$telefono,$correo,$nompadres,$producto,
        $servicio,$monto,$descripcion,$reclamo,$detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta){
            $m_reclamos = new m_reclamos();
            $c_reclamos = $m_reclamos->m_guardarReclamo($nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio
            ,$dni,$cedula,$telefono,$correo,$nompadres,$producto,$servicio,$monto,$descripcion,$reclamo,$detalle,$pedido,$diarespuesta,
            $mesrespuesta,$anorespuesta);
            print_r($c_reclamos);
        }

        static function c_nroreclamo()
        {
           $m_reclamos = new m_reclamos();
           $c_reclamos = $m_reclamos->m_numeroreclamos();
           printf($c_reclamos);     
        }
    }
?>