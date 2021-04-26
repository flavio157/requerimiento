<?php

class C_controlador_almacenes
{
    public function C_cuotas_almacen($monto_total)
    {
        $this->Verificar_Quincena_almacen($monto_total);
    }
    

    public function Verificar_Quincena_almacen($monto_total)
    {
        $cuota = 100;
        $MensajeBloqueo = 0;
        $hoy = getdate();

        if($hoy['mday']>='12' && $monto_total < $cuota && $hoy['mday']<='16'){
            if($hoy['mday'] == '16'){
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,$cambiarEstadoPerso);*/
                /*return header("Location: http://localhost:8080/requerimiento/vista/");*/
         
            }else{
                $MensajeBloqueo = 0;  
                return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
            }
           
        }else if($hoy['mday']>='27' && $monto_total < $cuota && $hoy['mday']<='30'){
            if($hoy['mday'] == '30'){
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,$cambiarEstadoPerso);*/
                /*return header("Location: http://localhost:8080/requerimiento/vista/");*/
            }else{
                $MensajeBloqueo = 0;  
                return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
            }
        }else{
            /*sino no pasa pasa nada se logue normal*/
            $MensajeBloqueo = 1;
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
        }

    }


}



?>