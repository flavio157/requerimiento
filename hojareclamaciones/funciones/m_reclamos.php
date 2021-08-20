<?php
    
    
    class m_reclamos
    {
        public function m_guardarReclamo($nroreclamo,$diareclamo,$mesreclamo,$anoreclamo,$nombrecliente,$domicilio,$dni,
        $cedula,$telefono,$correo,
        $nompadres,$producto, $servicio,$monto,$descripcion,$reclamo,$detalle,$pedido,$diarespuesta,$mesrespuesta,$anorespuesta)
        {  
            $datereclamo = $diareclamo."-".$mesreclamo."-".$anoreclamo;
            $daterespuesta = $diarespuesta."-".$mesrespuesta."-".$anorespuesta;
          
           
            include("conexion.php");
            $reclamos = $conn->prepare("INSERT INTO T_RECLAMO(NRO_RECLAMO,FECH_RECLAMO,NOM_CONSUMIDOR,DIR_CONSUMIDOR,DNI,
                    CEDULA,TELEFONO,CORREO,NOM_PADRES,PRODUCTO,SERVICIO,MONTO_RECLAMO,
                    DESCRIPCION,RECLAMO,QUEJA,DETALLE,PEDIDO,FECH_RESPUESTA) 
                    values('$nroreclamo','$datereclamo','$nombrecliente','$domicilio','$dni','$cedula','$telefono',
                    '$correo','$nompadres','$producto','$servicio','$monto','$descripcion','$reclamo','','$detalle','$pedido','')");
            $reclamos->execute();
            return $reclamos;
        }

        public function m_numeroreclamos(){
            include("conexion.php");
            $nro_reclamos = $conn->prepare("SELECT * FROM T_RECLAMO ORDER BY ID DESC limit 1");
            $nro_reclamos->execute();
            $result = $nro_reclamos->fetchAll();
            $nroreclamo = intval($result[0]['NRO_RECLAMO']) + intval(1);
            return str_pad($nroreclamo, 9, '0', STR_PAD_LEFT);
        }        

    }
?>