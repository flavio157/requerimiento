<?php


class C_Controlar_Cuotas
{

    public function C_Cuotas($verificarcuotas)
    {
       $this->C_CalcularDias($verificarcuotas);
    }


    public function C_CalcularDias($verificarCuotas){
        
        $cuota = 10;

        $cambiarEstadoclie = "A";
        $MensajeBloqueo = 0;
        $hoy = getdate();

        
        if($hoy['mday'] >= '12' && $cuota !== $verificarCuotas && $hoy['mday'] <= '26')
        {
             if($hoy['mday']>='15' &&  $cuota !== $verificarCuotas){
               
                /*si pasado 3 dias sigue igual se invalida la sesion ,function de actualizar estado de usuario y enviar mensaje usuario bloqueado*/
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_cliente,$cambiarEstadoClie);*/
                return header("Location: http://localhost:8080/requerimiento/vista/");

            }else{

               /*se loguea y mensaje de advertencia */
               $MensajeBloqueo = 0;  
               print_r("echo");
               return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);

             }
        }else if($hoy['mday'] >= '27' &&  $cuota !== $verificarCuotas  && $hoy['mday'] <= '11'){
            
             if($hoy['mday']>='30' &&  $cuota !== $verificarCuotas){

                /*si pasado 3 dias sigue igual se invalida la sesion ,function de actualizar estado de usuario y enviar mensaje usuario bloqueado*/
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_cliente,$cambiarEstadoclie);*/
                 return header("Location: http://localhost:8080/requerimiento/vista/");
            
            }else{

                $MensajeBloqueo = 0;
                /* se loguea y mensaje de advertencia */
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