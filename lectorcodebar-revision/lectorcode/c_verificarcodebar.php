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

            $verificar = new m_codigobarra($oficina);
            $auditorias = $verificar->m_auditoriaPendi($oficina);
            if(strlen($codebar) == 10){
                if(sizeof($auditorias) == 1){
                    $code = $verificar->m_verificarcodebar($codebar,$auditorias[0]['COD_AUDITORIA']);
                    if(sizeof($code) == 1 && $code[0][5] != 1){
                    $fech = retunrFechaSqlphp($auditorias[0][2]);
                    $dato = $verificar->m_actualizarcodebar($codebar,$fech,'1',$usuario);
                    print_r("Se registro el Producto");
                    return;
                    }else if(sizeof($code) == 1 && $code[0][5] == 1){
                        print_r("El producto ya fue registrado");
                        return;
                    }    

                     //if(sizeof($code) == 0){
                        $ningr = $verificar-> m_verificarNNIGR($codebar);
                        if(sizeof($ningr) == 1 && $ningr[0][8] != 1){
                            $verificar->m_actualizarNINGR($codebar);   
                            print_r("Se Registro el pistoleo del codigo");
                            return; 
                        }else if(sizeof($ningr) == 1 && $ningr[0][8] == 1){
                            print_r("El codigo ya fue registrado");
                            return; 
                        }
                        $verificaral = new  m_verficiarproducto();
                        $dato = $verificaral->m_verificarProcAlmaXofi($codebar,$oficina); 
                      
                       
                        if(sizeof($dato) == 1){
                            $fecha = explode(" ", $dato[0][7]);
                            $dias = diferenciaFechas($fecha[0],date("Y-m-d"));
                            if($dias >= 4 && sizeof($ningr) != 1){
                                $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],'M',$dato[0][1], '0');
                                print_r("Se Creo el Producto M" );
                            }else if(sizeof($ningr) != 1) {
                                if($dato[0][10] == 'A' || $dato[0][10] == 'R')$estado = 'A';
                                else if($dato[0][10] == 'O') $estado = 'M';
                                else if($dato[0][10] == 'I') $estado = 'C';
                                print_r($estado);
                                $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],$estado,$dato[0][1], '0');
                                print_r("Se Creo el Producto esl estado");
                            }else{
                                print_r("El codigo ya fue registrado2");
                            }
                        }else{
                            $dato = $verificaral->m_verificarProcAlma($codebar);
                            if(sizeof($dato) == 1){
                                $verificar->m_guardarlote($dato[0][4],$usuario,$auditorias[0][0],'F',$dato[0][1],'0');   
                                print_r("Se Creo el Producto F");
                            }else{
                                print_r("El codigo de barra no existe");
                            } 
                        }
                }else{
                    print_r("No hay auditoria Pendiente");
                }    
            }else{
                print_r("Error codigo de barra invalido");
            }        
        }
    }
?>