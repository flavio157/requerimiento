<?php
date_default_timezone_set('America/Lima');


    function fechas($diasprimeraquincena,$diassegundaquincena,$fec_ingreso){
        $fecha = getdate();
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $fech = explode(" ",$fec_ingreso);
        $separando = explode("-",$fech[0]);
        $dia = date("d-m-Y",strtotime(date("d-m-Y")."- 1 days"));

        if($mes <= '9'){$mes = '0'.$mes; }
        $m = intval($mes) - intval(1); 
        
        $diaingreso1 = $diasprimeraquincena[0] - $separando[2];

        $date1=date_create($diassegundaquincena[0]."-".$mes."-".$ano);
        $date2=date_create($fec_ingreso);
        $diaingreso2 = date_diff($date2,$date1);

        if($separando[0] == $ano && $separando[1] == $mes && $diaingreso1 == 1 || $diaingreso1 <= 0 && $separando[2] <= '26') {
                if( $separando[2] >= ($diasprimeraquincena[0]-1)){
                   return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
                }

        }else if($separando[0] == $ano  && ( $mes - $separando[1]) == 0 ||
                ($mes - $separando[1]) == 1 && $diaingreso2->d == 1 || $diaingreso2->d == 0 ||
                $separando[2] <= '11')          
        {
                        return $separando[1] -1;
        }
        
        
        
        
        else if($fecha['mday'] >= $diasprimeraquincena[0] && $fecha['mday'] <= '26'){
                    $fechainicial = '12'.'-'. $mes .'-'.$ano;
                    $fechafinal =  $dia;
            }
            if($fecha['mday'] >= $diassegundaquincena[0] && $fecha['mday'] <= '11'){
                    if($m <= '9'){ $m = '0'.$m;}
                    $fechainicial = '27'.'-'. $m .'-'.$ano;
                    $fechafinal =  $dia;
            }
            if($diaingreso1 < 0){
               
            }
            
           /* array($fechainicial,$fechafinal);*/
    }






    function f_Cuotas($verificarCuotas,$cuotas,$diasprimeraquincena,$diassegundaquincena){
        
       if($cuotas != '0' && $cuotas != null){
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
       }else{
        return header("Location:http://localhost:8080/requerimiento/vista/Advertencia.php");
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

/*$codigogenerado=generarCodigo(6,4);*/

?>