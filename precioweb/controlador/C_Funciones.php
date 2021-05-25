<?php
date_default_timezone_set('America/Lima');


  /*  function fechas($diasprimeraquincena,$diassegundaquincena,$fec_ingreso){
        $fecha = getdate();
        $mes = $fecha['mon'];
        $ano = $fecha['year'];
        $fech = explode(" ",$fec_ingreso);
        $separando = explode("-",$fech[0]);
        $dia = date("d-m-Y",strtotime(date("d-m-Y")."- 1 days"));
        if($mes <= '9'){$mes = '0'.$mes; }
       
        $m = intval($mes) - intval(1); 

        $fquincenaini2=$diassegundaquincena[0]."-".$mes."-".$ano;
        $fquincenafin2='11'."-".$mes."-".$ano;
        $resta_dia = date("d-m-Y",strtotime($fquincenaini2."- 1 days"));
        $fechaIngOrd = $separando[2]."-".$separando[1]."-".$separando[0];

        $fechaIngOrd= new DateTime($fechaIngOrd);
        $resta_dia= new DateTime($resta_dia);
        $fquincenafin2= new DateTime($fquincenafin2);

        if($separando[0] == $ano && $separando[1] == $mes 
            &&  $separando[2] >= ($diasprimeraquincena[0]-1) && $fecha['mday'] <= '26' &&
            $separando[2] <='26') {
            /*dia registro, hasta el dia actual 
            return array($fechaIngOrd,date("d-m-y"),"false");    
        }*/ 

            
      /*  else if($separando[0] == $ano  && (( $mes - $separando[1]) == 0 ||
                ($mes - $separando[1]) == 1) && $fechaIngOrd >=  $resta_dia && date("d-m-y") <= $fquincenafin2  
                && $fechaIngOrd <= $fquincenafin2)      
                {
                   
                return array($fechaIngOrd,date("d-m-y"),"false");     
                /* 30/05/2021 >= 01/06/2021 - 1 days*/ 
                /* 05/06/2021 <= 11/06/2021*/
                /* 30/05/2021 <= 11/06/2021

        }else if($fecha['mday'] >= $diasprimeraquincena[0] && $fecha['mday'] <= '26'){

                    $fechainicial = '12'.'-'. $mes .'-'.$ano;
                    $fechafinal =  $dia;
                    return array($fechainicial, $fechafinal);

        }else if($fecha['mday'] >= $diassegundaquincena[0] && $fecha['mday'] <= '11'){

                if($m <= '9'){ $m = '0'.$m;}
                    $fechainicial = '27'.'-'. $m .'-'.$ano;
                    $fechafinal =  $dia;
                return array($fechainicial, $fechafinal);

        }
    }*/






  /*  function f_Cuotas($verificarCuotas,$cuotas,$diasprimeraquincena,$diassegundaquincena,$nuevo){
        print_r($nuevo);
      if($nuevo){
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
      }else{
            return header("Location: http://localhost:8080/requerimiento/vista/ventana.php");
      }  
    }*/


    




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