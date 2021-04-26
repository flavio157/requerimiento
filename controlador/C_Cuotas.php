<?php


class C_Controlar_Cuotas
{

    public function C_Cuotas($verificarcuotas,$bd)
    {
       $this->verificarQuincenas($verificarcuotas,$bd);
    }
    

    public function verificarQuincenas($verificarCuotas,$bd)
    {
        $m_verificar = new M_Login($bd);
        $cuota = 100;
        $MensajeBloqueo = 0;
        $hoy = getdate();

        if($hoy['mday']>='12' && $verificarCuotas < $cuota && $hoy['mday']<='16'){
            if($hoy['mday'] == '16'){
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,$cambiarEstadoPerso);*/
                /*return header("Location: http://localhost:8080/requerimiento/vista/");*/
         
            }else{
                $MensajeBloqueo = 0;  
                return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
            }
           
        }else if($hoy['mday']>='27' && $verificarCuotas < $cuota && $hoy['mday']<='30'){
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