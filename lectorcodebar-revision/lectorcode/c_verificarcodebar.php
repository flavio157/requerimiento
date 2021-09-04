<?php
    require_once("../funciones/m_verificarcodebar.php");
    require_once("../funciones/m_verificarproducto.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];

   if ($accion == 'verificar') {
        $codigo = $_POST['codebar'];
        $oficina = $_POST['oficina'];
        $usuario = $_POST['usuario'];
        c_codigobarra::verificarcodebar($codigo,$oficina,$usuario);
    }

    class c_codigobarra
    {

        static function verificarcodebar($codebar,$oficina,$usuario){
           // c_codigobarra::verificarCodBar($codebar);
            $verificar = new m_codigobarra($oficina);
            $auditorias = $verificar->m_auditoriaPendi($oficina);
          //  if(strlen($codebar) == 10){
                if(sizeof($auditorias) == 1){
                    $code = $verificar->m_verificarcodebar($codebar,$auditorias[0]['COD_AUDITORIA']);
                    if(sizeof($code) == 1 && $code[0][5] != 1){
                    $fech = retunrFechaSqlphp($auditorias[0][2]);
                    $dato = $verificar->m_actualizarcodebar($codebar,$fech,'1',$usuario);
                    print_r("Se registro el Producto");
                    }else if(sizeof($code) == 0){
                        $verificaral = new  m_verficiarproducto();
                        $dato = $verificaral->m_verificarProcAlma($codebar);
                        if(sizeof($dato) == 1){
                            $ningr = $verificar-> m_verificarNNIGR($codebar);
                            if(sizeof($ningr) == 0){
                                $fecha = explode(" ", $dato[0][7]);
                                $dias = diferenciaFechas($fecha[0],date("Y-m-d"));
                                if($dias >= 6){
                                    $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],'O',$dato[0][1],
                                    '1');
                                    print_r("Se registro el Producto");
                                }else{
                                    $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],$dato[0][10],$dato[0][1],
                                    '1');
                                    print_r("Se registro el Producto");
                                }
                            }else{
                                print_r("El producto ya fue registrado");
                            }
                            
                        }else{
                        print_r("vuelva a ingresar el codigo");
                        }
                    }else if(sizeof($code) == 1 && $code[0][5] == 1){
                        print_r("El producto ya fue registrado");
                    }
                }else{
                    print_r("No hay auditorias pendientes");
                }
            //}else{
             //   print_r("Error codigo Invalido ");
            //}    
        }
    }
    

?>