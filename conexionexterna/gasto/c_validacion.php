<?php
    require_once("c_empresas.php");
    require_once("../funciones/f_funcion.php");

    $patron = "/^([0-9])*$/";
    $oficina = $_POST['oficina'];
    $cod_empresa = $_POST['slcempresa'];
    $cod_personal = $_POST['idpersonal'];
    $tipo_comprobante = $_POST['slcdocumento'];
    $serie_contabilidad = $_POST['txtseriedocument'];
    $comp_contabilidad = $_POST['txtnrodocumento'];
    $identificacion = $_POST['txtruc'];
    $cod_proveedor = $_POST['codproveedor'];
    $nombre = $_POST['txtproveedor'];
    $direccion = $_POST['txtdirproveedor'];   
    $obs_comprovante = $_POST['txtobservacion']; 
    $concepto = $_POST['slcconcepto'];   
    $monto_comprobante = $_POST['txtmonto'];
    $usuario_registro = $_POST['usuario'];

    $fec_emision = retunrFechaSqlphp(date("Y-m-d"));
    $cod_concepto_caja = $_POST['caja'];
    $caja = '0';
    $existepro = $_POST['existeproveedor'];
    $validarcom = $_POST['validarcom'];
    $mensaje = array();

    if($cod_empresa == ''){
        $mensaje = ['Seleccione una empresa','error']; 
    }else if($cod_personal == ''){
        $mensaje = ['Seleccione personal','error']; 
    }else if($serie_contabilidad == ''){
        $mensaje = ['El campo serie documento no puede estar vacio','error'];  
    }else if(substr($identificacion,0,2) == '20' && $tipo_comprobante != '01'){
        $mensaje=['RUC 20 debe ser FACTURA','error'];
    }else if(!preg_match($patron,$serie_contabilidad)){
        $mensaje =['Solo se permite numeros en Serie Documento','error'];
    }else if($serie_contabilidad == ''){
        $mensaje =['Ingrese SERIE DOCUMENTO','error'];
    }else if(strlen($serie_contabilidad) < 4 || strlen($serie_contabilidad) > 4){
        $mensaje =['SERIE DOCUMENTO no puede ser menor a 4 digitos','error'];
    }else if($comp_contabilidad == ""){
        $mensaje =['Ingrese Numero de Documento','error'];
    }else if($identificacion == ''){
        $mensaje =['Ingrese un numero de RUC o seleccione un Empresa','error'];
    }else if($direccion == ''){
        $mensaje =['Ingrese direccion del proveedor','error'];
    }else if ($obs_comprovante == ''){
        $mensaje =['Ingrese una observacion','error'];
    }else if($concepto == ''){
        $mensaje =['Seleccione un concepto','error'];
    }else if($monto_comprobante == ''){
        $mensaje =['Ingrese un monto','error'];
    }else{
        if($concepto == '00001' || $concepto == '00002'){
            $contabilidad= '1';
        }else{
            $contabilidad= '0';
        }
        
        $registro = C_Empresas::verificardoc($serie_contabilidad,$tipo_comprobante,$serie_contabilidad,$identificacion);
        
        if($registro == ""){
            if($validarcom != 1){
                $tipo =  C_Empresas::c_guardargasto('',$oficina,$fec_emision,$cod_personal,$tipo_comprobante,$serie_contabilidad,$comp_contabilidad,$identificacion,
                $cod_proveedor,$nombre,$direccion,$obs_comprovante,$monto_comprobante,'',$usuario_registro,$caja,$contabilidad,$cod_empresa,$cod_concepto_caja,$concepto,$existepro);
                if($tipo[0] == "echo"){
                    $mensaje=["Se registro el gasto",'echo'];
                }else{
                    $mensaje=["Ocurrio un error al registrar",'error'];
                }
            }else{
               $codigo = nombreimg();
               $mensaje =[$codigo,''];
            }
           
        }else{
            $mensaje =['Ya existe un registro con la Serie Documento ','error'];
        }
       
       
    }

    echo json_encode($mensaje,JSON_FORCE_OBJECT);

    function nombreimg()
    {
        $codigo = C_Empresas::nombreimgn();
        return $codigo;
    }
    

   
  
    
?>




