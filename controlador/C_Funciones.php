<?php
date_default_timezone_set('America/Lima');


    function fechas($diasprimeraquincena,$diassegundaquincena){
        $fecha = getdate();
        $dia = date("d-m-Y",strtotime(date("d-m-Y")."- 1 days"));
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $m = intval($mes) - intval(1); 
            if($fecha['mday'] >= $diasprimeraquincena[0] && $fecha['mday'] <= '26'){
                if($mes <= '9'){$mes = '0'.$mes; }
                    $fechainicial = '12'.'-'. $mes .'-'.$ano;
                    $fechafinal =  $dia;
            }
            if($fecha['mday'] >= $diassegundaquincena[0] && $fecha['mday'] <= '11'){
                    if($m <= '9'){ $m = '0'.$m;}
                    $fechainicial = '27'.'-'. $m .'-'.$ano;
                    $fechafinal =  $dia;
            }
            return array($fechainicial,$fechafinal);
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
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
        }
    }


    function observacionProducto($dataproductos)
    {
        $observacion = "";
        foreach ($dataproductos->arrayproductos as $dato){
            if(isset($dato->cod_producto)){
                $observacion.= $dato->nombre."/ ";
              }  
        }
        return $observacion;  
    }

    function TotalProducto($dataproductos)
    {
        $producto = 0;
        $promocion = 0;
        foreach ($dataproductos->arrayproductos as $dato){
            if(isset($dato->cod_producto)){
                $producto += intval($dato->cantidad);
                $promocion += intval($dato->promocion);
              }  
        }
        $total = $producto + $promocion;
        return $total; 

    }



?>