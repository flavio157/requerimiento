<?php
    require_once("../funciones/m_verificarcodebar.php");
    require_once("../funciones/m_verificarproducto.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];

   if ($accion == 'verificar') {
        $codigo = $_POST['codebar'];
        $oficina = $_POST['oficina'];
        $usuario = $_POST['usuario'];
        $tipo = $_POST['tipo'];
        c_codigobarra::verificarcodebar($codigo,$oficina,$usuario,$tipo);
    }

    class c_codigobarra
    {
    
        static function verificarcodebar($codebar,$oficina,$usuario,$tipo){
            $verificar = new m_codigobarra($oficina);
            $auditorias = $verificar->m_auditoriaPendi($oficina);
            
            if(strlen($codebar) == 11){
                if(sizeof($auditorias) == 1){
                    if(substr(trim($codebar), 0, 2) == "CM"){
                        $alamcen =new m_verficiarproducto();
                        $combo = $alamcen->m_buscarcombo_producto(trim($codebar));
                        for ($i=0; $i < sizeof($combo) ; $i++) {
                            c_codigobarra::pistoleoProducto($combo[$i][2],$oficina,$usuario,$tipo,$verificar,$auditorias);
                        }
                        return;
                    }else{
                        c_codigobarra::pistoleoProducto($codebar,$oficina,$usuario,$tipo,$verificar,$auditorias);
                    }   
                }else{
                    print_r("Auditoria terminada");
                }   
            }else{
                print_r("Error codigo de barra invalido");
            }         
        }


        static function pistoleoProducto($codebar,$oficina,$usuario,$tipo ,$verificar,$auditorias){
            $code = $verificar->m_verificarcodebar(trim($codebar),$auditorias[0]['COD_AUDITORIA']);
                    if(sizeof($code) == 1 && $code[0][5] != 1){
                        $fech = retunrFechaSqlphp($auditorias[0][2]);
                        $dato = $verificar->m_actualizarcodebar(trim($codebar),$fech,'1',$usuario,$auditorias[0]['COD_AUDITORIA']);
                        print_r("Se registro pistoleo del Producto.\n");
                    }else if(sizeof($code) == 1 && $code[0][5] == 1){
                        print_r("El producto ya fue pistoleado.\n");
                    }else{
                            $ningr = $verificar-> m_verificarNNIGR(trim($codebar));
                            $verificaral = new  m_verficiarproducto();
                            $dato = $verificaral->m_verificarProcAlmaXofi(trim($codebar),$oficina); 
                            
                            if(sizeof($dato) == 1 &&  count($ningr) == 0){
                                $fecha = explode(" ", $dato[0][7]);
                                $dias = diferenciaFechas($fecha[0],date("Y-m-d"));
                                if($dias >= 4 && sizeof($ningr) != 1){
                                    $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],'M',$dato[0][1], '0');
                                    print_r("Se Creo el Producto.\n");
                                    return;
                                }else if(sizeof($ningr) != 1) {
                                    if($dato[0][10] == 'A' || $dato[0][10] == 'R')$estado = 'A';
                                    else if($dato[0][10] == 'O') $estado = 'M';
                                    else if($dato[0][10] == 'I') $estado = 'C';
                                   
                                    $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],$estado,$dato[0][1], '0');
                                    print_r("Se Creo el Producto.\n");
                                    return;
                                }
                            }else if(sizeof($dato = $verificaral->m_verificarProcAlma(trim($codebar))) == 1 && count($ningr) == 0) {
                                    $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],'F',$dato[0][1],'0');   
                                    print_r("Se Creo el Producto.\n");
                                    return;
                            }else if (sizeof($ningr) == 1 && $ningr[0][8] != 1 && $tipo == -1) {
                                $verificar->m_actualizarNINGR(trim($codebar),$usuario);   
                                print_r("Se Registro el pistoleo del producto.\n");
                               // return;
                            }else if(sizeof($ningr) == 1 && $ningr[0][8] == 1){
                                print_r("El producto ya fue pistoleado.\n"); 
                            }else if(sizeof($ningr) > 0 && $ningr[0][8] == 0){
                                print_r("El producto ya fue creado.\n"); 
                            }else{
                                print_r("El producto no existe.\n");
                            }
                    }   
                    if($tipo == -1){
                        $verificar->m_CerrarAuditoria($auditorias[0]['COD_AUDITORIA']);
                    }  
        }
    }
?>