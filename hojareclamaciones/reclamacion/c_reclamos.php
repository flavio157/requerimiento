<?php
        require_once("../funciones/m_reclamos.php");
        require_once("../funciones/f_funcion.php");
        $accion = $_POST['accion'];
        if($accion == "guardar"){    
            $ruc = $_POST['txtruc'];
            $identificacion = $_POST['txtidentificacion'];
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
            $detalle = $_POST['txtdetalle'];
            $pedido = $_POST['txtpedido'];
            $diarespuesta = $_POST['txtdiarespuesta'];
            $mesrespuesta = $_POST['txtmesrespuesta'];
            $anorespuesta = $_POST['txtanorespuesta'];
            if(isset($_POST['txtreclamo'])){
                if($_POST['txtreclamo'] == 1){
                    $reclamo = 1;
                    $queja = "";
                }else{
                    $reclamo = "";
                    $queja = 2;
                }
            }else{
                $reclamo = "";
                $queja = "";
            }

            c_reclamos::c_guardarReclamo($ruc,$identificacion,$nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,$cedula,$telefono,$correo
            ,$nompadres,$producto,$servicio,$monto,$descripcion,$reclamo,$queja, $detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta);
    
        }else if($accion == "nroreclamo"){
                c_reclamos::c_nroreclamo();
        }   

    class c_reclamos 
    {
        static function c_guardarReclamo($ruc,$identificacion,$nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,$cedula,$telefono,$correo,$nompadres,$producto,
        $servicio,$monto,$descripcion,$reclamo,$queja,$detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta){
            

            $patron = "/^[^@]{1,64}@[^@]{1,255}$/";
            if(strlen($nroreclamo) == 0 || !is_numeric($nroreclamo)){
                print_r("ERROR NRO DE RECLAMO INVALIDO");
                return;
            }else if(strlen($ruc) == 0 || strlen($ruc) < 11){
                print_r("ERROR RUC INVALIDO");
                return;
            }else if(strlen($identificacion) == 0){
                print_r("ERROR IDENTIFICACION INVALIDO");
                return;
            }else if(strlen($nombrecliente) == 0){
                print_r("ERROR NOMBRE DEL CLIENTE INVALIDO");
                return;
            }else if(strlen($domicilio) == 0){
                print_r("ERROR DOMICILIO INVALIDO");
                return;
            }else  if(strlen($producto) == 0){
                print_r("ERROR PRODUCTO INVALIDO");
                return;
            }else if(strlen($servicio) == 0){
                print_r("ERROR SERVICIO INVALIDO");
                return;
            }else if(strlen($monto) == 0 || !is_numeric($monto)){
                print_r("ERROR MONTO INVALIDO");
                return;
            }else if(strlen($descripcion) == 0){
                print_r("ERROR DESCRIPCION INVALIDO");
                return;
            }else if($reclamo == "" && $queja == ""){
                print_r("ERROR SELECCIONE TIPO DE RECLAMO");
                return;
            }else if(strlen($detalle) == 0){
                print_r("ERROR DETALLE INVALIDO");
                return;
            }else if(strlen($pedido) == 0){
                print_r("ERROR CAMPO PEDIDO INVALIDO");
                return;
            }else if(strlen($diarespuesta) == 0 || strlen($mesrespuesta) == 0 || strlen($anorespuesta) == 0){
                print_r("ERROR FECHA DE RESPUESTA INVALIDO");
                return;
            }
            
            if($diarespuesta > diasdelMes()){
                print_r("ERROR DIA DE RESPUESTA INVALIDO");
                return;
            }

            if(strlen($mesrespuesta) != 0){
                if($mesrespuesta > 12 || $mesrespuesta == 0){
                    print_r("ERROR MES DE RESPUESTA INVALIDO");
                    return;
                }else{
                    if(strlen($mesrespuesta) == 1){
                          $mesrespuesta = "0".$mesrespuesta;
                    }
                }
            }

            if(strlen($anorespuesta) > 4 || $anorespuesta < date("Y")){
                print_r("ERROR AÑO DE RESPUESTA INVALIDO");
                return;
            }

            if(strlen($telefono) == 0 && strlen($correo)  == 0){
                print_r("ERROR DEBE RELLENAR TELEFONO O CORREO");
                return;
            }
            if(strlen($dni) == 0 && strlen($cedula)  == 0){
                print_r("ERROR DEBE RELLENAR DNI O CEDULA");
                return;
            }
            if(strlen($dni) != 0){  
                if(!is_numeric($dni) || strlen($dni) < 8 || strlen($dni) > 8){
                    print_r("ERROR DNI INVALIDO");
                    return;
                }
            }else if(strlen($cedula) != 0){
                if(!is_numeric($cedula) || strlen($cedula) < 12 || strlen($cedula) > 12){
                    print_r("ERROR CEDULA INVALIDO");
                    return;
                }
            }

            if(strlen($telefono) != 0){  
                if(!is_numeric($telefono) || strlen($telefono) > 11){
                    print_r("ERROR TELEFONO INVALIDO");
                    return;
                }
            }else if(strlen($correo) != 0){
                if(!preg_match($patron,$correo)){
                    print_r("ERROR CORREO INVALIDO");
                    return;
                }
            }

                $m_reclamos = new m_reclamos();
                $c_reclamos = $m_reclamos->m_guardarReclamo($ruc,$identificacion,$nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio
                ,$dni,$cedula,$telefono,$correo,$nompadres,$producto,$servicio,$monto,$descripcion,$reclamo,$queja,$detalle,$pedido,$diarespuesta,
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