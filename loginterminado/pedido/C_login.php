<?php
date_default_timezone_set('America/Lima');
require_once("M_VerificarCuota.php");
require_once("M_Login.php");
require_once("../funciones/f_funcion.php");


   $cod_usuario = $_POST['usuario'];
  
  // print_r($estado);
   
    if ($cod_usuario !="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);
    }else{
        return header("Location: ../index.php");
    }


class C_Login
{
    public function C_usuario($cod_usuario){  
        /*$fec_ingreso = '2022-02-21 00:00:00.000';
        $fec = explode(" ",$fec_ingreso);
        $dato = nuevfech('2',$fec[0]);*/
       //0201 --> SMP2
       //0183 --> 'SMP6'
        //var_dump($dato);
        $dato1 = $this->evaluarCuota('SMP6','0183');
        //print_r($dato1[0]);
        print_r($dato1[1]);
       
        /*$diasrestriccion = 2;
        $arraydias = array('3','6','9');
       
        $m_login = new M_Login(); 

        $datosUsuario = $m_login->Login($cod_usuario);
        if($datosUsuario != ''){
            $c_admins = $m_login->Administradores($datosUsuario['COD_PERSONAL']);
            if($c_admins == ''){
                $fecha = C_Asistenciadias($cod_usuario);
                $dias = diasfalto($fecha); 
                $m_cuotaPersonal = new M_VerificarCuota($datosUsuario['OFICINA']);
                $montoSMP = $m_cuotaPersonal->CuotaPersonal($cod_usuario);
               // print_r($montoSMP);
                $oficina = $datosUsuario['OFICINA'];
            
                if($datosUsuario){
                        if(trim($oficina) == 'SMP2' || trim($oficina) == 'SMP5'){
                            $_cuota = new M_VerificarCuota($datosUsuario['OFICINA']);
                            $montoTotal = $_cuota->VerificandoQuincena($datosUsuario['COD_PERSONAL'],$diasrestriccion,
                            $montoSMP['FEC_INGRESO'],count($dias),$montoSMP['CUOTA']);
                        
                        }else{
                            $montoTotal = $m_login->VerificarCallCenter($datosUsuario['COD_PERSONAL'],$arraydias,
                            $montoSMP['FEC_INGRESO'],$oficina,count($dias),$montoSMP['CUOTA']);
                        }
                       
                        if($montoTotal != ''){
                            f_Cuotas($montoTotal,$montoSMP['CUOTA'],$oficina); 
                        }else{
                            print_r("SIN RESTRICCION");
                        }  
                }else{
                    return header("Location: ../index.php");
                }
            }else{
                print_r("acceso directo");
            } 
        }else{
            //return header("Location: ../index.php");
            print_r("usuario no existe");
        } */    
    }


    function evaluarCuota($oficina,$personal){
        $dia=2; 
        
        $a = new M_VerificarCuota($oficina);
        $b = new M_Login();

        $parametro=$a->CuotaPersonal($personal);
        $cuota=$parametro[0][0];
        $fec_ingreso=$parametro[0][1];
        
        if($cuota !="" and $fec_ingreso !=""){ 
         $fec = explode(" ",$fec_ingreso);
         ///funcion que devuelve las fechas 
         $fechas = nuevfech($dia,$fec[0]);

           if($fechas[0] !=""){
                if(!is_string($fechas[0])){
                    $fech1 =  $fechas[0]->format("d-m-Y");
                }else{
                    $fech1 = $fechas[0];
                }
            $fech2 = $fechas[1];
            $dias =  $fechas[2];
            $fechaIni=retunrFechaSql($fech1);
            $fechaFin=retunrFechaSql($fech2);
         
            if($oficina=="SMP2" or $oficina=="SMP5"){
                $montoTotal=$a->VerificandoQuincena($personal,$fechaIni,$fechaFin);
            }else{
                $montoTotal=$b->VerificarCallCenter($personal,$fechaIni,$fechaFin,$oficina);
            }
                $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias - 1) ,2) : 0; 
                $cuotareal = (($cuota * $dias) - $montoTotal);
              
            if($promedio>=$cuota){
                $opcion=1;
                $mensaje="OK"; 
            }else if($oficina=="SMP2" and $personal=="0002"){
                $opcion=1;
                $mensaje="OK";
            }else{
                $opcion=2;
                $mensaje="No llego a la cuota su promedio es $promedio para estar en cuota  tiene que vender hoy $cuotareal";
            }
               
            }else{
                $opcion=1;
                $mensaje="OK"; 
            }
                return array($opcion,$mensaje);
          }
        }

    }
?>