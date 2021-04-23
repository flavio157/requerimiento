<?php

class C_Controlar_Cuotas
{
    
    public function C_Cuotas($cod_cliente ,$verificarcuotas)
    {
        $m_cuota = new M_Login();
        $precioTotal = $m_cuota->M_Cuotas($cod_cliente);
        $this->C_CalcularDias($verificarcuotas,$precioTotal['PRECIO'],$cod_cliente );
    }



    
    
    public function C_CalcularDias($verificarCuotas,$precioTotal,$cod_cliente){
        $m_verificar = new M_Login();
        $cambiarEstadoclie = "A";
        $MensajeBloqueo = 0;
        $hoy = getdate();
        

        if($hoy['mday'] >= '12' && $verificarCuotas < $precioTotal && $verificarCuotas !=0)
        {
             if($hoy['mday']>='15'){
               
                /*si pasado 3 dias sigue igual se invalida la sesion ,function de actualizar estado de usuario y enviar mensaje usuario bloqueado*/
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_cliente,$cambiarEstadoClie);*/
                return header("Location: http://localhost:8080/requerimiento/vista/");

            }else{

               /*se loguea y mensaje de advertencia */
               $MensajeBloqueo = 0;  
               return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);

             }
        }else if($hoy['mday'] >= '27' && $verificarCuotas < $precioTotal && $verificarCuotas !=0){
            
             if($hoy['mday']>='30'){

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