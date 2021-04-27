<?php
date_default_timezone_set('America/Lima');

class C_Controlar_Cuotas
{

    public function C_Cuotas($verificarcuotas)
    {
       $this->verificarQuincenas($verificarcuotas);
    
    }
    

    public function verificarQuincenas($verificarCuotas)
    {   
        $m_verificar = new M_Login();
        $cuota = 5000;
        $MensajeBloqueo = 0;
        $hoy = getdate();

        if($hoy['mday'] >= '15' && $cuota > $verificarCuotas && $hoy['mday'] <='27'){

            if($hoy['mday'] == '27'){
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,"A");*/
                return header("Location:http://localhost:8080/requerimiento/vista/Bloqueo.php");
            }
            if($hoy['mday'] >= '15' && $hoy['mday'] <= '26'){
                $MensajeBloqueo = 0;  
                return header("Location:http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo."&cantidad=".$verificarCuotas);
            }
           
        }else if($hoy['mday'] >= '01' &&  $cuota > $verificarCuotas  && $hoy['mday'] <='12'){
          
            if($hoy['mday'] == '12'){
                
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,"A");*/
                return header("Location:http://localhost:8080/requerimiento/Bloqueo");
            } 
            if($hoy['mday'] >= '01' && $hoy['mday'] <= '11'){
                $MensajeBloqueo = 0;  
                return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo."&cantidad=".$verificarCuotas);
            }
        }else{
            $MensajeBloqueo = 1;
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
        }
    }
}

?>