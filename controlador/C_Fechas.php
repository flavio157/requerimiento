<?php
date_default_timezone_set('America/Lima');

class RangoFechas
{
    public function fechas($diasprimeraquincena,$diassegundaquincena){
       
        $fecha_actual = date("d-m-Y");
        $fecha = getdate();
        $dia = date("d-m-Y",strtotime($fecha_actual."- 1 days"));
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $m = intval($mes) - intval(1); 

            if($fecha['mday']>= $diasprimeraquincena[0] && $fecha['mday'] <= '26'){
                if($mes <= '9'){
                    $mes = '0'.$mes;
                }
                $fechainicial = '12'.'-'. $mes .'-'.$ano;
                $fechafinal =  $dia;
            }

            if($fecha['mday'] >= $diassegundaquincena[0] && $fecha['mday'] <= '11'){
                    if($m <= '9'){
                        $m = '0'.$m;
                    }
                    $fechainicial = '27'.'-'. $m .'-'.$ano;
                    $fechafinal =  $dia;
            }

            return $fechainicial . " " .$fechafinal; 
    }

}
    




?>