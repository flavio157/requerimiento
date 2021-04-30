<?php
date_default_timezone_set('America/Lima');


    function fechas($diasprimeraquincena,$diassegundaquincena){
       
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



    function f_Cuotas($verificarCuotas,$cuotas,$diasprimeraquincena,$diassegundaquincena){
    $cuotas = $cuotas == '' ? '0' : $cuotas;
        $hoy = getdate();
        if($hoy['mday'] >= $diasprimeraquincena[0] && round($cuotas,2)  > round($verificarCuotas,2)   && $hoy['mday'] <=$diasprimeraquincena[1]){

            if( $hoy['mday'] == $diasprimeraquincena[0] || $hoy['mday'] <= $diasprimeraquincena[1] ){
                return header("Location:http://localhost:8080/requerimiento/vista/bloqueo.php");
            }
        }else if($hoy['mday'] >= $diassegundaquincena[0] &&  round($cuotas,2)  > round($verificarCuotas,2)  && $hoy['mday'] <= $diassegundaquincena[1]){
          
            if($hoy['mday'] == $diassegundaquincena[0] || $hoy['mday'] <= $diassegundaquincena[1]){
                return header("Location:http://localhost:8080/requerimiento/vista/bloqueo.php");
            } 
        }else{
            /*$_SESSION['user_id'] = $cod_usuario["COD_PERSONAL"];*/
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
        }
    }

?>