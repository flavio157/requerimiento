<?php

class C_Controlar_Cuotas
{
    public $boolean = false;
   
    public function C_Cuotas($cod_personal,$oficina,$zona)
    {
        $m_cuota = new M_Login();
        $m_verificar = $m_cuota->M_Cuotas("cod_personal","oficina","zona");
        if(sizeof($m_verificar) > 0){

          /* $this->C_CalcularDias($m_verificar[CUOTAS]);*/
           
         }
         
    }


    public function C_CalcularDias(){
        $hoy = getdate();

        if($hoy['mday'] >= '12' || $hoy['mday'] >='27')/*si es el dia 12 y 27 de cada mes y no cumplio con cuota*/
        {
            /* se logue y mensaje de advertencia */


            if($hoy['mday']='15' || $hoy['mday']>='30')
            {
                /*si pasado 3 dias sigue igual se invalida la sesion ,funtion de actualizar estado de usuario*/
            }
            $boolean = true;

        }else{
            /*sino no pasa pasa nada se logue normal*/
           /* return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");*/
            $boolean = false;
        }
    }



}


?>