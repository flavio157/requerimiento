<?php

class C_Controlar_Cuotas
{
    public $MensajeBloqueo = false;
    public $bloqueoUsuario = true;
   
    public function C_Cuotas($cod_personal,$oficina,$zona)
    {
        $m_cuota = new M_Login();
        $m_verificar = $m_cuota->M_Cuotas($cod_personal,$oficina,$zona);
        if(sizeof($m_verificar) > 0){
           $this->C_CalcularDias($m_verificar['CUOTAS'],$cod_personal,$oficina,$zona);
         }else{
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
         }
         
    }




    public function C_CalcularDias($verificarCuotas,$cod_personal,$oficina,$zona){
        $hoy = getdate();
        $m_verificar = new M_Login();
        if($hoy['mday'] >= '12' && $verificarCuotas < 150 )
        {
             if($hoy['mday']>='15'){
                /*si pasado 3 dias sigue igual se invalida la sesion ,function de actualizar estado de usuario y enviar mensaje usuario bloqueado*/

                $m_verificar->M_ActualizarEstadoUsuario($cod_personal,trim($oficina),$zona,"A");
                $bloqueoUsuario = false;
                return header("Location: http://localhost:8080/requerimiento/vista/");

            }else{
                /* se loguea y mensaje de advertencia */
                echo "aun hay tiempo";
                $MensajeBloqueo = false;
                
                 return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");

             }

            
        }else if($hoy['mday'] >= '27' && $verificarCuotas < 150){
            
             if($hoy['mday']>='30'){
                 /*si pasado 3 dias sigue igual se invalida la sesion ,function de actualizar estado de usuario y enviar mensaje usuario bloqueado*/

               
            
            }else{
                $MensajeBloqueo = false;
                /* se loguea y mensaje de advertencia */
                /* return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");*/
             }
        }else{

            echo "no bloqueo";
            /*sino no pasa pasa nada se logue normal*/
            $MensajeBloqueo = true;
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
            
        }
    }



}


?>