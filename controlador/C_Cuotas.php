<?php
date_default_timezone_set('America/Lima');

class C_Controlar_Cuotas
{

    public function C_Cuotas($verificarcuotas,$cuota,$diasprimeraquincena,$diassegundaquincena)
    {
       $this->verificarQuincenas($verificarcuotas,$cuota,$diasprimeraquincena,$diassegundaquincena);
    
    }
    

    public function verificarQuincenas($verificarCuotas,$cuotas,$diasprimeraquincena,$diassegundaquincena)
    {   
        $m_verificar = new M_Login();
        $cuota = $cuotas;
        $MensajeBloqueo = 0;
        $hoy = getdate();

        /*number_format($number1, 2)*/

        if($hoy['mday'] >= $diasprimeraquincena[0] && number_format(round($cuota,2),2)  > number_format(round($verificarCuotas,2),2)   && $hoy['mday'] <=$diasprimeraquincena[1]){

            if( $hoy['mday'] == $diasprimeraquincena[0] || $hoy['mday'] <= $diasprimeraquincena[1] ){
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,"A");*/
                return header("Location:http://localhost:8080/requerimiento/vista/bloqueo.php?cantidad=".number_format(round($verificarCuotas,2),2)."&cuota=".number_format(round($cuota,2),2));
            }

            /* if($hoy['mday'] >=  $diasprimeraquincena[0] && $hoy['mday'] <= '25'){
                $MensajeBloqueo = 0;  
                return header("Location:http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo."&cantidad=".$verificarCuotas) ;
            }*/
           
        }else if($hoy['mday'] >= $diassegundaquincena[0] &&  number_format(round($cuota,2),2)  > number_format(round($verificarCuotas,2),2)   && $hoy['mday'] <= $diassegundaquincena[1]){
          
            if($hoy['mday'] == $diassegundaquincena[0] || $hoy['mday'] <= $diassegundaquincena[1]){
                
                /*$m_verificar->M_ActualizarEstadoUsuario($cod_personal,"A");*/
                return header("Location:http://localhost:8080/requerimiento/vista/bloqueo.php?cantidad=".number_format(round($verificarCuotas,2),2)."&cuota=".number_format(round($cuota,2),2));
            } 
             /*if($hoy['mday'] >= $diassegundaquincena[0] && $hoy['mday'] <= '10'){
                $MensajeBloqueo = 0;  
                return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo."&cantidad=".$verificarCuotas);
             }*/
        }else{
            $MensajeBloqueo = 1;
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php?enlace=".$MensajeBloqueo);
        }
    }
}

?>