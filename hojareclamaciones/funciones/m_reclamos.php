<?php
    require_once("f_funcion.php");
    
    class m_reclamos
    {
        public function m_guardarReclamo($ruc,$identificacion,$nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,
        $cedula,$telefono,$correo,
        $nompadres,$producto, $servicio,$monto,$descripcion,$reclamo,$queja,$detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta)
        {  
            $datereclamo = retunrFechaActualphp();
            $daterespuesta = $anorespuesta."-" .$mesrespuesta."-".$diarespuesta;
          
            include("conexion.php");
            $reclamos = $conn->prepare("INSERT INTO T_RECLAMO(RUC,IDENTIFICACION,NRO_RECLAMO,FECH_RECLAMO,NOM_CONSUMIDOR,DIR_CONSUMIDOR,DNI,
                    CEDULA,TELEFONO,CORREO,NOM_PADRES,PRODUCTO,SERVICIO,MONTO_RECLAMO,
                    DESCRIPCION,RECLAMO,QUEJA,DETALLE,PEDIDO,FECH_RESPUESTA) 
                    values('$ruc','$identificacion','$nroreclamo','$datereclamo','$nombrecliente','$domicilio','$dni','$cedula','$telefono',
                    '$correo','$nompadres','$producto','$servicio','$monto','$descripcion','$reclamo','$queja','$detalle','$pedido','$daterespuesta')");
                    $exis = m_reclamos::buscarnroreclamo($nroreclamo);
                    if($exis > 0){
                       print_r("YA EXISTE UN RECLAMO CON EL MISMO CODIGO" .  $daterespuesta);
                       return;
                    }else {
                        $reclamos->execute();
                        if($reclamos) 
                            return 1;
                    }
                 
        }
    
        static function buscarnroreclamo($nroreclamo){
            include("conexion.php");
            $nro_reclamos = $conn->prepare("SELECT * FROM T_RECLAMO where NRO_RECLAMO = '$nroreclamo'");
            $nro_reclamos->execute();
            $result = $nro_reclamos->fetchAll();
            return count($result);
        }



        public function m_numeroreclamos(){
            include("conexion.php");
            $nro_reclamos = $conn->prepare("SELECT * FROM T_RECLAMO ORDER BY ID DESC limit 1");
            $nro_reclamos->execute();
            $result = $nro_reclamos->fetchAll();
            if(Count($result) > 0){
                 $nroreclamo = intval($result[0]['NRO_RECLAMO']) + intval(1);
            }else{
                 $nroreclamo = str_pad(1, 9, '0', STR_PAD_LEFT);
            }
           
           
           return str_pad($nroreclamo, 9, '0', STR_PAD_LEFT);
        }        

    }
?>